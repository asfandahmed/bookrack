<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authors extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('author');
		$this->load->helper(array('url'));
		$this->load->library(array('common_functions','session'));
	}
	public function index($id){
		$data["title"]="Author";
		$data['author']=$this->author->get_author($id);
		$this->load->view('templates/header.php',$data);
		$this->load->view('author/index.php');
		$this->load->view('templates/footer.php');
	}
}