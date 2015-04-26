<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Genre extends CI_Model
{
	public $name="";
	public $date_time="";
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
	public function get($id){
		return $this->neo->get_node($id);
	}
	public function get_all(){
		return $this->neo->get_label_nodes('Genre');
	}
	public function get_genre_by_id($id){
		return $this->neo->get_node($id);
	}
	public function get_id($name){
		return $this->neo->execute_query("MATCH (n:Genre {name:{genre}}) RETURN ID(n) as id LIMIT 1",array('genre'=>$name));
	}
	public function set_genre()
	{
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$data=array(
			'name'=>$this->input->post('name'),
			'dateTime'=>mdate($datestring, $time),
			);
		$this->neo->insert('Genre',$data);
	}
	public function update_genre(){
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$id=intval($this->input->post('id'));
		$data=array(
			'name'=>$this->input->post('name'),
			'dateTime'=>mdate($datestring, $time),
			);
		$this->neo->update($id,$data);	
	}
	public function delete(){
		$this->neo->remove_node($id);
	}
	public function count(){
		return $this->neo->execute_query("MATCH (n:Genre) RETURN count(n) as total");
	}
	public function fetch($limit, $skip){
		return $this->neo->execute_query("MATCH (n:Genre) RETURN ID(n) as id, n.name skip {skip} limit {limit};",array('limit'=>intval($limit),'skip'=>intval($skip)));
	}
}