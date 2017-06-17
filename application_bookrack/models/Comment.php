<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends CI_Model
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
        $this->load->model('linked_list');
    }
    public function setComment($userId)
    {   
        $statusId = $this->input->post('statusId');
        $text = $this->input->post('comment');
        $comment = array(
            'commentId'=> uniqid(),
            'userId'=>$userId,
            'commentText'=>$text,
            'timestamp'=>time(),
            );
        $result = $this->linked_list->add('Status', 'statusId', $statusId, get_class(), $comment);
        return $this->return_mapped_content($result);
    }
    public function get_comments($status_id, $skip=0, $limit=5){
        $results = $this->linked_list->get_content('Status','statusId',$status_id, get_class(), $skip, $limit);
        return self::return_mapped_content($results);
    }
    
    public static function edit(Comment $comment)
    {
        $updatedAt = time();
        $node = $comment->node;
        $node->setProperty('commentText', $comment->commentText);
        $node->setProperty('updated', $updatedAt);
        $node->save();
        $comment->updated = $updatedAt;

        return $comment;
    }
    
	public function return_mapped_content(Everyman\Neo4j\Query\ResultSet $results)
    {
        $mappedContentArray = array();
        foreach($results as $row) {
            $mappedContentArray[] = self::createFromNode(
                $row['m']
            );
        }

        return $mappedContentArray;
    }
	public function FromNode(Everyman\Neo4j\Node $node, $username="null", $fullname="null", $image="null")
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