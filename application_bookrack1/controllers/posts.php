<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Posts extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		//$this->load->library(array('session','common_functions'));
	}
}