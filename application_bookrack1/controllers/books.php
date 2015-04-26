<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Books extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('book');
		$this->load->helper(array('url'));
		$this->load->library(array('common_functions','session'));
	}
	public function index($id){
		$data["title"]="Book";
		$data['book']=$this->book->get_book($id);
		$this->load->view('templates/header.php',$data);
		$this->load->view('book/index.php');
		$this->load->view('templates/footer.php');
	}

}