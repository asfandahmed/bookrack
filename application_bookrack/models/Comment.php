<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Note: This is clone of review class, if a design issue or bug found in this model then it should be fixed in review class also.
*/
Class Comment extends CI_Model
{
    public $node;
	public $nodeId;
	public $commentId;
	public $userId;
    public $postId;
    public $username;
    public $fullname;
    public $image;
	public $commentText;
	public $date_time;
	
	public function __construct()
    {
        parent::__construct();
        $this->load->library(array('neo','session'));

    }
    public function setComment($userId)
    {   
        $statusId = $this->input->post('statusId');
        $comment = new Comment();
        $comment->commentId = uniqid();
        $comment->userId = $userId;
        $comment->commentText = $this->input->post('comment');
        $comment->image = base_url().'assets/uploads/thumbs/'.$this->session->userdata('profile_image');
        $comment->fullname = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');
        $comment->username = $this->session->userdata('username');
        return Comment::add($statusId, $comment);
    }
    protected static function add($statusId, Comment $comment)
    {
        $queryString = <<<CYPHER
MATCH (post { statusId: {s}})
OPTIONAL MATCH (post)-[r:CURRENTCOMMENT]->(currentcomment)
DELETE r
CREATE (post)-[:CURRENTCOMMENT]->(c:Comment { commentText:{commentText}, userId:{userId}, date_time:{timestamp}, commentId:{commentId} })
WITH c, collect(currentcomment) as currentcomment
FOREACH (x IN currentcomment | CREATE c-[:NEXTCOMMENT]->x)
RETURN c, {s} as status
CYPHER;
        $CI = get_instance();
        $CI->neo->execute_query($queryString,array(
            's'=>$statusId,
            'commentText'=>$comment->commentText,
            'userId'=>$comment->userId,
            'commentId'=>uniqid(),
            'timestamp'=>time(),
            ));
        return $comment; 
    }
    public static function edit(Comment $comment)
    {
        $updatedAt = time();

        $node = $comment->node;
        $node->setProperty('commentText', $comment->commentText);
        //$node->setProperty('url', $content->url);
        // $node->setProperty('tagstr', $content->tagstr);
        $node->setProperty('updated', $updatedAt);
        $node->save();

        $comment->updated = $updatedAt;

        return $comment;
    }
    public static function delete($statusId, $commentId)
    {
        $queryString = self::getDeleteQueryString($email, $statusId);

        $params = array(
            'commentId' => $commentId,
            'statusId' => $statusId,
        );

        $this->neo->execute_query($queryString,$params);
    }
    public static function isCurrentPost($statusId, $commentId)
    {
        $queryString = <<<CYPHER
MATCH (s:Status { statusId: { id }})-[:CURRENTCOMMENT]->(c:Comment { commentId: { commentId }}) RETURN c
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
                'commentId' => $commentId,
                'statusId' => $statusId,
            ));

        return count($result) !== 0;
    }
    public static function isLeafPost($statusId, $commentId)
    {
        $queryString = <<<CYPHER
MATCH (s:Status { statusId: { statusId }})-[:CURRENTCOMMENT|NEXTCOMMENT*0..]->(c:Comment { commentId: { commentId }})
WHERE NOT (c)-[:NEXTPOST]->()
RETURN c
CYPHER;

        $result = $this->neo->execute_query($queryString,array(
                'commentId' => $commentId,
                'statusId' => $statusId,
            ));
        return count($result) !== 0;
    }
    protected static function getDeleteQueryString($statusId, $commentId)
    {
        if (self::isLeafPost($statusId, $commentId)) {
            return <<<CYPHER
MATCH (s:Status { statusId: { statusId }})-[:CURRENTCOMMENT|NEXTCOMMENT*0..]->(c:Comment { commentId: { commentId }})
WITH c
MATCH (c)-[r]-()
DELETE c, r
CYPHER;
        }

        if (self::isCurrentPost($email, $statusId)) {
            return <<<CYPHER
MATCH (s:Status { statusId: { statusId }})-[lp:CURRENTCOMMENT]->(del:Comment { commentId: { commentId }})-[np:NEXTCOMMENT]->(nextComment)
CREATE UNIQUE (s)-[:CURRENTCOMMENT]->(nextComment)
DELETE lp, del, np
CYPHER;
        }

        return <<<CYPHER
MATCH (s:Status { statusId: { statusId }})-[:CURRENTCOMMENT|NEXTCOMMENT*0..]->(before),
    (before)-[delBefore]->(del:Comment { commentId: { commentId }})-[delAfter]->(after)
CREATE UNIQUE (before)-[:NEXTCOMMENT]->(after)
DELETE del, delBefore, delAfter
CYPHER;
    }

    public static function getContentCount($statusId)
    {
        $queryString = <<<CYPHER
MATCH (s:Status { statusId: { statusId }})
WITH s
MATCH (c:Comment)-[:NEXTCOMMENT*0..]-(l)-[:CURRENTCOMMENT]-(s)
RETURN COUNT(c) as total
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
                'statusId' => $statusId,
            ));
        return self::returnMappedContent($result);
    }

    public static function getContent($statusId, $skip, $limit)
    {
        $queryString = <<<CYPHER
MATCH (s:Status { statusId: { statusId }})
WITH s
MATCH (c:Comment)-[:NEXTCOMMENT*0..]-(l)-[:CURRENTCOMMENT]-(s)
OPTIONAL MATCH(u:User)
WHERE ID(u)=c.userId
RETURN c, u.first_name+' '+u.last_name as full_name, u.profile_image as image, u.username as username ORDER BY c.timestamp SKIP {skip} LIMIT {limit}
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString,array(
                'skip' => intval($skip),
                'limit' => intval($limit),
                'statusId' => $statusId,
            ));
        return self::returnMappedContent($result);
    }

    public static function getContentById($statusId, $commentId)
    {
        $queryString = <<<CYPHER
MATCH (s:Status { statusId: { statusId }})
WITH s
MATCH (c:Comment { commentId: { commentId }})-[:NEXTCOMMENT*0..]-(l)-[:CURRENTCOMMENT]-(s)
RETURN c
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
                'commentId' => $commentId,
                'statusId' => $statusId,
            ));
        return self::returnMappedContent($result);
    }
	protected static function returnMappedContent(Everyman\Neo4j\Query\ResultSet $results)
    {
        $mappedContentArray = array();
        foreach($results as $row) {
            $mappedContentArray[] = self::createFromNode(
                $row['c'],
                $row['username'],
                $row['full_name'],
                $row['image']
            );
        }

        return $mappedContentArray;
    }
	protected static function createFromNode(Everyman\Neo4j\Node $node, $username="null", $fullname="null", $image="null")
    {
        $comment = new Comment();
        $comment->node = $node;
        $comment->nodeId = $node->getId();
        $comment->commentId = $node->getProperty('commentId');
        $comment->commentText = $node->getProperty('commentText');
        $comment->userId = $node->getProperty('userId');
        $comment->username = $username;
        $comment->fullname = $fullname;
        $comment->image = $image;
        $comment->date_time = gmdate("F j, Y g:i a", $node->getProperty('date_time'));
        return $comment;
    }
}