<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model
{
	const GENRE = 'GENRE';
	const BOOK  = 'BOOK';
	const AUTHOR  = 'AUTHOR';
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('neo');
	}
	public function get($id) {
		$node = $this->neo->get_node($id);
		return $this->fromNode($node);
	}
	public function delete($id) {
		$this->neo->remove_node($id);
	}
	public function count() {
		$cypher = "MATCH (n:" . get_called_class() . ") RETURN count(n) as total";
		return $this->neo->execute_query($cypher);
	}
	public function fetch($fields=array('ID(n) as id'), $limit=10, $skip=0) {
		$cypher = "MATCH (n:" . get_called_class() . ") RETURN " . implode(",", $fields) . " skip {skip} limit {limit};";
		return $this->neo->execute_query($cypher, array(
			'limit'=>intval($limit),
			'skip'=>intval($skip)
			)
		);
	}
	public function relate($nodeA_id, $nodeB_id, $label){
		return $this->neo->add_relation($nodeA_id, $nodeB_id, $label);
	}
	public function match_and_relate($id, $labels, $relation, $property){
		$cypher="MATCH (n:" . $label[0] . ") WHERE ID(n) = {id}
				MERGE (m:" . $label[1] . " {" . key($property) . ":{value}})
				CREATE UNIQUE (m)-[r:" . $relation . "]->(n)
				RETURN r,n,m";
		return $this->neo->execute_query($query, array(
			'id'=>intval($id), 
			'value'=>$property[key($property)]
			)
		);
	}
	public function fromNode(Everyman\Neo4j\Node $node) {
		return $node;
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

	/*public function find($key_val_pairs = array('id'=>0)){

		$this->db->get_where(strtolower(get_called_class()), $key_val_pairs);
		return $this;
	}
	public function insert($object){
		return $this->db->insert(strtolower(get_called_class()), $object);
	}
	public function delete($id, $DbDelete = FALSE){

	}*/
}