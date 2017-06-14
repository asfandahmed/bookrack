<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Searches extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('utility_functions','form_validation'));
		$this->load->helper(array('url'));
		$this->load->model(array('search'));
	}
	public function index()
	{
		if(!$this->utility_functions->is_logged_in())
			redirect(site_url());

		$keywords=$this->input->get('search',TRUE);
		$filters=$this->input->get('filter',TRUE);
		$data['title']='Search - Bookrack';
		$data['keywords']=$keywords;
		$data['filters']=$filters;

			$results=$this->search->find($keywords,$filters);
			$data['results'] = $results;
			
			$this->load->view('templates/header.php',$data);
			$this->load->view('search/index.php',$data);
			$this->load->view('templates/footer.php');

	}
	public function get_results($keywords="",$filters="anything",$skip=0,$limit=10){
		if($this->utility_functions->is_logged_in())
		{			
			$keywords = urldecode($keywords);
			$filters = urldecode($filters);
			$data['keywords']=$keywords;
			$data['filters']=$filters;
			$data['results'] = $this->search->find($keywords,$filters,$skip,$limit);
			$this->load->view('search/search-results.php',$data);
		}
	}
	public function nearest_users($id,$title)
	{
		if(!$this->utility_functions->is_logged_in())
			redirect(site_url());

		$title = urldecode($title);
		$data['title']="List nearest users";
		$email=$this->session->userdata('email');
		
		if ($this->search->check_lat_lon($email))
		{
			$data['users']=$this->search->get_nearest_users($title,$email);
			$data['lat_lon']=TRUE;
		}
		else
		{
			$data['users']=$this->search->get_book_owners($title,$email);
			$data['lat_lon']=FALSE;
		}
		$data['bookId']=$id;
		$data['bookTitle']=$title;
		$this->load->view('templates/header.php',$data);
		$this->load->view('search/users-list.php',$data);
		$this->load->view('templates/footer.php');
	}
	public function load_nearest_users($id,$title,$skip,$limit)
	{
		if($this->utility_functions->is_logged_in())
		{
			$email=$this->session->userdata('email');
			if ($this->search->check_lat_lon($email))
			{
				$data['users']=$this->search->get_nearest_users($title,$email,$skip,$limit);
				$data['lat_lon']=TRUE;
			}
			else
			{
				$data['users']=$this->search->get_book_owners($title,$email,$skip,$limit);
				$data['lat_lon']=FALSE;
			}
			$data['bookId']=$id;
			$data['bookTitle']=$title;
			$this->load->view('search/users-view.php',$data);
		}
	}
	public function get_suggestions()
	{
		$data=array();
		$items=array();
		$keywords=$this->input->get('term');
		try
		{
			$results=$this->search->get_suggested_results($keywords);
			if(isset($results[0])){
				foreach ($results as $result)
				{
					$items[]=$result["name"];
				}
			$data=$items;
		}
			else
				$data['results']="";
			$data['success']=true;
		}
		catch(Exception $e)
		{
			$data['errors']=$e->Message;
			$data['success']=false;
		}
		echo json_encode($data);
	}
	public function books()
	{
		$keywords=$this->input->get('term');
		$items=array();
		try{

			$results=$this->search->get_books($keywords);
			if(isset($results[0])){
				foreach ($results as $result)
					$items[]=$result['title'];
			}
		}
		catch(Exception $e){
			$items['errors']=$e->Message;
		}
		echo json_encode($items);
	}
	public function authors()
	{
		$keywords=$this->input->get('term');
		$items=array();
		try{

			$results=$this->search->get_authors($keywords);
			if(isset($results[0])){
				foreach ($results as $result)
					$items[]=$result['name'];
			}
		}
		catch(Exception $e){
			$items['errors']=$e->Message;
		}
		echo json_encode($items);
	}
	public function publishers()
	{
		$keywords=$this->input->get('term');
		$items=array();
		try{

			$results=$this->search->get_publishers($keywords);
			if(isset($results[0])){
				foreach ($results as $result)
					$items[]=$result['company'];
			}
		}
		catch(Exception $e){
			$items['errors']=$e->Message;
		}
		echo json_encode($items);
	}
}