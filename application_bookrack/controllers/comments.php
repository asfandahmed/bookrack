<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comments extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('comment');
		$this->load->library(array('session','common_functions','form_validation'));
	}
	public function get_all_comments($postId)
	{
		$limit=10;
		$skip=0;
		$data['comments'] = $this->comment->getContent($postId,$skip,$limit);
		echo json_encode($data);
	}
	public function get_comment()
	{

	}
	public function set_comment()
	{
		$id = $this->session->userdata('user_id');
		$this->form_validation->set_rules('comment','Comment','trim|required|xss_clean');
		$this->form_validation->set_rules('statusId','StatusId','trim|required|xss_clean');
		if($this->form_validation->run() === FALSE){
			$data['success']=false;
			$data['error']="Seems like your post is empty.";
		}
		else{
			$data['comment']=$this->comment->setComment($id);
			$data['success']=true;
			$data['error']="Posted!";
		}
		echo json_encode($data);
	}
}