<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Publishers extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('publisher');
		$this->load->helper(array('url'));
		$this->load->library(array('common_functions','session'));
	}
	public function index($id){
		$data["title"]="Publisher";
		$data['publisher']=$this->publisher->get($id);
		$this->load->view('templates/header.php',$data);
		$this->load->view('publisher/index.php');
		$this->load->view('templates/footer.php');
	}
}