<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('neo'));
	}
	public function find($keywords,$filters="")
	{
		if($keywords=="")
			$keywords=" ";
		$query="";
		if($filters=='books'){
			$query="MATCH (n:Book)
				WHERE n.title =~ '(?i)".$keywords.".*'
				RETURN ID(n), n.title AS name, labels(n) as type";
		}	
		elseif($filters=='people'){
			$query="MATCH (n:User)
				WHERE n.first_name =~ '(?i)".$keywords.".*'
				RETURN ID(n), n.first_name + ' ' + n.last_name AS name, labels(n) as type";
		}	
		elseif($filters=='publishers'){
			$query="MATCH (n:Publisher)
				WHERE n.company =~ '(?i)".$keywords.".*'
				RETURN ID(n), n.company AS name, labels(n) as type";
		}
		elseif($filters=='authors'){
			$query="MATCH (n:Author)
				WHERE n.name =~ '(?i)".$keywords.".*' 
				RETURN ID(n), n.name AS name, labels(n) as type";
		}
		else{
			$query="MATCH (n:Book)
				WHERE n.title =~ '(?i)".$keywords.".*'
				RETURN ID(n), n.title AS name, labels(n) as type
				UNION ALL
				MATCH (n:User)
				WHERE n.first_name =~ '(?i)".$keywords.".*'
				RETURN ID(n), n.first_name + ' ' + n.last_name AS name, labels(n) as type 
				UNION ALL
				MATCH (n:Publisher)
				WHERE n.company =~ '(?i)".$keywords.".*'
				RETURN ID(n), n.company AS name, labels(n) as type
				UNION ALL 
				MATCH (n:Author)
				WHERE n.name =~ '(?i)".$keywords.".*' 
				RETURN ID(n), n.name AS name, labels(n) as type";
		}
		
		return $results=$this->neo->execute_query($query);
	}
	public function get_suggested_results($keywords)
	{ 
		$query="MATCH (n:Book)
				WHERE n.title =~ '(?i)".$keywords.".*'
				RETURN n.title AS name
				UNION ALL
				MATCH (n:User)
				WHERE n.first_name =~ '(?i)".$keywords.".*'
				RETURN n.first_name + ' ' + n.last_name AS name LIMIT 6";
		$result=$this->neo->execute_query($query);
		return $result;
	}
	public function get_books($keywords){
		$query="MATCH (n:Book)
				WHERE n.title =~ '(?i)".$keywords.".*'
				RETURN n.title AS title LIMIT 10";
		return $this->neo->execute_query($query);
	}
	public function get_authors($keywords){
		$query="MATCH (n:Author)
				WHERE n.name =~ '(?i)".$keywords.".*'
				RETURN n.name AS name LIMIT 10";
		return $this->neo->execute_query($query);
	}
	public function get_publishers($keywords){
		$query="MATCH (n:Publisher)
				WHERE n.company =~ '(?i)".$keywords.".*'
				RETURN n.company AS company LIMIT 10";
		return $this->neo->execute_query($query);
	}
}