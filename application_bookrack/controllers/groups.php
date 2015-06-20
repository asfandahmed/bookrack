<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Groups extends CI_Controller
{

public function __construct()
	{
		parent::__construct();
		$this->load->model(array('user','status'));
		$this->load->helper(array('url','form'));
		$this->load->library(array('common_functions','session','form_validation','pagination'));
	}

	public function index()
	{

		$this->load->view('templates/header.php');
		$this->load->view('groups/page.php');
		$this->load->view('templates/footer.php');
		
		}


}