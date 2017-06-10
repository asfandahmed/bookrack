<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Genre extends MY_Model
{
	public $name="";
	public $date_time="";
	const GENRE = 0;
	public function __construct() {
		parent::__construct();
	}
	
	public function set_genre()
	{
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$data=array(
			'name'=>$this->input->post('name'),
			'dateTime'=>mdate($datestring, $time),
			);
		$this->neo->insert('Genre',$data);
	}
	
	public function update_genre(){
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$id=intval($this->input->post('id'));
		$data=array(
			'name'=>$this->input->post('name'),
			'dateTime'=>mdate($datestring, $time),
			);
		$this->neo->update($id,$data);	
	}
}