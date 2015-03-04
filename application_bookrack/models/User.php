<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model
{
	public $id;
	public $first_name="";
	public $last_name="";
	public $email="";
	public $password="";
	public $dob="";
	public $about="";
	public $location="";
	public $profile_url="";
	public $profile_image="";
	public $skype="";
	public $facebook="";
	public $twitter="";
	public $googlePlus="";
	public $verified_email="";
	public $verified_account="";
	public $register_date="";
	public $last_login="";
	public $is_admin="";
	public $active="";
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
		$this->load->helper('date');
	}
	public function get($id){
		return $this->neo->get_node($id);
	}
	public function get_user($id){
		return self::createFromNode($this->get($id));
	}
	/**
	* @param int $id
	* @param array $data  contains key value pairs
	*/
	public function update_user_properties($id,$data)
	{
		$this->neo->update($id,$data);
	}
	public function set_user()
	{
		$admin=$this->input->post('admin');
		if(empty($admin))
			$admin=0;
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$regDate=mdate($datestring, $time);
		$data = array(
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'email'=>$this->input->post('email'),
			'password'=>sha1($this->input->post('password')),
			'dob'=>$this->input->post('dob'),
			'about'=>$this->input->post('about'),
			'location'=>'',
			'profile_url'=>'',
			'skype'=>$this->input->post('skype'),
			'facebook'=>$this->input->post('facebook'),
			'twitter'=>$this->input->post('twitter'),
			'googlePlus'=>$this->input->post('googlePlus'),
			'verified_email'=>$this->input->post('verified_email'),
			'verified_account'=>$this->input->post('verified_account'),
			'register_date'=>$regDate,
			'last_login'=>$regDate,
			'is_admin'=>$admin,
			'active'=>$this->input->post('active'),
			);
		return $this->neo->insert('User',$data);
	}
	public function update_user()
	{
		$id=$this->input->post('id');
		$admin=$this->input->post('admin');
		if(empty($admin))
			$admin=0;
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$regDate=mdate($datestring, $time);
		$data = array(
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'email'=>$this->input->post('email'),
			'password'=>sha1($this->input->post('password')),
			'dob'=>$this->input->post('dob'),
			'about'=>$this->input->post('about'),
			'location'=>'',
			'profile_url'=>'',
			'skype'=>$this->input->post('skype'),
			'facebook'=>$this->input->post('facebook'),
			'twitter'=>$this->input->post('twitter'),
			'googlePlus'=>$this->input->post('googlePlus'),
			'verified_email'=>$this->input->post('verified_email'),
			'verified_account'=>$this->input->post('verified_account'),
			'register_date'=>$regDate,
			'last_login'=>$regDate,
			'is_admin'=>$admin,
			'active'=>$this->input->post('active'),
			);
		return $this->neo->update($id,$data);	
	}
	public function get_feed($userId,$skip,$limit=10)
	{
		$query="MATCH (u:User)-[r:POSTED]->(s:Status) WHERE ID(u) = {id} RETURN s ORDER BY r.date_time DESC";
		return $this->neo->execute_query($query,array('id'=>intval($userId)));
	}
	public function get_feed_count($userId)
	{
		$query="MATCH (u:User)-[r:POSTED]->(s:Status) WHERE ID(u) = {id} RETURN COUNT(s) as total";
		return $this->neo->execute_query($query,array('id'=>intval($userId)));
	}
	public function check_user_exists($email)
	{
			$result=$this->neo->execute_query("MATCH (n:User {email:{email}}) RETURN ID(n) AS id, n.first_name, n.last_name, n.password, n.is_admin, n.profile_image LIMIT 1",array('email'=>$email));
			if(isset($result[0]))
				return $result;
			return false;
	}
	public function follow_user($username, $userToFollow){
		return $currentNode->relateTo($userNodeToBeFollowed, 'FOLLOWS')->save();
	}
	public function unfollow_user($username, $userToUnfollow){
		$queryString = "MATCH (n1:User { username: {u} }) WITH n1 MATCH (n1)-[r:FOLLOWS]-(n2 { username: {f} }) DELETE  r";
        $query = $this->neo->execute_query($queryString,array(
                'u' => $username,
                'f' => $userToUnfollow,
            )
        );

        return $query->getResultSet();
	}
	public function add_user_relation($n1,$n2,$relationName,$data)
	{
		$this->neo->add_relation($n1,$n2,$relationName,$data);
	}
	public function get_user_relations($id,$relations)
	{	
	}
	public function remove_user_relation($id)
	{
	}
	public function get_basic_info($id)
	{
		$result=array();
		$query="START n=node({id}) MATCH (n:User)-[r1:FOLLOWS]->(), (n:User)<-[r2:FOLLOWS]-() RETURN COUNT(r1) AS Following, COUNT(r2) AS Followers";
		$result[]=$this->neo->execute_query($query,array('id'=>intval($id)));
		$query="START n=node({id}) MATCH (n)-[r:OWNS]->() RETURN COUNT(r) AS books";
		$result[]=$this->neo->execute_query($query,array('id'=>intval($id)));
		return $result;
	}
	public function get_followers($id)
	{
		$query="MATCH (n)<-[r:FOLLOWS]-(followers) 
				WHERE id(n)={id} 
				RETURN ID(followers), followers.first_name AS first_name, followers.last_name AS last_name, followers.about AS about";
		return $result=$this->neo->execute_query($query,array('id'=>intval($id)));
	}
	public function get_following($id)
	{
		$query="MATCH (n)-[r:FOLLOWS]->(following) 
				WHERE id(n)={id} 
				RETURN ID(following), following.first_name AS first_name, following.last_name AS last_name, following.about AS about";
		return $result=$this->neo->execute_query($query,array('id'=>intval($id)));
	}
	public function count(){
		return $this->neo->execute_query("MATCH (n:User) RETURN count(n) as total");
	}
	public function fetch($limit, $skip){
		return $this->neo->execute_query('MATCH (n:User) RETURN ID(n) as id, n.first_name +" "+ n.last_name as name skip {skip} limit {limit}',array('limit'=>intval($limit),'skip'=>intval($skip)));
	}
	public function delete($id){
		$this->neo->remove_node($id);
	}
	public function add_to_shelf($userId)
	{
		$name=$this->input->post('add_shelf');
		//echo $userId;
		//die($name);
		$query="MATCH (n:User)
				WHERE ID(n) = {id} 
				MERGE (m:Book {title:{name}})
				CREATE UNIQUE (n)-[r:OWNS]->(m)
				RETURN r,n,m";
		//die($query);
		return $this->neo->execute_query($query,array('id'=>intval($userId),'name'=>$name));
	}
	public function add_to_wishlist($userId)
	{
		$name=$this->input->post('add_wishlist');
		$query="MATCH (n:User)
				WHERE ID(n) = {id}
				MERGE (m:Book {title:{name}})
				CREATE UNIQUE (n)-[r:WISHES]->(m)
				RETURN r,n,m";
		return $this->neo->execute_query($query,array('id'=>intval($userId),'name'=>$name));
	}
	public function get_books($id,$type)
	{
		switch ($type) {
			case "OWNS": // owns
				$query="START a=node({id}) 
						MATCH (a)-[r:OWNS]->(b:Book)
						WITH b
						OPTIONAL MATCH (b)-[:GENRE]->(g)
						WITH b,g 
						RETURN b, collect(g.name) as genre";		
				break;
			case "WISHES": // wishes
				$query="START a=node({id}) MATCH (a)-[r:WISHES]->(b:Book) 
						WITH b
						OPTIONAL MATCH (b)-[:GENRE]->(g:Genre)
						WITH b,g 
						RETURN b, collect(g.name) as genre";		
				break;
			default:
				$query="START a=node({id}) MATCH (a)-[r:OWNS]->(b:Book) 
						WITH b
						OPTIONAL MATCH (b)-[:GENRE]->(g:Genre)
						WITH b,g 
						RETURN b, collect(g.name) as genre";
				break;
		}		
		return $this->neo->execute_query($query,array('id'=>intval($id)));
	}
	/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	/*::                                                                         :*/
	/*::  This routine calculates the distance between two points (given the     :*/
	/*::  latitude/longitude of those points). It is being used to calculate     :*/
	/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
	/*::                                                                         :*/
	/*::  Definitions:                                                           :*/
	/*::    South latitudes are negative, east longitudes are positive           :*/
	/*::                                                                         :*/
	/*::  Passed to function:                                                    :*/
	/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
	/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
	/*::    unit = the unit you desire for results                               :*/
	/*::           where: 'M' is statute miles (default)                         :*/
	/*::                  'K' is kilometers                                      :*/
	/*::                  'N' is nautical miles                                  :*/
	/*::  Worldwide cities and other features databases with latitude longitude  :*/
	/*::  are available at http://www.geodatasource.com                          :*/
	/*::                                                                         :*/
	/*::  For enquiries, please contact sales@geodatasource.com                  :*/
	/*::                                                                         :*/
	/*::  Official Web site: http://www.geodatasource.com                        :*/
	/*::                                                                         :*/
	/*::         GeoDataSource.com (C) All Rights Reserved 2015		   		     :*/
	/*::                                                                         :*/
	/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	protected static function calculate_distance($lat1, $lon1, $lat2, $lon2, $unit="K")
	{
		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);

		  if ($unit == "K") {
		    return ($miles * 1.609344);
		  } else if ($unit == "N") {
		      return ($miles * 0.8684);
		    } else {
		        return $miles;
		      }

		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";

	}
	protected static function createFromNode(Everyman\Neo4j\Node $node){
		$user=new User();
		$user->id=$node->getId();
		$user->first_name=$node->getProperty('first_name');
		$user->last_name=$node->getProperty('last_name');
		$user->dob=$node->getProperty('dob');
		$user->email=$node->getProperty('email');
		$user->about=$node->getProperty('about');
		$user->location=$node->getProperty('location');
		$user->profile_image=$node->getProperty('profile_image');
		$user->profile_url=$node->getProperty('profile_url');
		$user->skype=$node->getProperty('skype');
		$user->facebook=$node->getProperty('facebook');
		$user->twitter=$node->getProperty('twitter');
		$user->googlePlus=$node->getProperty('googlePlus');
		$user->register_date=$node->getProperty('register_date');
		$user->last_login=$node->getProperty('last_login');
		$user->active=$node->getProperty('active');
		return $user;
	}
}