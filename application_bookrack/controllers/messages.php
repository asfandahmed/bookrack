<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Messages extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->model('message');
		$this->load->library(array('common_functions','session','form_validation'));
	}
	public function load_message_panel()
	{
		$email=$this->session->userdata('email');
		$data['messages'] = $this->message->getAll($email);
		$this->load->view('dialogs/messages.php', $data);
	}
	public function load_compose_panel()
	{
		$this->load->view('dialogs/send_message.php');
	}
	public function send_message()
	{
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
		if($this->form_validation->run() === FALSE){
			die("go to hell!");
		}else{
			$sender = $this->session->userdata('email');
			$receiver = $this->input->post('email');
			echo json_encode($this->message->setMessage($sender,$receiver));
		}
		
	}
	public function show($email="")
	{
		if(strlen($email)>0)
		{
			$e1=$this->session->userdata('email');
			$e2=urldecode($email);
			$skip=0;
			$limit=50;
			$data['messages']=$this->message->getContent($e1, $e2, $skip, $limit);
			$data['email']=$email;
			$this->load->view('dialogs/send_message.php',$data);
		}
	}
	public function show_all()
	{

	}
}
