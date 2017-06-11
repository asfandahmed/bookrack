<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->library('recommendation');		
	}
	public function index() {
		$a = $this->recommendation->book_suggestions('asfandahmed1@gmail.com');
		var_dump($a);
	}
}