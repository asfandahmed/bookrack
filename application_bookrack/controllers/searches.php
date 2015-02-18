<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Searches extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('common_functions','form_validation'));
		$this->load->helper(array('url'));
		$this->load->model(array('search'));
	}
	public function index()
	{
		$keywords=$this->input->get('search',TRUE);
		$filters=$this->input->get('filter',TRUE);
		$data['title']='Search - Bookrack';
		$data['keywords']=$keywords;
		$data['filters']=$filters;
		//$this->form_validation->set_rules('search', 'Search', 'trim|xss_clean');
		
		/*if($this->form_validation->run() === FALSE)
		//{
			$this->load->view('templates/header.php',$data);
			$this->load->view('search/index.php');
			$this->load->view('templates/footer.php');
		//}*/
		//else
		//{
			$results=$this->search->find($keywords,$filters);
			$results_data=array();
			$data['results'] = $results;
			
			$this->load->view('templates/header.php',$data);
			$this->load->view('search/index.php',$data);
			$this->load->view('templates/footer.php');
		//}
	}
	public function get_suggestions()
	{
		$data=array();
		$items=array();
		$keywords=$this->input->get('term');
		try{
			$results=$this->search->get_suggested_results($keywords);
			if(isset($results[0])){
				foreach ($results as $result) {
					$items[]=$result["name"];
				}
			$data=$items;
			}
			else
				$data['results']="";
			$data['success']=true;
		}
		catch(Exception $e){
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