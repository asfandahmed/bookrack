<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class common_functions
{
	protected $CI;
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library(array('session'));
		$this->CI->load->helper('url');
	}
	public function is_logged_in()
	{
		$logged_in=$this->CI->session->userdata('logged_in');
		if(isset($logged_in))
			if($logged_in===true)
				return true;
		return false;
	}
	public function is_admin(){
		$admin=$this->CI->session->userdata('admin');
		if(isset($admin))
			if($admin==1)
				return true;
		return false;
	}
	
}