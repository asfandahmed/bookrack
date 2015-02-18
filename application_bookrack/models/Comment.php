<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Comment extends CI_Model
{
	var $user="";
	var $post="";
	var $comment="";
	var $date_time="";
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}	
}