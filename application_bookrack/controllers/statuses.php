<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Statuses extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('status','user'));
		$this->load->helper(array('url','form'));
		$this->load->library(array('common_functions','form_validation','session'));
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
			$data['status']=$this->status->setStatus();
			$data['success']=true;
			$data['error']="Posted!";
		}
		echo json_encode($data);	
	}
	public function loadContent()
	{
		//$id = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		/*
		if($this->has_current_profile($id))
			$email=$this->session->userdata['email'];	
		else{
			$data['user']=$this->user->get($id);
			$email=$data['user']->email;		
		}*/
		$email=$this->session->userdata('load_profile_email');
		$skip=is_numeric($_POST['offset']) ? $_POST['offset'] : die();
		$limit=is_numeric($_POST['number']) ? $_POST['number'] : die();
		$data['posts']=$this->status->getContent($email,$skip,$limit);
		$this->load->view('post/post.php',$data);
	}
	private function has_current_profile($id)
	{
		$id=intval($id);
		$user_id=intval($this->session->userdata['user_id']);
		if($user_id===$id)
			return TRUE;
		return FALSE;
	}
}