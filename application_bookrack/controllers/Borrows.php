<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Borrows extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('common_functions','form_validation','session'));
		$this->load->helper(array('url'));
		$this->load->model(array('borrow','notification'));
	}
	public function index()
	{
		if($this->common_functions->is_logged_in())
		{
			$data['title']='Borrow requests - '.APP_NAME;
			$this->load->view('templates/header.php',$data);
			$this->load->view('borrow/index.php',$data);
			$this->load->view('templates/footer.php');
		}
	}
	public function loadsent($skip,$limit){
		if($this->common_functions->is_logged_in()){
			$email=$this->session->userdata('email');
			$skip=is_numeric($skip) ? $skip : die($skip);
			$limit=is_numeric($limit) ? $limit : die($limit);
			$data['sent'] = $this->borrow->getRequests($email,$skip,$limit,1);
			$this->load->view('borrow/sent.php',$data);
		}
	}
	public function loadreceived($skip,$limit){
		if($this->common_functions->is_logged_in()){
			$email=$this->session->userdata('email');
			$skip=is_numeric($skip) ? $skip : die($skip);
			$limit=is_numeric($limit) ? $limit : die($limit);
			$data['received'] = $this->borrow->getRequests($email,$skip,$limit);
			$this->load->view('borrow/received.php',$data);
		}
	}
	public function insert()
	{
		if($this->common_functions->is_logged_in())
		{
			$id = $this->session->userdata('user_id');
			$to = $this->input->post('to');
			$n = new Notification();
			$n->notificationText = "sent you borrow request.";
			$n->setNotification($to, $n,"2447abd42eab8764");
			$result = $this->borrow->set_borrow($id);
			echo json_encode($result);
		}
	}
	public function approve($id="")
	{
		if($this->common_functions->is_logged_in())
		{
			$data=array();
			if($id>0){
				$data['result'] = $this->borrow->set_approve($id);
				$data['status'] = "success!";
			}else
				$data['status'] = "failure!";
			return json_encode($data);
		}
	}
	public function ignore($id="")
	{
		if($this->common_functions->is_logged_in())
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
	public function cancel($id="")
	{
		if($this->common_functions->is_logged_in())
		{	
			$data=array();
			if($id>0){
				$data['result'] = $this->borrow->delete($id);
				$data['status'] = "success!";
			}else
				$data['status'] = "failure!";
			return json_encode($data);
		}
	}
}