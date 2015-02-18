<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Genres extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('genre');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library(array('form_validation','common_functions'));
	}
	public function index()
	{
		$this->redirect_user();

		$this->load->library('pagination');
		$data['title'] = "Admin - Genre";
		$count=$this->genre->count()->offsetGet(0);
		$config['base_url']=site_url('admin/genres');
		$config['total_rows']=$count['total'];
		$config["per_page"]=10;
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$data['results']=$this->genre->fetch($config["per_page"], $page);
		$data['links']=$this->pagination->create_links();
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/genre/index.php',$data);
		$this->load->view('admin/templates/footer.php');
	}
	public function insert()
	{	
		$this->redirect_user();

		$data['title'] = "Insert - Genre";
		$data['buttonText']="Insert";
		$data['post_url']="/admin/genres/insert";
		$this->form_validation->set_rules('name', 'Name', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/genre/insert.php');
			$this->load->view('admin/genre/form.php');
			$this->load->view('admin/templates/footer.php');
		}
		else
		{
			$this->genre->set_genre();
			echo 'success';
		}
	}
	public function update($id)
	{	
		$this->redirect_user();

		$data['title'] = "Update - Genre";
		$data['buttonText']="Save";
		$data['post_url']="/admin/genres/update";
		$genre=$this->genre->get($id);
		foreach ($genre->getProperties() as $key => $value) {
			$genre_data[$key]=$value;	
		}
		$genre_data['id']=$genre->getId();
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/genre/update.php');
			$this->load->view('admin/genre/form.php',$genre_data);
			$this->load->view('admin/templates/footer.php');
		}
		else
		{
			$this->genre->update_genre();
			echo 'success';
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/genre/update.php');
			$this->load->view('admin/genre/form.php');
			$this->load->view('admin/templates/footer.php');
		}
	}
	public function view($id)
	{
		$this->redirect_user();

		$data['title'] = "View - Genre";
		$genre=$this->genre->get($id);
		foreach ($genre->getProperties() as $key => $value) {
			$genre_data[$key]=$value;
		}
		$genre_data['id']=$genre->getId();
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/genre/view.php',$genre_data);
		$this->load->view('admin/templates/footer.php');
	}
	public function delete()
	{
		$this->redirect_user();

		if(isset($_POST)){
			$id=intval($_POST['node_id']);
			$this->genre->delete($id);
			$data['msg']="successfully deleted";
			echo json_encode($data);
		}

		//$data['title'] = "Delete - Genre";
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