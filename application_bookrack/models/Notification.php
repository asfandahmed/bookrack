<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends CI_Model
{
	public $node;
	public $nodeId;
	public $notificationId;
	public $notificationText;
	public $date_time;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
	protected static function add($email, Notification $notification)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: {email}})
OPTIONAL MATCH (u)-[r:CURRENTNOTIFICATION]->(currentnotification)
DELETE r
CREATE (u)-[:CURRENTNOTIFICATION]->(n:Notification { notificationText:{notificationText}, date_time:{timestamp}, notificationId:{notificationId} })
WITH n, collect(currentnotification) as currentnotification
FOREACH (x IN currentnotification | CREATE n-[:NEXTNOTIFICATION]->x)
RETURN n, {email} as email
CYPHER;
        $results = $this->neo->execute_query($queryString,array(
            'email'=>$email,
            'notificationText'=>$notification->notificationText,
            'notificationId'=>uniqid(),
            'timestamp'=>time(),
            ));
    }
    public static function edit(Notification $notification)
    {
        $updatedAt = time();

        $node = $notification->node;
        $node->setProperty('notificationText', $notification->notificationText);
        //$node->setProperty('url', $content->url);
        // $node->setProperty('tagstr', $content->tagstr);
        $node->setProperty('updated', $updatedAt);
        $node->save();

        $notification->updated = $updatedAt;

        return $notification;
    }
    public static function delete($email, $notificationId)
    {
        $queryString = self::getDeleteQueryString($email, $notificationId);

        $params = array(
            'notificationId' => $notificationId,
            'email' => $email,
        );

        $this->neo->execute_query($queryString,$params);
    }
    public static function isCurrentPost($email, $notificationId)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTNOTIFICATION]->(n:Notification { notificationId: { notificationId }}) RETURN n
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
                'notificationId' => $notificationId,
                'email' => $email,
            ));

        return count($result) !== 0;
    }
    public static function isLeafPost($email, $notificationId)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTNOTIFICATION|NEXTNOTIFICATION*0..]->(n:Notification { notificationId: { notificationId }})
WHERE NOT (n)-[:NEXTPOST]->()
RETURN n
CYPHER;

        $result = $this->neo->execute_query($queryString,array(
                'notificationId' => $notificationId,
                'email' => $email,
            ));
        return count($result) !== 0;
    }
    protected static function getDeleteQueryString($email, $notificationId)
    {
        if (self::isLeafPost($email, $notificationId)) {
            return <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTNOTIFICATION|NEXTNOTIFICATION*0..]->(n:Notification { notificationId: { notificationId }})
WITH n
MATCH (n)-[r]-()
DELETE n, r
CYPHER;
        }

        if (self::isCurrentPost($email, $notificationId)) {
            return <<<CYPHER
MATCH (u:User { email: { email }})-[lp:CURRENTNOTIFICATION]->(del:Notification { notificationId: { notificationId }})-[np:NEXTNOTIFICATION]->(nextNotification)
CREATE UNIQUE (u)-[:CURRENTNOTIFICATION]->(nextNotification)
DELETE lp, del, np
CYPHER;
        }

        return <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTNOTIFICATION|NEXTNOTIFICATION*0..]->(before),
    (before)-[delBefore]->(del:Notification { notificationId: { notificationId }})-[delAfter]->(after)
CREATE UNIQUE (before)-[:NEXTNOTIFICATION]->(after)
DELETE del, delBefore, delAfter
CYPHER;
    }
    public static function getContentById($email, $notificationId)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { email }})
WITH u
MATCH (n:Notification { notificationId: { notificationId }})-[:NEXTNOTIFICATION*0..]-(l)-[:CURRENTNOTIFICATION]-(u)
RETURN n
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
                'noficationId' => $notificationId,
                'email' => $email,
            ));
        return self::returnMappedContent($result);
    }
	protected static function returnMappedContent(Everyman\Neo4j\Query\ResultSet $results)
    {
        $mappedContentArray = array();
        foreach ($results as $row) {
            $mappedContentArray[] = self::createFromNode(
                $row['p']
            );
        }

        return $mappedContentArray;
    }
	protected static function createFromNode(Everyman\Neo4j\Node $node)
    {
        $notification = new Notification();
        $notification->node = $node;
        $notification->nodeId = $node->getId();
        $notification->notificationId = $node->getProperty('notificationId');
        $notification->notificationText = $node->getProperty('notificationText');
        $notification->date_time = gmdate("F j, Y g:i a", $node->getProperty('date_time'));
        return $notification;
    }
}