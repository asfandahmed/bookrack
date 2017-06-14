<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Books extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('book','genre','author'));
		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation','neo','utility_functions'));
	}
	public function index()
	{
		$this->redirect_user();

		$this->load->library('pagination');
		$data['title'] = "Admin - Book";
		$count=$this->book->count()->offsetGet(0);
		$config['base_url']=site_url('admin/books');
		$config['total_rows']=$count['total'];
		$config["per_page"]=10;
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$fields = array('ID(n) as id','n.title');
		
		$data['results']=$this->book->fetch($fields, $config["per_page"], $page);
		$data['links']=$this->pagination->create_links();
		
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/book/index.php',$data);
		$this->load->view('admin/templates/footer.php');
	}
	public function insert()
	{
		$this->redirect_user();

		$data['title'] = "Insert - Books";
		$data['buttonText']="Insert";
		$data['post_url']="/admin/books/insert";
		$data['genres']=$this->get_genres();
		$this->set_validation();
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/book/insert.php');
			$this->load->view('admin/book/form.php',$data);
			$this->load->view('admin/templates/footer.php');
		}
		else
		{
			try
			{
				//get genre node id
				$genre=$this->input->post('genre');
				$author=$this->input->post('author');
				$publisher=$this->input->post('publisher');
				// insert book and return id
				$bookId=$this->book->set_book();
				
				$this->book->relate($bookId,$genre,My_Model::GENRE);
				
				$this->book->match_and_relate(
					$bookId,
					array(ucfrist(My_Model::BOOK), ucfirst(My_Model::AUTHOR)),
					$author
					);

				$this->book->relate_publisher($bookId,$publisher);
				echo 'success';
				$this->load->view('admin/templates/header.php',$data);
				$this->load->view('admin/book/insert.php');
				$this->load->view('admin/book/form.php',$data);
				$this->load->view('admin/templates/footer.php');
			}
			catch(Exception $e)
			{
            	echo $e->getMessage();
			}
		}
		
	}
	public function view($id)
	{
		$this->redirect_user();

		$data['title'] = "View - Book";
		$book=$this->book->get($id);
		foreach ($book->getProperties() as $key => $value) {
			$book_data[$key]=$value;
		}
		$book_data['id']=$book->getId();
		$this->load->view('admin/templates/header.php',$data);
		$this->load->view('admin/book/view.php',$book_data);
		$this->load->view('admin/templates/footer.php');
	}
	public function update($id)
	{
		$this->redirect_user();

		$data['title'] = "Update - Books";
		$data['buttonText']="Save";
		$data['post_url']="/admin/books/update";
		$data['genres']=$this->get_genres();
		$this->set_validation();
		
		
		if($this->form_validation->run() === FALSE)
		{
			$book=$this->book->get($id);
			foreach ($book->getProperties() as $key => $value) {
				$book_data[$key]=$value;
			}
			$book_data['id']=$id;

			$this->load->view('admin/templates/header.php',$data);
			$this->load->view('admin/book/form.php',$book_data);
			$this->load->view('admin/templates/footer.php');
		}
		else
		{
			try{
				
				$book=$this->input->post('id');
				$genre=$this->input->post('genre');
				$author=$this->input->post('author');
				$publisher=$this->input->post('publisher');

				$this->book->relate($book,$genre,My_Model::GENRE);
				$this->book->relate_author($book,$author);
				$this->book->relate_publisher($book,$publisher);
				redirect(site_url('admin/books/view/'.$book));
			}
			catch(Exception $e){
            	echo $e->getMessage();
			}
		}
		
	}
	public function delete()
	{
		$this->redirect_user();
		if(isset($_POST)){
			$id=intval($_POST['node_id']);
			$this->book->delete($id);
			$data['msg']="successfully deleted";
			echo json_encode($data);
		}
		
		//$this->load->view('admin/templates/footer.php');
	}
	private function get_genres()
	{
		$genre_array=array();
		$genres=$this->neo->get_label_nodes('Genre');
		foreach ($genres as $genre) 
			$genre_array[$genre->getId()]=$genre->name;
		$genres['data']->name;
		unset($genres);
		return $genre_array;
	}
	private function set_validation()
	{
		$this->form_validation->set_rules('title','Title','trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('author','Author','trim|required');
		$this->form_validation->set_rules('publisher','Publisher','trim|required');
		$this->form_validation->set_rules('published_date','Published Date','trim|required');
		$this->form_validation->set_rules('edition','Edition','trim|required');
		$this->form_validation->set_rules('isbn_10','ISBN 10','trim|required');
		$this->form_validation->set_rules('isbn_13','ISBN 13','trim|required');
		$this->form_validation->set_rules('genre','Genre','trim|required');
		$this->form_validation->set_rules('language','Language','trim|required');
		$this->form_validation->set_rules('ratings','Ratings','trim|required');
		$this->form_validation->set_rules('total_pages','Total Pages','trim|required');
	}
	public function redirect_user()
	{
		if(!$this->utility_functions->is_admin()==1)
			redirect(site_url());
	}
}
?>