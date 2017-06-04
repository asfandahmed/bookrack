<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model
{
	private $id;
	private $first_name;
	private $last_name;
	private $email;
	private $password;
	private $dob;
	private $about;
	private $location;
	private $profile_url;
	private $profile_image;
	private $skype;
	private $facebook;
	private $twitter;
	private $googlePlus;
	private $verified_email;
	private $verified_account;
	private $register_date;
	private $ip_address;
	private $latitude;
	private $longitude;
	private $last_login;
	private $is_admin;
	private $active;
	protected $CI;
	public function __construct(){
		parent::__construct();
		$this->CI =& get_instance();

		$this->CI->load->library('neo');
	}
	public function get($id){
		return $this->CI->neo->get_node($id);
	}
	public function get_user($id){
		return self::createFromNode($this->get($id));
	}
	/**
	* @param int $id
	* @param array $data  contains key value pairs
	*/
	public function update_user_properties($id,$data){
		$this->CI->neo->update($id,$data);
	}
	public function set_user(){
		$time = time();
		$regDate = time();
		$admin=$this->input->post('admin');
		if(empty($admin))
			$admin=0;
		$data = array(
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'email'=>$this->input->post('email'),
			'password'=>sha1($this->input->post('password')),
			'dob'=>$this->input->post('dob'),
			'about'=>$this->input->post('about'),
			'location'=>'',
			'ip_address'=>$this->input->ip_address(),
			'profile_url'=>'',
			'profile_image'=>'user-pic.jpg',
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
		return $this->CI->neo->insert('User',$data);
	}
	public function update_user(){
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
		return $this->CI->neo->update($id,$data);	
	}
	public function check_user_exists($email)
	{
			$result=$this->CI->neo->execute_query("MATCH (n:User {email:{email}}) RETURN ID(n) AS id, n.first_name, n.last_name, n.password, n.is_admin, n.profile_image, n.username LIMIT 1",array('email'=>$email));
			if(isset($result[0]))
				return $result;
			return false;
	}
	/**
	* Follow a user
     *
     * @param  int       $userId     User taking the follow action
     * @param  int       $userToFollow User to follow
     * @return Relationship New follows relationship
	*/
	public function follow($userId, $userToFollow){
		$currentNode=$this->get($userId);
		$userNodeToBeFollowed=$this->get($userToFollow);
		return $currentNode->relateTo($userNodeToBeFollowed, 'FOLLOWS')->setProperty('date_time',time())->save();
	}
	public function unfollow($username, $userToUnfollow){
		$queryString = "MATCH (n1:User { username: {u} }) WITH n1 MATCH (n1)-[r:FOLLOWS]-(n2 { username: {f} }) DELETE  r";
        $query = $this->CI->neo->execute_query($queryString,array(
                'u' => $username,
                'f' => $userToUnfollow,
            )
        );
        return $query->getResultSet();
	}
	public function add_user_relation($n1,$n2,$relationName,$data)
	{
		$this->CI->neo->add_relation($n1,$n2,$relationName,$data);
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
		$query="START n=node({id}) MATCH (n:User)-[r1:FOLLOWS]->() RETURN COUNT(r1) AS Following";
		$result[]=$this->CI->neo->execute_query($query,array('id'=>intval($id)));
		$query="START n=node({id}) MATCH (n:User)<-[r1:FOLLOWS]-() RETURN COUNT(r1) AS Followers";
		$result[]=$this->CI->neo->execute_query($query,array('id'=>intval($id)));
		$query="START n=node({id}) MATCH (n)-[r:OWNS]->() RETURN COUNT(r) AS books";
		$result[]=$this->CI->neo->execute_query($query,array('id'=>intval($id)));
		return $result;
	}
	public function get_followers($id)
	{
		$query="MATCH (n)<-[r:FOLLOWS]-(followers) 
				WHERE id(n)={id} 
				RETURN ID(followers), followers.first_name AS first_name, followers.last_name AS last_name, followers.about AS about";
		return $result=$this->CI->neo->execute_query($query,array('id'=>intval($id)));
	}
	public function get_following($id)
	{
		$query="MATCH (n)-[r:FOLLOWS]->(following) 
				WHERE id(n)={id} 
				RETURN ID(following), following.first_name AS first_name, following.last_name AS last_name, following.about AS about";
		return $result=$this->CI->neo->execute_query($query,array('id'=>intval($id)));
	}
	public function count(){
		return $this->CI->neo->execute_query("MATCH (n:User) RETURN count(n) as total");
	}
	public function fetch($limit, $skip){
		return $this->CI->neo->execute_query('MATCH (n:User) RETURN ID(n) as id, n.first_name +" "+ n.last_name as name skip {skip} limit {limit}',array('limit'=>intval($limit),'skip'=>intval($skip)));
	}
	public function delete($id){
		$this->CI->neo->remove_node($id);
	}
	public function add_to_shelf($userId)
	{
		$name=$this->input->post('add_shelf');
		$query="MATCH (n:User)
				WHERE ID(n) = {id} 
				MERGE (m:Book {title:{name}})
				CREATE UNIQUE (n)-[r:OWNS]->(m)
				RETURN r,n,m";
		return $this->CI->neo->execute_query($query,array('id'=>intval($userId),'name'=>$name));
	}
	public function add_to_wishlist($userId)
	{
		$name=$this->input->post('add_wishlist');
		$query="MATCH (n:User)
				WHERE ID(n) = {id}
				MERGE (m:Book {title:{name}})
				CREATE UNIQUE (n)-[r:WISHES]->(m)
				RETURN r,n,m";
		return $this->CI->neo->execute_query($query,array('id'=>intval($userId),'name'=>$name));
	}
	public function get_books($id,$type){
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
		return $this->CI->neo->execute_query($query,array('id'=>intval($id)));
	}
	
	protected static function createFromNode(Everyman\Neo4j\Node $node){
		$user = new User();
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
		$user->ip=$node->getProperty('ip_address');
		$user->latitude=$node->getProperty('latitude');
		$user->longitude=$node->getProperty('longitude');
		$user->last_login=$node->getProperty('last_login');
		$user->active=$node->getProperty('active');
		return $user;
	}
	public function __get($property)
	{
		if(property_exists($this, $property))
		{
			return $this->property;
		}
	}
	public function __set($property, $value)
	{
		if(property_exists($this, $property))
		{
			$this->property=$value;
		}
		return $this;
	}
}