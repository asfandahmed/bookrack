<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Like extends CI_Model
{
	public $user;
	public $post;
	public $date_time;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
	public function getLike($id)
	{
		return $id;
	}
	public function setLike($email,$postId)
	{
		$cypher = '
		MATCH (u:User {email:{u}})
		MATCH (s:Status {statusId:{s}})
		CREATE UNIQUE (u)-[r:LIKES {date_time:{d}}]->(s)
		RETURN r';
		return $this->neo->execute_query($cypher, array(
				'u' => $email,
				's' => $postId,
				'd' => time(),
			));
	}
	public function updateLike($id)
	{
		return $id;
	}
	public function deleteLike($email, $postId)
	{
		$cypher = '
		MATCH (u:User {email:{u}})-[r:LIKES]->(s:Status {statusId:{s}})
		DELETE r
		';
		$this->neo->execute_query($cypher,array(
			'u' => $email,
			's' => $postId
			));
	}
}