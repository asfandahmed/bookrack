<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reviews extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('review');
		$this->load->library(array('session','common_functions','form_validation'));
	}
	public function get_all_reviews($bookId)
	{
		if($this->common_functions->is_logged_in())
		{
			$limit=20;
			$skip=0;
			$data['reviews'] = $this->review->getContent($bookId,$skip,$limit);
			$this->load->view('dialogs/reviews.php',$data);
		}
	}
	public function get_review()
	{

	}
	/*******************
	Get user id from session and check if review text and status id are given. Save if everthing goes well.
	@returns review, request status and error message in json object.
	*******************/
	public function set_review()
	{
		$id = $this->session->userdata('user_id');
		$this->form_validation->set_rules('review','Review','trim|required');
		$this->form_validation->set_rules('bookId','BookId','required|callback_check_val[strrv]');
		$this->form_validation->set_rules('strrv','','required');
		if($this->form_validation->run() === FALSE){
			$data['success']=FALSE;
			$data['error']="Seems like your review is empty.";
		}
		else{
			$data['review']=$this->review->setReview($id);
			$data['success']=TRUE;
			$data['error']="Posted!";
		}
		echo json_encode($data);
	}
	/***********************************************************
	Convert plain value to hash and compare with hash. This is callback function for setreview validation
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