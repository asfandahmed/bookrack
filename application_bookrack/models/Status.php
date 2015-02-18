<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Status extends CI_Model{
	var $post="";
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
	public function getStatus()
	{

	}
	public function setStatus()
	{
		$this->load->library('session');
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$date_time=mdate($datestring, $time);
		$data=array(
			'post'=>$this->input->post('status'),
			);
		$relationData=array(
			'date_time'=>$date_time,
			);
		$nodeId = $this->neo->insert('Status',$data);
		$userId = $this->session->userdata('user_id');
		$this->neo->add_relation($userId,$nodeId,'POSTED',$relationData);
		return $nodeId;
	}
	public function deleteStatus()
	{

	}
	public function updateStatus()
	{

	}
}
/* End of file Neo.php */