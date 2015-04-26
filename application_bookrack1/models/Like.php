<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Like extends CI_Model
{
	var $user="";
	var $post="";
	var $date_time="";
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
	public function getLike($id)
	{
		return $id;
	}
	public function setLike($userId,$postId)
	{
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$date_time=mdate($datestring, $time);
		$data=array(
			'date_time'=>$date_time,
			);
		return $this->neo->add_relation($userId,$postId,"LIKES",$data);
	}
	public function updateLike($id)
	{
		return $id;
	}
	public function deleteLike($id)
	{
		$this->neo->delete_relation($id);
	}
}