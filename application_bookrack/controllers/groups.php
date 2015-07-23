<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Groups extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->library(array('common_functions','session','form_validation'));
	}
	public function index()
	{

		$data['title'] = 'Groups - '.APP_NAME;
		$this->load->view('templates/header.php',$data);
		$this->load->view('groups/page.php');
		$this->load->view('templates/footer.php');	
	}

}