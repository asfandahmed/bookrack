<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Likes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('like');
		$this->load->library(array('session','common_functions'));
	}
	public function like_post()
	{
		return $this->like->setLike($userId,$postId);
	}
	public function unlike_post()
	{
		$id=0;
		$this->like->deleteLike($id);
	}
}