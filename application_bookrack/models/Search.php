<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends CI_Model
{
	private static $book_cypher;
	private static $user_cypher;
	private static $author_cypher;
	private static $publisher_cypher;

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('neo','session'));
	}
	public function find($keywords="", $filters="anything", $skip=0, $limit=10)
	{
		if($keywords=="")
			$keywords=" ";
		$query="";
		if($filters=='books'){
			$query="MATCH (n:Book)
				WHERE n.title =~ '(?i)".$keywords.".*'
				WITH DISTINCT n
				OPTIONAL MATCH (n)<-[:OWNS]-(m:User)
				OPTIONAL MATCH (n)<-[:WROTE]-(o:Author)
				RETURN ID(n), n.title AS name, n.image as image, labels(n) as type, COUNT(DISTINCT m) as owners, 
				o.name as author SKIP {skip} LIMIT {limit}";
		}	
		elseif($filters=='people'){
			$query="MATCH (n:User)
				WHERE (n.first_name =~ '(?i)".$keywords.".*' OR n.last_name =~ '(?i)".$keywords.".*') AND n.email <> '".$this->session->userdata('email')."'
				WITH DISTINCT n
				OPTIONAL MATCH (n)-[:OWNS]->(b:Book)
				OPTIONAL MATCH (n)<-[:FOLLOWS]-(m)
				OPTIONAL MATCH (n)<-[r:FOLLOWS]-(o {email:'".$this->session->userdata('email')."'}) // loggedin user id here
				RETURN ID(n), n.first_name + ' ' + n.last_name AS name, 
				n.profile_image as image, labels(n) as type, COUNT(DISTINCT b) as books, 
				COUNT(DISTINCT m) as followers, r.date_time as relation SKIP {skip} LIMIT {limit}";
		}	
		elseif($filters=='publishers'){
			$query="MATCH (n:Publisher)
				WHERE n.company =~ '(?i)".$keywords.".*'
				RETURN ID(n), n.company AS name, n.image as image, labels(n) as type SKIP {skip} LIMIT {limit}";
		}
		elseif($filters=='authors'){
			$query="MATCH (n:Author)
				WHERE n.name =~ '(?i)".$keywords.".*' 
				RETURN ID(n), n.name AS name, n.image as image, labels(n) as type SKIP {skip} LIMIT {limit}";
		}
		else{
			$query="MATCH (n:Book)
				WHERE n.title =~ '(?i)".$keywords.".*'
				WITH DISTINCT n
				OPTIONAL MATCH (n)<-[:OWNS]-(m:User)
				OPTIONAL MATCH (n)<-[:WROTE]-(o:Author)
				RETURN ID(n), n.title AS name, n.image as image, labels(n) as type, COUNT(DISTINCT m) as owners, 
				o.name as author, '' as books, '' as followers, '' as relation SKIP {skip} LIMIT {limit}
				
				UNION ALL
				
				MATCH (n:User)
				WHERE (n.first_name =~ '(?i)".$keywords.".*' OR n.last_name =~ '(?i)".$keywords.".*') AND n.email <> '".$this->session->userdata('email')."'
				WITH DISTINCT n
				OPTIONAL MATCH (n)-[:OWNS]->(b:Book)
				OPTIONAL MATCH (n)<-[:FOLLOWS]-(m)
				OPTIONAL MATCH (n)<-[r:FOLLOWS]-(o {email:'".$this->session->userdata('email')."'}) // loggedin user id here
				RETURN ID(n), n.first_name + ' ' + n.last_name AS name, n.profile_image as image, labels(n) as type, 
				COUNT(DISTINCT b) as books, COUNT(DISTINCT m) as followers, r.date_time as relation, '' as owners, '' as author SKIP {skip} LIMIT {limit}

				UNION ALL
				
				MATCH (n:Publisher)
				WHERE n.company =~ '(?i)".$keywords.".*'
				RETURN ID(n), n.company AS name, n.image as image, labels(n) as type, '' as books, '' as followers, '' as relation, '' as owners, '' as author  SKIP {skip} LIMIT {limit}
				
				UNION ALL 
				
				MATCH (n:Author)
				WHERE n.name =~ '(?i)".$keywords.".*' 
				RETURN ID(n), n.name AS name, n.image as image, labels(n) as type, '' as books, '' as followers, '' as relation, '' as owners, '' as author  SKIP {skip} LIMIT {limit}";
		}
		
		return $results=$this->neo->execute_query($query,array('skip' => intval($skip), 'limit'=>intval($limit) ));
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

	public function check_lat_lon($email)
	{
		$query = "MATCH (n:User {email:{email}}) RETURN n.lat IS NOT NULL AND n.lon IS NOT NULL as hasLatLon";
		$result = $this->neo->execute_query($query,array('email'=>$email));
		if(isset($result[0])){
			if($result[0]['hasLatLon']==true)
				return true;
		}
		return false;
	}
	public function get_nearest_users($title,$email, $skip=0, $limit=1)
	{
		$nearestBookCypher='MATCH (u2:User)-[:OWNS]->(b:Book {title:{t} })
WITH DISTINCT u2
MATCH (u1:User {email: {e} })
WHERE u1 <> u2
RETURN 
degrees( acos( sin(radians(u1.lat)) * sin(radians(u2.lat)) + cos(radians(u1.lat)) * cos(radians(u2.lat)) * cos(radians(u1.lon-u2.lon)) ) ) as distance, 
u2.first_name + " " + u2.last_name as username, ID(u2) as id, u2.profile_image as image order by distance asc SKIP {skip} LIMIT {limit}';

		return $this->neo->execute_query($nearestBookCypher,array(
				't'=>$title,
				'e'=>$email,
				'skip'=>intval($skip),
				'limit'=>intval($limit)
				));
	}
	public function get_book_owners($title,$email, $skip=0, $limit=1)
	{
		$cypher='MATCH (u2:User)-[:OWNS]->(b:Book {title:{t} })
WITH DISTINCT u2
MATCH (u1:User {email: {e} })
WHERE u1 <> u2
RETURN 
"" as distance, u2.first_name + " " + u2.last_name as username, ID(u2) as id, u2.profile_image as image order by distance asc SKIP {skip} LIMIT {limit}';
		
		return $this->neo->execute_query($cypher,array(
				't'=>$title,
				'e'=>$email,
				'skip'=>intval($skip),
				'limit'=>intval($limit)
				));
	}
}