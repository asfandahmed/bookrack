<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Publisher extends MY_Model
{
	public $id;
	public $company="";
	public $desriptions="";
	public $date_time="";
	
	public function __construct() {
		parent::__construct();
	}

	public function set_publisher()
	{
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$data=array(
			'company'=>$this->input->post('company'),
			'dateTime'=>mdate($datestring, $time),
			);
		$this->neo->insert('Publisher',$data);
	}
	public function update_publisher(){
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$id=intval($this->input->post('id'));
		$data=array(
			'company'=>$this->input->post('company'),
			'dateTime'=>mdate($datestring, $time),
			);
		$this->neo->update($id,$data);	
	}
	
	public function fromNode(Everyman\Neo4j\Node $node){
		$publisher = new Publisher();
		$publisher->id=$node->getId();
		$publisher->company=$node->getProperty('company');
		$publisher->description=$node->getProperty('description');
		$publisher->date_time=$node->getProperty('dateTime');
		return $publisher;
	}
}