<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends MY_Model
{
	public $id;
	public $first_name;
	public $last_name;
	public $email;
	public $password;
	public $dob;
	public $about;
	public $location;
	public $profile_url;
	public $profile_image;
	public $skype;
	public $facebook;
	public $twitter;
	public $googlePlus;
	public $verified_email;
	public $verified_account;
	public $register_date;
	public $ip_address;
	public $latitude;
	public $longitude;
	public $last_login;
	public $is_admin;
	public $active;
	protected $CI;

	public function __construct(){
		parent::__construct();
		$this->CI =& get_instance();

	}

	/**
	* @param int $id
	* @param array $data  contains key value pairs
	*/
	public function update_user_properties($id,$data){
		$this->CI->neo->update($id,$data);
	}
	public function set_user()
	{	
		$data = $this->set_input_values();
		return $this->CI->neo->insert('User',$data);
	}
	public function update_user()
	{
		$id = $this->input->post('id');
		$data = $this->set_input_values();
		return $this->CI->neo->update($id,$data);	
	}
	public function set_input_values(){
		$admin=$this->input->post('admin');
		if(empty($admin)){
			$admin=0;
		}
		$time = time();
		return array(
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
			'register_date'=>$time,
			'last_login'=>$time,
			'is_admin'=>$admin,
			'active'=>$this->input->post('active'),
			);
	}
	public function check_user_exists($email)
	{
			$cypher = "MATCH (n:User {email:{email}}) RETURN ID(n) AS id, n.first_name, n.last_name, n.password, n.is_admin, n.profile_image, n.username LIMIT 1";
			$result=$this->CI->neo->execute_query($cypher, array(
				'email'=>$email
				)
			);
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
	

	public function get_books($id,$type){
		$books=array();
		switch ($type) {
			case "OWNS": 
				$this->CI->load->model('shelf');
				$books = $this->CI->shelf->get($id);
				break;
			case "WISHES": 
				$this->CI->load->model('wishlist');
				$books = $this->CI->wishlist->get($id);
				break;
			case "FAVORITES": 
				$this->CI->load->model('favorite');
				$books = $this->CI->favorite->get($id);
				break;
			default:
				$this->CI->load->model('shelf');
				$books = $this->CI->shelf->get($id);
				break;
		}		
		return $books;
	}
	
	public function fromNode(Everyman\Neo4j\Node $node){
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
}