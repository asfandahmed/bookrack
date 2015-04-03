<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Borrow extends CI_Model
{
	public $requestId;
	public $bookId;
	public $bookTitle;
	public $to;
	public $from;
	public $approved;
	public $date_time;

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('neo'));
	}
	public function get_borrow($id)
	{
		$node = $this->neo->get_node($id);
		return self::createFromRelationship($node);
	}
	public function set_borrow($from)
	{
		$to = $this->input->post('to');
		$data = array(
				'requestId'=>uniqid(),
				'bookId'=>$this->input->post('bookId'),
				'bookTitle'=>$this->input->post('bookTitle'),
				'approved'=>"1",
				'date_time'=>time(),
			);
		//die(print_r($data));
		return $this->neo->add_relation($from,$to,'BORROW',$data);
	}
	protected static function createFromRelationship(Everyman\Neo4j\Relationship $relation)
    {
        $borrow = new Borrow();
        $borrow->requestId = $relation->getProperty('requestId');
        $borrow->nodeId = $relation->getId();
        $borrow->bookId = $relation->getProperty('bookId');
        $borrow->to = $relation->getProperty('borrowRequestTo');
        $borrow->from = $relation->getProperty('borrowRequestFrom');
        $borrow->approved = $relation->getProperty('approved');
        $borrow->date_time = gmdate("F j, Y g:i a", $relation->getProperty('date_time'));
        return $borrow;
    }
}
?>