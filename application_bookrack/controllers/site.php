<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('session','common_functions','form_validation'));
	}
	public function home()
	{
		//$this->output->enable_profiler(TRUE);
		if(!$this->common_functions->is_logged_in())
			redirect(site_url());

		$this->load->model(array('user','status','recommendation'));
		$id=$this->session->userdata('user_id');
		$email=$this->session->userdata('email');
		$data['title']='Home - Bookrack';
		$data['user_info']=$this->user->get_basic_info($id);
		$data['suggestions']=$this->recommendation->friendSuggestions($email);


		$count=$this->status->getContentCount($email)->offsetGet(0);
		$config['base_url']=site_url('home');
		$config['total_rows']=$count['total'];
		$config["per_page"]=5;
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$skip=$page*$config["per_page"];
		
		$data['posts']=$this->status->getContent($email,$skip,$config["per_page"]);
		

		$this->load->view('templates/header.php',$data);
		$this->load->view('site/home.php',$data);
		$this->load->view('templates/footer.php');
		//$this->output->enable_profiler(FALSE);
	}
	public function index()
	{
		if($this->common_functions->is_logged_in())
			redirect(site_url('/home'));
		
		$data['title']='Bookrack';
		$data['signin_post_url']='login';
		$data['register_post_url']='register';

		$this->load->view('templates/header-index.php',$data);
		$this->load->view('site/index.php',$data);
		$this->load->view('templates/footer-index.php');
	}
	public function login()
	{
		if($this->common_functions->is_logged_in())
			redirect(site_url('/home'));
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[60]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[25]|xss_clean');
		
		if($this->form_validation->run() === FALSE)
			$this->load_login_form();
		else
		{
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			$error=$this->authenticate($email,$password);
			if($error==0)
				redirect(site_url('/home'));
			elseif($error==2)
				$this->load_login_form("Invalid password for this account.");
			else
				$this->load_login_form("User with {$email} does not exists.");
		}
	}
	private function load_login_form($msg="")
	{
		$data['title']='Login - Bookrack';
		$data['signin_post_url']='login';
		$data['msg']=$msg;
		$this->load->view('templates/header.php',$data);
		$this->load->view('site/login.php');
		$this->load->view('templates/footer.php');
	}
	public function logout()
	{
		if(!$this->common_functions->is_logged_in())
			redirect(site_url());

		$this->session->sess_destroy();
		redirect(site_url('login'));
	}
	public function register()
	{
		if($this->common_functions->is_logged_in())
			redirect(site_url('/home'));

		$data['title']='Sign up - Bookrack';
		$data['register_post_url']='register';
		$this->load->model('user');

		$this->form_validation->set_rules('first_name', 'First name', 'trim|required|min_length[3]|max_length[15]|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|min_length[1]|max_length[15]|xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required|max_length[8]|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[3]|max_length[60]|valid_email|callback_email_check|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[25]|xss_clean');
		$this->form_validation->set_message('email_check','Email already exists.');

		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header.php',$data);
			$this->load->view('site/register.php',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			//print_r($_POST);
			try{
				$user_id=$this->user->set_user();
				$this->session->set_userdata(
					array(
						'user_id'=>$user_id,
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'email'=>strtolower($this->input->post('email')),
						'logged_in'=>true,
						'is_admin'=>0
					));
				redirect(site_url('/home'));
			}
			catch(Exception $e)
			{
				echo '<h3>'.$e->getMessage().'</h3>';		
			}
			
		}
	}
	private function authenticate($email,$password)
	{
		/* 
		error 1: user not found.
		error 2: user password not correct.
		error 0: success.
		*/	
		$this->load->model('user');
		$error=1;
		try
		{
			$result=$this->user->check_user_exists($email);
			if(!$result)
				$error=1;
			else
			{
				if(sha1($password)!=$result[0]['n.password'])
					 $error=2;
				else
				{
					$error=0;
					$this->session->set_userdata(
						array(
							'user_id'=>$result[0]['n.id'],
							'first_name'=>$result[0]['n.first_name'],
							'last_name'=>$result[0]['n.last_name'],
							'email'=>$email,
							'admin'=>$result[0]['n.is_admin'],
							'profile_image'=>$result[0]['n.profile_image'],
							'logged_in'=>true,
						));
				}
					 
			}
			return $error;
		}
		catch(Exception $e)
		{
			echo '<h3>'.$e->getMessage().'</h3>';
		}
		
	}
	public function email_check($value)
	{
		if(!$this->user->check_user_exists($value))
			return TRUE;
		return FALSE;
	}
}