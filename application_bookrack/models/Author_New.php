<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Author_New extends MY_Model
{
	public $id;
	public $user_id;
	public $name;
	public $description;
	public $param;
	public $created_by;
	public $created_on;

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	public function prepare_input() {
		$this->load->library('input');
		$this->user_id 		= $this->input->post('user_id',TRUE);
		$this->name 		= $this->input->post('name',TRUE);
		$this->description 	= $this->input->post('description',TRUE);
		$this->created_by	= $this->session->userdata('user_id');
		$this->created_on 	= $this->get_date();
		return $this;
	}
	
	
}