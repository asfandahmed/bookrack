<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Likes extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model(array('like','notification'));
		$this->load->library(array('session','common_functions'));
	}
	public function like_post($postId)
	{
		if(isset($postId)){
			$email = $this->session->userdata['email'];
			$result = $this->like->setLike($email,$postId);
			echo json_encode($result);	
		}
		return null;
	}
	public function unlike_post($postId)
	{
		if(isset($postId)){
			$email = $this->session->userdata['email'];
			echo json_encode($this->like->deleteLike($email,$postId));
		}
		return null;
	}
}