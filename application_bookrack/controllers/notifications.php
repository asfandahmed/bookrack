<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notifications extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('notification');
		$this->load->helper(array('url'));
		$this->load->library(array('common_functions','session'));
	}
	public function index()
	{
		$data['title']='Notifications - Bookrack';
		$this->load->view('templates/header.php',$data);
		$this->load->view('notification/index.php');
		$this->load->view('templates/footer.php');
	}
}