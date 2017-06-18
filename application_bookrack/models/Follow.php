<?php 
class Follow{
	protected $CI;
	public function __construct()
	{
		$this->CI  =& get_instance();
		$this->CI->load->library('neo');
	}
	public function get_followers($label, $id)
	{
		$cypher = "MATCH (n:" . $label . " {id:{id}})<-[r:FOLLOWS]-(followers) 
					WHERE r.approved = 1 
					RETURN followers";
		return $this->CI->neo->execute_query($cypher, array(
			'id'=>intval($id)
			)
		);
	}
	public function get_following($label, $id)
	{
		$cypher = "MATCH (n:" . $label . " {id:{id}})-[r:FOLLOWS]->(following) 
					WHERE r.approved = 1 
					RETURN following";
		return $this->CI->neo->execute_query($cypher, array(
			'id'=>intval($id)
			)
		);
	}
	public function follow($parent_id, $follower_id)
	{
		$approved = 1;
		$cypher = "MATCH (n {id:{parent_id}}), (m {id:{follower_id}}) 
					CREATE UNIQUE (m)-[r:FOLLOWS {approved:{approved}, timestamp:{timestamp}}]->(n) 
					RETURN r";
		return $this->CI->neo->execute_query($cypher, array(
			'parent_id'=>intval($parent_id),
			'follower_id'=>intval($follower_id),
			'approved'=>$approved
			)
		);
	}
	public function unfollow($parent_id, $follower_id)
	{
		$cypher = "MATCH (n {id:{follower_id}})-[r:FOLLOWS]->(f {id:{parent_id}}) 
					DELETE r";
		return $this->CI->neo->execute_query($cypher, array(
			'parent_id'=>intval($parent_id),
			'follower_id'=>intval($follower_id)
			)
		);
	}
	public function count_followers($id)
	{
		$cypher = "START n=node({id}) MATCH (n)<-[r:FOLLOWS]-() WHERE r.approved = 1 RETURN COUNT(r) AS followers";
		return $this->CI->neo->execute_query($cypher, array(
			'id'=>intval($id)
			)
		);
	}
	public function count_following($id)
	{
		$cypher = "START n=node({id}) MATCH (n)-[r:FOLLOWS]->() WHERE r.approved = 1 RETURN COUNT(r) AS following";
		return $this->CI->neo->execute_query($cypher, array(
			'id'=>intval($id)
			)
		);
	}
}