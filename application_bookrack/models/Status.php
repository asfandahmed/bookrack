<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Status extends CI_Model{
	public $post;
	public $node;
	public $nodeId;
	public $statusId;
	public $date_time;
	public $owner;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
	public function getStatus()
	{

	}
	public function setStatus()
	{
		$this->load->library('session');
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$date_time=mdate($datestring, $time);
		$data=array(
			'post'=>$this->input->post('status'),
			);
		$relationData=array(
			'date_time'=>$date_time,
			);
		$nodeId = $this->neo->insert('Status',$data);
		$userId = $this->session->userdata('user_id');
		$this->neo->add_relation($userId,$nodeId,'POSTED',$relationData);
		return $nodeId;
	}
	public function deleteStatus()
	{

	}
	public function updateStatus()
	{

	}
	/**
     * Adds content
     *
     * @param  string    $username User adding content
     * @param  Content   $content  Content to add
     * @return Content[]
     */
    public static function add($email, Status $status)
    {
        $queryString = <<<CYPHER
MATCH (user { email: {u}})
OPTIONAL MATCH (user)-[r:CURRENTPOST]->(currentpost)
DELETE r
CREATE (user)-[:CURRENTPOST]->(p:Status { post:{title}, url:{url}, date_time:{timestamp}, statusId:{contentId} })
WITH p, collect(currentpost) as currentposts
FOREACH (x IN currentposts | CREATE p-[:NEXTPOST]->x)
RETURN p, {u} as username, true as owner
CYPHER;

        /*$query = new Query(
            Neo4jClient::client(),
            $queryString,
            array(
                'u' => $username,
                'title' => $content->title,
                'url' => $content->url,
                'tagstr' => $content->tagstr,
                'timestamp' => time(),
                'contentId' => uniqid(),
            )
        );*/
        $result = $this->neo->execute_query($queryString,array(
        		'u' => $email,
                'title' => $status->title,
                'url' => $status->url,
                // 'tagstr' => $content->tagstr,
                'timestamp' => time(),
                'contentId' => uniqid(),
        	));

        return self::returnMappedContent($result);
    }

    /**
     * Edit content
     *
     * @param  Content $content Content to edit
     * @return Content Edited content
     */
    public static function edit(Status $status)
    {
        $updatedAt = time();

        $node = $status->node;
        $node->setProperty('post', $status->post);
        $node->setProperty('url', $content->url);
        // $node->setProperty('tagstr', $content->tagstr);
        $node->setProperty('updated', $updatedAt);
        $node->save();

        $status->updated = $updatedAt;

        return $content;
    }

    /**
     * Delete content and create relationships between remaining content as appropriate
     *
     * @param string $username  Username of content owner
     * @param string $contentId Content id
     */
    public static function delete($email, $statusId)
    {
        $queryString = self::getDeleteQueryString($email, $statusId);

        $params = array(
            'email' => $email,
            'statusId' => $statusId,
        );

        /*$query = new Query(Neo4jClient::client(), $queryString, $params);
        $query->getResultSet();*/
        $this->neo->execute_query($queryString,$params);
    }

    /**
     * Returns true if Content is the most recent, or current, Content item
     *
     * @param  string  $username  Username of content owner
     * @param  string  $contentId Content id
     * @return boolean True if Content is most recent, false otherwise
     */
    public static function isCurrentPost($email, $statusId)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTPOST]->(c:Status { statusId: { statusId }}) RETURN c
CYPHER;

        /*$query = new Query(
            Neo4jClient::client(),
            $queryString,
            array(
                'username' => $username,
                'contentId' => $contentId,
            )
        );*/

        // $result = $query->getResultSet();
		$result = $this->neo->execute_query($queryString,array(
				'email' => $email,
                'statusId' => $statusId,
			));

        return count($result) !== 0;
    }

    /**
     * Returns true if Content is the final, and oldest, Content item in the list
     *
     * @param  string  $username  Username of content owner
     * @param  string  $contentId Content id
     * @return boolean True if Content is last, false otherwise
     */
    public static function isLeafPost($email, $statusId)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTPOST|NEXTPOST*0..]->(c:Status { statusId: { statusId }})
