<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Review extends CI_Model
{
    public $node;
	public $nodeId;
	public $reviewId;
	public $userId;
    public $bookId;
    public $username;
    public $fullname;
    public $image;
	public $reviewText;
	public $date_time;
	
	public function __construct()
    {
        parent::__construct();
        $this->load->library(array('neo','session'));

    }
    public function setReview($userId)
    {
        $bookId = $this->input->post('bookId');
        $review = new Review();
        $review->userId = $userId;
        $review->reviewText = $this->input->post('review');
        $review->image = base_url().'assets/uploads/thumbs/'.$this->session->userdata('profile_image');
        $review->fullname = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');
        $review->username = $this->session->userdata('username');
        return Review::add($bookId, $review);
    }
    protected static function add($bookId, Review $review)
    {
        $queryString = <<<CYPHER
MATCH (book) WHERE ID(book) = {s}
OPTIONAL MATCH (book)-[r:CURRENTREVIEW]->(currentreivew)
DELETE r
CREATE (book)-[:CURRENTREVIEW]->(c:Review { reviewText:{reviewText}, userId:{userId}, date_time:{timestamp}, reviewId:{reviewId} })
WITH c, collect(currentreivew) as currentreivew
FOREACH (x IN currentreivew | CREATE c-[:NEXTREVIEW]->x)
RETURN c, {s} as book
CYPHER;
        $CI = get_instance();
        $CI->neo->execute_query($queryString,array(
            's'=>intval($bookId),
            'reviewText'=>$review->reviewText,
            'userId'=>$review->userId,
            'reviewId'=>uniqid(),
            'timestamp'=>time(),
            ));
        return $review; 
    }
    public static function edit(Review $review)
    {
        $updatedAt = time();

        $node = $review->node;
        $node->setProperty('reviewText', $review->reviewText);
        //$node->setProperty('url', $content->url);
        // $node->setProperty('tagstr', $content->tagstr);
        $node->setProperty('updated', $updatedAt);
        $node->save();

        $review->updated = $updatedAt;

        return $review;
    }
    public static function delete($bookId, $reviewId)
    {
        $queryString = self::getDeleteQueryString($reviewId, $bookId);

        $params = array(
            'reviewId' => $reviewId,
            'bookId' => $bookId,
        );

        $this->neo->execute_query($queryString,$params);
    }
    public static function isCurrentReview($bookId, $reviewId)
    {
        $queryString = <<<CYPHER
MATCH (b:Book) WHERE ID(b)={bookId} (b)-[:CURRENTREVIEW]->(c:Review { reviewId: { reviewId }}) RETURN b
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
                'reviewId' => $reviewId,
                'bookId' => intval($bookId)
            ));

        return count($result) !== 0;
    }
    public static function isLeafReview($bookId, $reviewId)
    {
        $queryString = <<<CYPHER
MATCH (b:Book) WHERE ID(b)={bookId} (b)-[:CURRENTREVIEW|NEXTREVIEW*0..]->(c:Review { reviewId: { reviewId }})
WHERE NOT (c)-[:NEXTPOST]->()
RETURN b
CYPHER;

        $result = $this->neo->execute_query($queryString,array(
                'reviewId' => $reviewId,
                'bookId' => intval($bookId)
            ));
        return count($result) !== 0;
    }
    protected static function getDeleteQueryString($bookId, $reviewId)
    {
        if (self::isLeafReview($bookId, $reviewId)) {
            return <<<CYPHER
MATCH (b:Book) WHERE ID(b)={bookId} (b)-[:CURRENTREVIEW|NEXTREVIEW*0..]->(c:Review { reviewId: { reviewId }})
WITH c
MATCH (c)-[r]-()
DELETE c, r
CYPHER;
        }

        if (self::isCurrentReview($bookId, $reviewId)) {
            return <<<CYPHER
MATCH (b:Book) WHERE ID()={bookId} (b)-[lp:CURRENTREVIEW]->(del:Review { reviewId: { reviewId }})-[np:NEXTREVIEW]->(nextReview)
CREATE UNIQUE (b)-[:CURRENTREVIEW]->(nextReview)
DELETE lp, del, np
CYPHER;
        }

        return <<<CYPHER
MATCH (b:Book) WHERE ID(b)={bookId} (b)-[:CURRENTREVIEW|NEXTREVIEW*0..]->(before),
    (before)-[delBefore]->(del:Review { reviewId: { reviewId }})-[delAfter]->(after)
CREATE UNIQUE (before)-[:NEXTREVIEW]->(after)
DELETE del, delBefore, delAfter
CYPHER;
    }

    public static function getContentCount($bookId)
    {
        $queryString = <<<CYPHER
MATCH (b:Book) WHERE ID(b)={bookId}
WITH b
MATCH (c:Review)-[:NEXTREVIEW*0..]-(l)-[:CURRENTREVIEW]-(b)
RETURN COUNT(c) as total
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
                'bookId' => intval($bookId),
            ));
        return self::returnMappedContent($result);
    }

    public static function getContent($bookId, $skip, $limit)
    {
        $queryString = <<<CYPHER
MATCH (b:Book) WHERE ID(b)={bookId}
WITH b
MATCH (c:Review)-[:NEXTREVIEW*0..]-(l)-[:CURRENTREVIEW]-(b)
OPTIONAL MATCH(u:User)
WHERE ID(u)=c.userId
RETURN c, u.first_name+' '+u.last_name as full_name, u.profile_image as image, u.username as username ORDER BY c.timestamp SKIP {skip} LIMIT {limit}
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString,array(
                'skip' => intval($skip),
                'limit' => intval($limit),
                'bookId' => intval($bookId),
            ));
        return self::returnMappedContent($result);
    }

    public static function getContentById($bookId, $reviewId)
    {
        $queryString = <<<CYPHER
MATCH (b:Book) WHERE ID(b)={bookId}
WITH b
MATCH (c:Review { reviewId: { reviewId }})-[:NEXTREVIEW*0..]-(l)-[:CURRENTREVIEW]-(b)
RETURN c
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
                'reviewId' => $reviewId,
                'bookId' => intval($bookId),
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
	protected static function createFromNode(Everyman\Neo4j\Node $node, $username=NULL, $fullname=NULL, $image=NULL)
    {
        $review = new Review();
        $review->node = $node;
        $review->nodeId = $node->getId();
        $review->reviewId = $node->getProperty('reviewId');
        $review->reviewText = $node->getProperty('reviewText');
        $review->userId = $node->getProperty('userId');
        $review->username = $username;
        $review->fullname = $fullname;
        $review->image = $image;
        $review->date_time = gmdate("F j, Y g:i a", $node->getProperty('date_time'));
        return $review;
    }
}