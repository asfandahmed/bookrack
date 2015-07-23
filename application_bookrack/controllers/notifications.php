<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Notifications Class
 *
 * @author  Asfand yar Ahmed
 */
class Notifications extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('notification');
		$this->load->helper(array('url'));
		$this->load->library(array('common_functions','session'));
	}
	/**
	* Index method for notifications controllers
	* @access public
	*/
	public function index()
	{
		$data['title']='Notifications - '.APP_NAME;
		$this->load->view('templates/header.php',$data);
		$this->load->view('notification/index.php');
		$this->load->view('templates/footer.php');
	}
	/**
	* Fetches unread notifications, requests and messages
	* @access public
	* @return data{} json object
	*/
	public function check_new()
	{
		$data = array('success'=>FALSE,'result'=>array());
		if($this->common_functions->is_logged_in())
		{
			$email = $this->session->userdata('email');
			$data['result'] = $this->notification->check_unread($email);
			if(!empty($data['result']))
				$data['success']=TRUE;
			echo json_encode($data);
		}
	}
}

/* End of file notifications.php */
/* Location: ./application/controllers/notifications.php */