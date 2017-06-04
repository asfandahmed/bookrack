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
	public function getRequests($email,$skip=0,$limit=1,$requestType=0)
	{
		if($requestType==0)
			$cypher = "MATCH (u {email:{email}})<-[r:BORROW]-(s) WHERE r.approved='0' RETURN ID(s) as id, s.first_name + ' ' + s.last_name as username, r, ID(r) as rel_id SKIP {skip} LIMIT {limit}";
		else if($requestType==1)
			$cypher = "MATCH (u {email:{email}})-[r:BORROW]->(s) WHERE r.approved='0' RETURN ID(s) as id, s.first_name + ' ' + s.last_name as username, r, ID(r) as rel_id SKIP {skip} LIMIT {limit}";
		return $this->neo->execute_query($cypher,array('email'=>$email,'skip'=>intval($skip),'limit'=>intval($limit)));	
	}
	public function get_borrow($id)
	{
		$node = $this->neo->get_node($id);
		return self::createFromRelationship($node);
	}
	public function set_approve($id="")
	{
		// set 1 for approved
		if($id>0){
			$cypher = "START r=rel({id}) SET r.approved=1 RETURN r";
			return $this->neo->execute_query($cypher,array('id'=>intval($id)));
		}
		
	}
	public function set_ignore($id="")
	{
		// set 2 for ignore
		if($id>0){
			$cypher = "START r=rel({id}) SET r.approved=2 RETURN r";
			return $this->neo->execute_query($cypher,array('id'=>intval($id)));
		}
	}
	public function delete($id)
	{
		return $this->neo->remove_relation(intval($id));
	}
	public function set_borrow($from)
	{
		$to = $this->input->post('to');
		$data = array(
				'to'=>intval($to),
				'from'=>intval($from),
				'requestId'=>uniqid(),
				'bookId'=>$this->input->post('bookId'),
				'bookTitle'=>$this->input->post('bookTitle'),
				'approved'=>"0",
				'date_time'=>time(),
			);
		$cypher = "START n=node({to}), b=node({from})
					CREATE UNIQUE (b)-[r:BORROW {requestId:{requestId}, bookId:{bookId}, bookTitle:{bookTitle}, approved:{approved}, date_time:{date_time}}]->(n)
					RETURN n,b,r";
		return $this->neo->execute_query($cypher,$data);
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