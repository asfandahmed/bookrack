<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Statuses extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('status');
		$this->load->helper(array('url','form'));
		$this->load->library(array('common_functions','form_validation'));
	}
	public function post()
	{
		//die(print_r($_POST));
		$data=array();
		$this->form_validation->set_rules('status','Post','trim|required|xss_clean');
		if($this->form_validation->run() === FALSE){
			$data['success']=false;
			$data['error']="Seems like your post is empty.";
		}
			
		else{
			$this->status->setStatus();
			$data['success']=true;
			$data['error']="Posted!";
		}
		echo json_encode($data);	
	}
}