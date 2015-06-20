<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Recommendation extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
		$this->load->model('user');
	}
	/**
     * Find friends the provided user is not already following
     *
     * @param  string $username Username to whom we're providing friend recommendations
     * @return User[] Array of users
     */
    public static function friendSuggestions($email)
    {
        $queryString = <<<CYPHER
MATCH (u:User), (user:User { email:{email}})
WHERE u <> user
AND (NOT (user)-[:FOLLOWS]->(u))
OPTIONAL MATCH (user)-[:FOLLOWS]->(u2)<-[:FOLLOWS]-(u)
WHERE u2 <> u
RETURN u, count(u2) as common
ORDER BY common DESC
LIMIT 2
CYPHER;
		$CI = get_instance();
        $result = $CI->neo->execute_query($queryString, array('email' => $email));

        return self::returnAsUsers($result);
    }
	/**
     * WIP: Suggest friends using collaborative recommendation
     *
     * @param  string $username Username to whom we're providing friend recommendations
     * @return User[] Array of users
     */
    public static function collaborativeFriendSuggestions($username)
    {
        $queryString = <<<CYPHER
MATCH (u:User { username: { username }})
WITH u
MATCH (u)-[:FOLLOWS]->(friend),
(friend)-[:FOLLOWS]->(FoF)
WHERE NOT (u = FoF)
AND NOT (u--FoF)
RETURN COUNT(*) AS weight, FoF.username as recommendation
ORDER BY weight DESC, recommendation DESC
LIMIT 5
CYPHER;

        $query = new Query(
            Neo4jClient::client(),
            $queryString,
            array('username' => $username)
        );

        $result = $query->getResultSet();

        return self::returnAsUsers($result);
    }
    /**
     * Creates an array of users from a ResultSet
     *
     * @param  ResultSet $results Query results
     * @return User[]    Array of users
     */
    protected static function returnAsUsers(Everyman\Neo4j\Query\ResultSet $results)
    {
        $userArray = array();
        foreach ($results as $row) {
            $user = self::createfromNode($row['x']);
            if (isset($row['common'])) {
                $user->commonFriends = $row['common'];
            }
            $userArray[] = $user;
        }

        return $userArray;
    }
    protected static function createFromNode(Everyman\Neo4j\Node $node){
		$user=new User();
		$user->id=$node->getId();
		$user->first_name=$node->getProperty('first_name');
		$user->last_name=$node->getProperty('last_name');
		$user->email=$node->getProperty('email');
		$user->profile_image=$node->getProperty('profile_image');
		$user->profile_url=$node->getProperty('profile_url');
		
		return $user;
	}
}