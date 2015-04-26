<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*  
*/
class Review extends CI_Model
{
	public $reviewId;
	public $bookId;
	public $userId;
	public $ratings;
	public $reviewText;
	public $date_time;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
	protected static function createFromRelationship(Everyman\Neo4j\Node $node)
	{
		$review = new Review();
		$review->bookId = $node->getProperty('bookId');
		$review->userId = $node->getProperty('userId');
		$review->ratings = $node->getProperty('ratings');
		$review->reviewText = $node->getProperty('reviewText');
		$review->date_time = gmdate("F j, Y g:i a", $node->getProperty('date_time'));
		return $review;
	}
}
?>