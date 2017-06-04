<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('author_new');
		$this->load->helper('date');
		
	}
	public function index() {
		var_dump($this->author_new->param('abc','a')->get_param('abc'));
	}
}