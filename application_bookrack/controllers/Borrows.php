<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Borrows extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('common_functions','form_validation','session'));
		$this->load->helper(array('url'));
		$this->load->model(array('borrow','notification'));
	}
	public function index()
	{
		$data['title']='Borrow requests - Bookrack';
		$email=$this->session->userdata('email');
		$data['requests'] = $this->borrow->getAll($email);
		$this->load->view('templates/header.php',$data);
		$this->load->view('borrow/index.php',$data);
		$this->load->view('templates/footer.php');
	}
	public function insert()
	{
		$id = $this->session->userdata('user_id');
		$to = $this->input->post('to');
		$n = new Notification();
		$n->notificationText = "sent you borrow request.";
		$n->setNotification($to, $n,"2447abd42eab8764");
		$result = $this->borrow->set_borrow($id);
		echo json_encode($result);
	}
	public function approve($id="")
	{
		$data=array();
		if($id>0){
			$data['result'] = $this->borrow->set_approve($id);
			$data['status'] = "success!";
		}else
			$data['status'] = "failure!";
		return json_encode($data);
	}
	public function ignore($id="")
	{
		$data=array();
		if($id>0){
			$data['result'] = $this->borrow->set_ignore($id);
			$data['status'] = "success!";
		}else
			$data['status'] = "failure!";
		return json_encode($data);
	}
}