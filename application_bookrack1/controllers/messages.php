<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Messages extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->library(array('common_functions','session','form_validation'));
	}
	public function load_message_panel()
	{
		$this->load->view('dialogs/messages.php');
	}
}
