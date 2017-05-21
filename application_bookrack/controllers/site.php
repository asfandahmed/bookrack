<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Site controller class (default controller)
 *
 * @author  Asfand yar Ahmed
 */
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
		$data['title']='Home - '.APP_NAME;
		$data['user_info']=$this->user->get_basic_info($id);

		$data['folllow_suggestions']=$this->recommendation->friend_suggestions($email);
		$data['book_suggestions']=$this->recommendation->book_suggestions($email);
		$this->load->view('templates/header.php',$data);
		$this->load->view('site/home.php',$data);
		$this->load->view('templates/footer.php');
		//$this->output->enable_profiler(FALSE);
	}
	public function index()
	{
		if($this->common_functions->is_logged_in())
			redirect(site_url('/home'));
		
		$data['title'] = APP_NAME;
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
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[25]');
		
		if($this->form_validation->run() === FALSE)
			$this->load_login_form();
		else
		{
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			$error=$this->authenticate($email,$password);
			if($error===0)
				redirect(site_url('/home'));
			elseif($error===2)
				$this->load_login_form("Invalid password for this account.");
			else
				$this->load_login_form("User with {$email} does not exists.");
		}
	}
	private function load_login_form($msg="")
	{
		$data['title']='Login - '.APP_NAME;
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

		$data['title']='Sign up - '.APP_NAME;
		$data['register_post_url']='register';
		$this->load->model('user');

		$this->form_validation->set_rules('first_name', 'First name', 'trim|required|min_length[3]|max_length[15]');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|min_length[1]|max_length[15]');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required|max_length[8]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[3]|max_length[60]|valid_email|callback_email_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[25]');
		$this->form_validation->set_message('email_check','Email already exists.');

		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header.php',$data);
			$this->load->view('site/register.php',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			try{
				$user_id=$this->user->set_user();
				$this->session->set_userdata(
					array(
						'user_id'=>$user_id,
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'email'=>strtolower($this->input->post('email')),
						'username'=>substr($email, 0, strpos($email, '@')),
						'logged_in'=>TRUE,
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
	public function about(){
		$data['title'] = 'About - '.APP_NAME;
		if($this->common_functions->is_logged_in()){
			$this->load->view('templates/header.php', $data);
			$this->load->view('site/about.php', $data);
			$this->load->view('templates/footer.php');	
		}else{
			$this->load->view('templates/header-index.php', $data);
			$this->load->view('site/about.php', $data);
			$this->load->view('templates/footer-index.php');	
		}
		
	}
	public function privacy(){
		$data['title'] = 'Privacy - '.APP_NAME;
		if($this->common_functions->is_logged_in()){
			$this->load->view('templates/header.php', $data);
			$this->load->view('site/privacy.php', $data);
			$this->load->view('templates/footer.php');	
		}else{
			$this->load->view('templates/header-index.php', $data);
			$this->load->view('site/privacy.php', $data);
			$this->load->view('templates/footer-index.php');	
		}
	}
	public function help(){
		$data['title'] = 'Help - '.APP_NAME;
		if($this->common_functions->is_logged_in()){
			$this->load->view('templates/header.php', $data);
			$this->load->view('site/help.php', $data);
			$this->load->view('templates/footer.php');	
		}else{
			$this->load->view('templates/header-index.php', $data);
			$this->load->view('site/help.php', $data);
			$this->load->view('templates/footer-index.php');	
		}
	}
	public function feedback(){
		$data['title'] = 'Feedback - '.APP_NAME;
		if($this->common_functions->is_logged_in()){
			$this->load->view('templates/header.php', $data);
			$this->load->view('site/feedback.php', $data);
			$this->load->view('templates/footer.php');	
		}else{
			$this->load->view('templates/header-index.php', $data);
			$this->load->view('site/feedback.php', $data);
			$this->load->view('templates/footer-index.php');	
		}
	}
	public function advertise(){
		$data['title'] = 'Advertise - '.APP_NAME;
		if($this->common_functions->is_logged_in()){
			$this->load->view('templates/header.php', $data);
			$this->load->view('site/advertise.php', $data);
			$this->load->view('templates/footer.php');	
		}else{
			$this->load->view('templates/header-index.php', $data);
			$this->load->view('site/advertise.php', $data);
			$this->load->view('templates/footer-index.php');	
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
				if(sha1($password)!==$result[0]['n.password'])
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
							'username'=>$result[0]['n.username'],
							'admin'=>$result[0]['n.is_admin'],
							'profile_image'=>$result[0]['n.profile_image'],
							'logged_in'=>TRUE,
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

/* End of file site.php */
/* Location: ./application/controllers/site.php */
