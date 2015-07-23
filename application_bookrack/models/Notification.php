<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Notification Class
 *
 * @author  Asfand yar Ahmed
 */
class Notification extends CI_Model
{
	public $node;
	public $nodeId;
	public $notificationId;
	public $notificationText;
	public $date_time;

	function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
        $this->load->library('GCM');
	}
    public function setNotification($email, Notification $n, $regId="")
    {
        $obj = self::add($email, $n);
        $json = json_encode($obj);
        if(strlen($regId)>0)
            self::send_notification($regId,$json);
    }
	protected static function add($email, Notification $notification)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: {email}})
OPTIONAL MATCH (u)-[r:CURRENTNOTIFICATION]->(currentnotification)
DELETE r
CREATE (u)-[:CURRENTNOTIFICATION]->(n:Notification { notificationText:{notificationText}, date_time:{timestamp}, notificationId:{notificationId} })
WITH n, collect(currentnotification) as currentnotifications
FOREACH (x IN currentnotifications | CREATE n-[:NEXTNOTIFICATION]->x)
RETURN n, {email} as email
CYPHER;
        $CI  = get_instance();
        return $results = $CI->neo->execute_query($queryString,array(
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
    public static function getContent($email,$skip=0,$limit=10)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { u }})
WITH DISTINCT u
MATCH u-[:CURRENTNOTIFICATION]-lp-[:NEXTNOTIFICATION*0..]-p
RETURN p
ORDER BY p.timestamp desc SKIP {skip} LIMIT {limit}
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString,array(
                'u' => $email,
                'skip' => intval($skip),
                'limit'=>intval($limit),
            ));
        if($result)
            return self::returnMappedContent($result);
    }
    /**
    * @param email address of user
    * @return node 
    **/
    public static function check_unread($email)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { u }})
MATCH u-[:CURRENTNOTIFICATION]-p
MATCH u-[:CURRENTMESSAGE]-m
MATCH u<-[r:BORROW]-b
WHERE p.read = FALSE OR m.read = FALSE OR  r.read =FALSE
RETURN p.read = FALSE as has_notification, m.read=FALSE as has_message, r.read=FALSE as has_request
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString,array(
                'u' => $email,
            ));
        if($result)
            return self::returnMappedContent($result);
    }
    public static function mark_read()
    {}
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
    protected static function getDeviceIdByEmail($email)
    {
        $cypher = "MATCH (n:User {email: {email} }) RETURN n.device_gcm_id as regId";
        $CI  = $CI = get_instance();
        $result = $CI->neo->execute_query($cypher, array('email'=>$email));
    }
    public static function send_notification($registatoin_ids, $message) 
    {

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        //echo $result;
    }
}