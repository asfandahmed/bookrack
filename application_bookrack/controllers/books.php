<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Books extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('book');
		$this->load->helper(array('url','form'));
		$this->load->library(array('common_functions','session'));
	}
	public function index($id){
		$book = $this->book->get_book($id);
		$data["title"]=ucfirst($book->title).' - '.APP_NAME;
		$data['book']=$book;
		$this->load->view('templates/header.php',$data);
		$this->load->view('book/index.php');
		$this->load->view('templates/footer.php');
	}

}