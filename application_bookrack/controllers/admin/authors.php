<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authors extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('author');
		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation','common_functions'));
		
	}
	public function index()
	{
		$this->redirect_user();
			
		$this->load->library('pagination');
		$data['title'] = "Admin - Author";
		$count=$this->author->count()->offsetGet(0);
		$config['base_url']=site_url('admin/authors');
		$config['total_rows']=$count['total'];
		$config["per_page"]=10;
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$fields = array('ID(n) as id','n.name');
		$data['results']=$this->author->fetch($fields, $config["per_page"], $page);
		$data['links']=$this->pagination->create_links();
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/author/index.php',$data);
		$this->load->view('admin/templates/footer.php');
	}
	public function insert()
	{	
		$this->redirect_user();

		$data['title'] = "Insert - Author";
		$data['buttonText']="Insert";
		$data['post_url']="/admin/authors/insert";
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/author/insert.php');
			$this->load->view('admin/author/form.php');
			$this->load->view('admin/templates/footer.php');
		}
		else
		{
			$this->author->set_author();
			echo 'success';
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/author/insert.php');
			$this->load->view('admin/author/form.php');
			$this->load->view('admin/templates/footer.php');
		}
	}
	public function update($id)
	{	
		$this->redirect_user();

		$data['title'] = "Update - Author";
		$data['buttonText']="Save";
		$data['post_url']="/admin/authors/update";
		$author=$this->author->get($id);
		foreach ($author->getProperties() as $key => $value) {
			$author_data[$key]=$value;
		}
		$author_data['id']=$author->getId();
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/author/form.php',$author_data);
			$this->load->view('admin/templates/footer.php');
		}
		else
		{
			$this->author->update_author();
			echo 'success';
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/author/form.php');
			$this->load->view('admin/templates/footer.php');
		}
	}
	public function view($id)
	{
		$this->redirect_user();

		$data['title'] = "View - Author";
		$author=$this->author->get($id);
		foreach ($author->getProperties() as $key => $value) {
			$author_data[$key]=$value;
		}
		$author_data['id']=$author->getId();
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/author/view.php',$author_data);
		$this->load->view('admin/templates/footer.php');
	}
	public function delete()
	{
		$this->redirect_user();
		if(isset($_POST)){
			$id=intval($_POST['node_id']);
			$this->author->delete($id);
			$data['msg']="successfully deleted";
			echo json_encode($data);
		}
		
		//$data['title'] = "Delete - Author";
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