<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DefaultController extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library('utility_functions');
	}
	public function index()
	{
		$this->redirect_user();
		
		$data['title']="Dashboard - Bookrack";
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/default/index.php');
		$this->load->view('admin/templates/footer.php');
	}
	public function redirect_user()
	{
		if(!$this->utility_functions->is_admin()==1)
			redirect(site_url());
	}
}
?>