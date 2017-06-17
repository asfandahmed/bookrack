<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Publisher extends MY_Model
{
	public $id;
	public $company;
	public $desription;
	public $timestamp;
	
	public function __construct() {
		parent::__construct();
	}

	public function set_publisher()
	{
		$data = $this->set_input_values();
		$this->neo->insert('Publisher', $data);
	}
	public function update_publisher()
	{
		$id=intval($this->input->post('id'));
		$data = $this->set_input_values();
		$this->neo->update($id,$data);	
	}
	private function set_input_values()
	{
		return array(
			'company'=>$this->input->post('company'),
			'description'=>$this->input->post('description'),
			'timestamp'=>time(),
			);
	}
	public function fromNode(Everyman\Neo4j\Node $node)
	{
		$publisher = new Publisher();
		$publisher->id=$node->getId();
		$publisher->company=$node->getProperty('company');
		$publisher->description=$node->getProperty('description');
		$publisher->timestamp=$node->getProperty('timestamp');
		return $publisher;
	}
}