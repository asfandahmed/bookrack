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
	public function show_post($id)
	{
		
	}
	public function loadContent($skip,$limit)
	{
		$email=$this->session->userdata('load_profile_email');
		$skip=is_numeric($skip) ? $skip : die();
		$limit=is_numeric($limit) ? $limit : die();
		$data['limit']=$limit;
		$data['skip']=$skip;
		$data['posts']=$this->status->getContent($email,$skip,$limit);
		$this->load->view('post/post.php',$data);
	}
	public function delete()
	{
		//die(print_r($_POST));
		$data = array();
		$this->form_validation->set_rules('statusId','Post','trim|required|xss_clean');
		if($this->form_validation->run() === FALSE){
			$data['success']=false;
			$data['error']="Error occurred.";
		}else{

			$email = $this->session->userdata('email');
			$statusId = $this->input->post('statusId');
			$data['post'] = $this->status->deleteStatus($email,$statusId);
			$data['success']=true;
			$data['error']="Post deleted!";
		}
		return json_encode($data);
	}
	protected static function is_owner()
	{

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