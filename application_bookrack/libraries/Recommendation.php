<?php 
class Recommendation {

	protected $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('neo');
		$this->CI->load->model(array('user','book'));
	}
	/**
     * Ask books suggestions from a user
     *
     * @access public
     * @param  string $username_to Username to whom we're asking book recommendations
     * @param  string $username_from Username who is asking for book recommendations
     */
    public function ask_book_suggestions($username_from, $username_to)
    {
        $queryString = <<<CYPHER
MATCH (user:User { email:{email_from}}), (u:User { email:{email_to}}) 
CREATE (user)-[r:ASKD_REC {date_time:{timestamp}}]-(u)
RETURN r
CYPHER;
        $result = $this->CI->neo->execute_query($queryString, array(
            'email_from' => $username_from, 
            'email_to' => $username_to,
            'timestamp' => time()
            ));
    }

    /**
     * Find books the provided user is not already having
     *
     * @access public
     * @param  string $username Username to whom we're providing book recommendations
     * @return Books[] Array of books
     */
    public function book_suggestions($username, $limit=2) {
        $queryString = <<<CYPHER
MATCH (user:User { email:{username}})
OPTIONAL MATCH (user)-[:FOLLOWS]->(u:User)-[:OWNS]->(b)
WHERE (NOT (user)-[:OWNS]->(b))
RETURN b, count(u) as common
ORDER BY common DESC
LIMIT {limit}
CYPHER;
        $result = $this->CI->neo->execute_query($queryString, array(
        	'username' => $username,
        	'limit' => $limit
        	)
        );
        return ( count($result) !== 0 ) ? $this->return_as_objects($result,'Book') : NULL;
    }

    /**
     * Find friends the provided user is not already following
     *
     * @access public
     * @param  string $username Username to whom we're providing friend recommendations
     * @return User[] Array of users
     */
    public function friend_suggestions($username, $limit=2) {
        $queryString = <<<CYPHER
MATCH (u:User), (user:User { email:{email}})
WHERE u <> user
AND (NOT (user)-[:FOLLOWS]->(u))
OPTIONAL MATCH (user)-[:FOLLOWS]->(u2)<-[:FOLLOWS]-(u)
WHERE u2 <> u
RETURN u, count(u2) as common
ORDER BY common DESC
LIMIT {limit}
CYPHER;
        $result = $this->CI->neo->execute_query($queryString, array(
        	'email' => $username,
        	'limit' => $limit
        	)
        );
        return ( count($result) !== 0 ) ? $this->return_as_objects($result,'User') : NULL;
    }

    /**
     * WIP: Suggest friends using collaborative recommendation
     *
     * @access public
     * @param  string $username Username to whom we're providing friend recommendations
     * @return User[] Array of users
     */
    public function collaborativeFriendSuggestions($username, $limit=5) {
        $queryString = <<<CYPHER
MATCH (u:User { username: { username }})
WITH u
MATCH (u)-[:FOLLOWS]->(friend),
(friend)-[:FOLLOWS]->(FoF)
WHERE NOT (u = FoF)
AND NOT (u--FoF)
RETURN COUNT(*) AS weight, FoF.username as recommendation
ORDER BY weight DESC, recommendation DESC
LIMIT {limit}
CYPHER;
		$result = $this->CI->neo->execute_query($queryString, array(
        	'email' => $username,
        	'limit' => $limit
        	)
        );
        return ( count($result) !== 0 ) ? $this->return_as_objects($result, 'User') : NULL;
    }

    /**
     * Creates an array of objects from a ResultSet
     *
     * @access protected
     * @param  ResultSet $results Query results
     * @return Obj[]    Array of objects
     */
    protected function return_as_objects(Everyman\Neo4j\Query\ResultSet $results, $type) {
        $objects = array();
        foreach ($results as $row) {
        	
        	if($type == 'Book'){
            	$object = $this->CI->book->fromNode($row['x']);
                if (isset($row['common'])) {
                    $object->commonReaders = $row['common'];
                }
        	}
            else if($type == 'User'){
        		$object = $this->CI->user->fromNode($row['x']);
                if (isset($row['common'])) {
                    $object->commonFriends = $row['common'];
                }
        	}

            $objects[] = $object;
        }

        return $objects;
    }

}