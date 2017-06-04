<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model
{
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function find($key_val_pairs = array('id'=>0)){

		$this->db->get_where(strtolower(get_called_class()), $key_val_pairs);
		return $this;
	}
	public function insert($object){
		return $this->db->insert(strtolower(get_called_class()), $object);
	}
	public function delete($id, $DbDelete = FALSE){

	}
	public function param($key, $value='') {
		if(property_exists(get_called_class(), "param")){
			$this->param = json_encode(array($key => $value));
			return $this;
		}
	}
	public function get_param($key) {
		if(property_exists(get_called_class(), "param")){
			$param = json_decode($this->param);
			return $param->$key;
		}
	}
	public function get_date() {
		return date(MYSQL_DATETIME_FORMAT, time());
	}
}