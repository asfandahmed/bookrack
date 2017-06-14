<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Messages extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->model('message');
		$this->load->library(array('utility_functions','session','form_validation'));
	}
	public function load_message_panel()
	{
		if($this->utility_functions->is_logged_in())
		{
			$email=$this->session->userdata('email');
			$data['messages'] = $this->message->getAll($email);
			$this->load->view('dialogs/messages.php', $data);
		}
	}
	public function load_compose_panel()
	{
		if($this->utility_functions->is_logged_in()){
			$this->load->view('dialogs/send_message.php');
		}
	}
	public function send_message()
	{
		$data = array();
		if($this->utility_functions->is_logged_in())
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			if($this->form_validation->run() === FALSE){
				$data['success'] = FALSE;
				$data['error'] = 'Error occurred.';
			}else{
				$sender = $this->session->userdata('email');
				$receiver = $this->input->post('email');
				$data['result'] = $this->message->setMessage($sender,$receiver);
				$data['success'] = TRUE;
				echo json_encode($data);
			}
		}
		
	}
	public function show($email="",$skip=0,$limit=50)
	{
		if(strlen($email)>0 && $this->utility_functions->is_logged_in())
		{
			$e1=$this->session->userdata('email');
			$e2=urldecode($email);
			$data['messages']=$this->message->getContent($e1, $e2, $skip, $limit);
			$data['email']=$email;
			$this->load->view('dialogs/send_message.php',$data);
		}
	}
	public function show_all()
	{

	}
}
