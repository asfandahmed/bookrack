<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Statuses controller class
 *
 * @author  Asfand yar Ahmed
 */
Class Statuses extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('status','user'));
		$this->load->helper(array('url','form'));
		$this->load->library(array('utility_functions','form_validation','session'));
	}
	public function post()
	{
		$data=array();
		$this->form_validation->set_rules('status','Post','trim|required');
		if($this->form_validation->run() === FALSE){
			$data['success']=FALSE;
			$data['error']="Seems like your post is empty.";
		}
			
		else{
			$data['status']=$this->status->setStatus();
			$data['success']=TRUE;
			$data['error']="Posted!";
		}
		echo json_encode($data);	
	}
	public function show_post($id)
	{
		
	}
	public function loadContent($skip,$limit)
	{
		if($this->utility_functions->is_logged_in())
		{
			$profile = FALSE;
			if($this->uri->segment(2)=="profile")
				$profile = TRUE;

			$email=$this->session->userdata('email');
			$skip=is_numeric($skip) ? $skip : die($skip);
			$limit=is_numeric($limit) ? $limit : die($limit);	
			$data['posts']=$this->status->get_statuses($email, $skip, $limit);
			$this->load->view('post/post.php',$data);	
		}
		
	}
	public function delete()
	{
		$data = array();
		$this->form_validation->set_rules('statusId','Post','trim|required');
		if($this->form_validation->run() === FALSE){
			$data['success']=FALSE;
			$data['error']="Error occurred.";
		}else{

			$email = $this->session->userdata('email');
			$statusId = $this->input->post('statusId');
			$data['post'] = $this->status->deleteStatus($email,$statusId);
			$data['success']=TRUE;
			$data['error']="Post deleted!";
		}
		echo json_encode($data);
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