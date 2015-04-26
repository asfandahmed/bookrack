<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Comment extends CI_Model
{
    public $node;
	public $nodeId;
	public $commentId;
	public $userId;
	public $postId;
	public $commentText;
	public $date_time;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
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
        $results = $this->neo->execute_query($queryString,array(
            's'=>$statusId,
            'commentText'=>$comment->commentText,
            'userId'=>$comment->userId,
            'commentId'=>uniqid(),
            'timestamp'=>time(),
            ));
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
                $row['p']
            );
        }

        return $mappedContentArray;
    }
	protected static function createFromNode(Everyman\Neo4j\Node $node)
    {
        $comment = new Comment();
        $comment->node = $node;
        $comment->nodeId = $node->getId();
        $comment->commentId = $node->getProperty('commentId');
        $comment->commentText = $node->getProperty('commentText');
        $comment->date_time = gmdate("F j, Y g:i a", $node->getProperty('date_time'));
        return $comment;
    }
}