WHERE NOT (c)-[:NEXTPOST]->()
RETURN c
CYPHER;

        /*$query = new Query(
            Neo4jClient::client(),
            $queryString,
            array(
                'username' => $username,
                'contentId' => $contentId,
            )
        );

        $result = $query->getResultSet();
*/
        $result = $this->neo->execute_query($queryString,array(
        		'email' => $email,
                'statusId' => $statusId,
        	));
        return count($result) !== 0;
    }

	/**
     * Gets the appropriate DELETE query based on where in the list the Content appears
     *
     * @param  string $username  Username of content owner
     * @param  string $contentId Content id
     * @return string Cypher query to delete Content
     */
    protected static function getDeleteQueryString($email, $statusId)
    {
        if (self::isLeafPost($email, $statusId)) {
            return <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTPOST|NEXTPOST*0..]->(c:Status { statusId: { statusId }})
WITH c
MATCH (c)-[r]-()
DELETE c, r
CYPHER;
        }

        if (self::isCurrentPost($email, $statusId)) {
            return <<<CYPHER
MATCH (u:User { email: { email }})-[lp:CURRENTPOST]->(del:Status { statusId: { statusId }})-[np:NEXTPOST]->(nextPost)
CREATE UNIQUE (u)-[:CURRENTPOST]->(nextPost)
DELETE lp, del, np
CYPHER;
        }

        return <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTPOST|NEXTPOST*0..]->(before),
    (before)-[delBefore]->(del:Status { statusId: { statusId }})-[delAfter]->(after)
CREATE UNIQUE (before)-[:NEXTPOST]->(after)
DELETE del, delBefore, delAfter
CYPHER;
    }

	/**
     * Gets content by contentId
     *
     * @param  string    $username  Username
     * @param  string    $contentId Content id
     * @return Content[]
     */
    public static function getContentById($email, $statusId)
    {
        $queryString = <<<CYPHER
MATCH (usr:User { email: { u }})
WITH usr
MATCH (p:Status { statusId: { statusId }})-[:NEXTPOST*0..]-(l)-[:CURRENTPOST]-(u)
RETURN p, u.email AS username, u = usr AS owner
CYPHER;

/*        $query = new Query(
            Neo4jClient::client(),
            $queryString,
            array(
                'u' => $username,
                'contentId' => $contentId,
            )
        );

        $result = $query->getResultSet();
*/
        $result = $this->neo->execute_query($queryString,array(
        		'u' => $email,
                'statusId' => $contentId,
        	));
        return self::returnMappedContent($result);
    }

	/**
     * Gets content from user's friends
     *
     * We're doing LIMIT 4. At present we're only displaying 3. the extra
     * item is to ensure there's more to view, so the next skip will be 3,
     * then 6, then 12
     *
     * @param  string    $username
     * @param  int       $skip     Records to skip
     * @return Content[]
     */
    public static function getContent($email, $skip)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { u }})-[:FOLLOWS*0..1]->f
WITH DISTINCT f, u
MATCH f-[:CURRENTPOST]-lp-[:NEXTPOST*0..]-p
RETURN p, f.email as username, f=u as owner
ORDER BY p.timestamp desc SKIP {skip} LIMIT 4
CYPHER;
/*
        $query = new Query(
            Neo4jClient::client(),
            $queryString,
            array(
                'u' => $username,
                'skip' => $skip,
            )
        );
        $result = $query->getResultSet();*/
        $result = $this->neo->execute_query($queryString,array(
        		'u' => $email,
                'skip' => $skip,
        	));
        return self::returnMappedContent($result);
    }
	/**
     * Creates array of Content from ResultSet
     *
     * @param  ResultSet $results
     * @return Content[]
     */
    protected static function returnMappedContent(ResultSet $results)
    {
        $mappedContentArray = array();

        foreach ($results as $row) {
            $mappedContentArray[] = self::createFromNode(
                $row['p'],
                $row['username'],
                $row['owner']
            );
        }

        return $mappedContentArray;
    }
	protected static function createFromNode(Node $node, $username = null, $owner = false)
    {
        $status = new Status();
        $status->node = $node;
        $status->nodeId = $node->getId();
        $status->statusId = $node->getProperty('statusId');
        $status->post = $node->getProperty('post');
        $status->url = $node->getProperty('url');
        // $status->tagstr = $node->getProperty('tagstr');
        $status->date_time = gmdate("F j, Y g:i a", $node->getProperty('date_time'));
        $status->owner = $owner;
        // $status->userNameForPost = $username;

        return $content;
    }
}
/* End of file Neo.php */