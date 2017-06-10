<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Publishers extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('publisher');
		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation','common_functions'));
	}
	public function index()
	{
		$this->redirect_user();
		
		$this->load->library('pagination');
		$data['title'] = "Admin - Publisher";
		$count=$this->publisher->count()->offsetGet(0);
		$config['base_url']=site_url('admin/publishers');
		$config['total_rows']=$count['total'];
		$config["per_page"]=10;
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$fields = array('ID(n) as id', 'n.company');
		$data['results']=$this->publisher->fetch($fields, $config["per_page"], $page);
		$data['links']=$this->pagination->create_links();
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/publisher/index.php',$data);
		$this->load->view('admin/templates/footer.php');
	}
	public function insert()
	{	
		$this->redirect_user();

		$data['title'] = "Insert - Publisher";
		$data['buttonText']="Insert";
		$data['post_url']="/admin/publishers/insert";
		$this->form_validation->set_rules('company', 'Company', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/publisher/insert.php');
			$this->load->view('admin/publisher/form.php');
			$this->load->view('admin/templates/footer.php');
		}
		else
		{
			$this->publisher->set_publisher();
			echo 'success';
		}
	}
	public function update($id)
	{	
		$this->redirect_user();

		$data['title'] = "Update - Publisher";
		$data['buttonText']="Save";
		$data['post_url']="/admin/publishers/update";
		$publisher=$this->publisher->get($id);
		$publisher_data=array();
		foreach ($publisher->getProperties() as $key => $value) {
			$publisher_data[$key]=$value;
		}
		$publisher_data['id']=$publisher->getId();
		$this->form_validation->set_rules('company', 'Company', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/publisher/form.php',$publisher_data);
			$this->load->view('admin/templates/footer.php');
		}
		else
		{
			$this->publisher->update_publisher();
			echo 'success';
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/publisher/form.php');
			$this->load->view('admin/templates/footer.php');
		}
	}
	public function view($id)
	{
		$this->redirect_user();

		$data['title'] = "View - Publisher";
		$publisher=$this->publisher->get($id);
		foreach ($publisher->getProperties() as $key => $value) {
			$publisher_data[$key]=$value;
		}
		$publisher_data['id']=$publisher->getId();
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/publisher/view.php',$publisher_data);
		$this->load->view('admin/templates/footer.php');
	}
	public function delete()
	{
		$this->redirect_user();

		if(isset($_POST)){
			$id=intval($_POST['node_id']);
			$this->publisher->delete($id);
			$data['msg']="successfully deleted";
			echo json_encode($data);
		}

		//$data['title'] = "Delete - Publisher";
		//$this->load->view('admin/templates/header.php',$data);
		
		//$this->load->view('admin/templates/footer.php');
	}
	public function redirect_user()
	{
		if(!$this->common_functions->is_admin()==1)
			redirect(site_url());
	}
}
?>