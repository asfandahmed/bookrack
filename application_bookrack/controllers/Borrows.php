<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Borrows extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('common_functions','form_validation','session'));
		$this->load->helper(array('url'));
		$this->load->model(array('borrow'));
	}
	public function insert()
	{
		//die(print_r($_POST));
		$id = $this->session->userdata('user_id');
		echo json_encode($this->borrow->set_borrow($id));
	}
}