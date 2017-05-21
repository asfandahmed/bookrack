<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comments extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('comment');
		$this->load->library(array('session','common_functions','form_validation'));
	}
	public function get_all_comments($postId)
	{
		if($this->common_functions->is_logged_in())
		{
			$limit=20;
			$skip=0;
			$data['comments'] = $this->comment->getContent($postId,$skip,$limit);
			$this->load->view('dialogs/comments.php',$data);
		}
	}
	public function get_comment()
	{

	}
	/*******************
	Get user id from session and check if comment text and status id are given. Save if everthing goes well.
	@returns comment, request status and error message in json object.
	*******************/
	public function set_comment()
	{
		$id = $this->session->userdata('user_id');
		$this->form_validation->set_rules('comment','Comment','trim|required');
		$this->form_validation->set_rules('statusId','StatusId','required|callback_check_val[strsts]');
		$this->form_validation->set_rules('strsts','','required');
		if($this->form_validation->run() === FALSE){
			$data['success']=FALSE;
			$data['error']="Seems like your comment is empty.";
		}
		else{
			$data['comment']=$this->comment->setComment($id);
			$data['success']=TRUE;
			$data['error']="Posted!";
		}
		echo json_encode($data);
	}
	/***********************************************************
	Convert plain value to hash and compare with hash. This is callback function for setcomment validation
	@param plain orginal value 
	@param hash value of orginal
	@returns boolean
	************************************************************/
	public function check_val($plain,$hash){
		if($this->input->post($hash)==sha1($plain))
			return TRUE;
		$this->form_validation->set_message('Why you do this?');
		return FALSE;
	}
}