<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Author extends MY_Model
{
	public $id;
	public $name="";
	public $description="";
	public $address="";
	public $contact="";
	public $date_time="";
	public function __construct()
	{
		parent::__construct();
	}
	public function set_author()
	{
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$data=array(
			'name'=>$this->input->post('name'),
			'address'=>$this->input->post('address'),
			'contact'=>$this->input->post('contact'),
			'dateTime'=>mdate($datestring, $time),
			);
		$this->neo->insert('Author',$data);
	}
	public function update_author(){
		$this->load->helper('date');
		$id=intval($this->input->post('id'));
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$data=array(
			'name'=>$this->input->post('name'),
			'address'=>$this->input->post('address'),
			'contact'=>$this->input->post('contact'),
			'dateTime'=>mdate($datestring, $time),
			);
		$this->neo->update($id,$data);
	}
	protected function fromNode(Everyman\Neo4j\Node $node){
		$author = new Author();
		$author->id=$node->getId();
		$author->name=$node->getProperty('name');
		$author->description=$node->getProperty('description');
		$author->address=$node->getProperty('address');
		$author->contact=$node->getProperty('contact');
		$author->date_time=$node->getProperty('dateTime');
		return $author;
	}
}