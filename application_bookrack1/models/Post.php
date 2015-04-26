<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Post extends CI_Model
{
	var $user="";
	var $post_text="";
	var $post_object="";
	var $date_time="";
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
}