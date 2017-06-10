<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Recommendation Class
 *
 * @author  Asfand yar Ahmed
 */
class Recommendation extends CI_Model
{
	public function __construct(){
		parent::__construct();
		$this->load->library('neo');
		$this->load->model(array('user','book'));
	}
    /**
     * Ask books suggestions from a user
     *
     * @access public
     * @param  string $username_to Username to whom we're asking book recommendations
     * @param  string $username_from Username who is asking for book recommendations
     */
    public static function ask_book_suggestions($username_from, $username_to)
    {
        $queryString = <<<CYPHER
MATCH (user:User { email:{email_from}}), (u:User { email:{email_to}}) 
CREATE (user)-[r:ASKD_REC {date_time:{timestamp}}]-(u)
RETURN r
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString, array(
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
    public static function suggest_book($username)
    {
        $queryString = <<<CYPHER
MATCH (user:User { email:{email}})
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString, array('email' => $username));
    }
    /**
     * Find books the provided user is not already having
     *
     * @access public
     * @param  string $username Username to whom we're providing book recommendations
     * @return Books[] Array of books
     */
    public static function book_suggestions($username)
    {
        $queryString = <<<CYPHER
MATCH (user:User { email:{username}})
OPTIONAL MATCH (user)-[:FOLLOWS]->(u:User)-[:OWNS]->(b)
WHERE (NOT (user)-[:OWNS]->(b))
RETURN b, count(u) as common
ORDER BY common DESC
LIMIT 2
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString, array('username' => $username));
        return (count($result)!==0)?self::returnAsBooks($result):NULL;
    }
	/**
     * Find friends the provided user is not already following
     *
     * @access public
     * @param  string $username Username to whom we're providing friend recommendations
     * @return User[] Array of users
     */
    public static function friend_suggestions($username)
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
        $result = $CI->neo->execute_query($queryString, array('email' => $username));
        if($result)
            return self::returnAsUsers($result);
    }
	/**
     * WIP: Suggest friends using collaborative recommendation
     *
     * @access public
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
        if($result)
            return self::returnAsUsers($result);
    }
    /**
     * Creates an array of users from a ResultSet
     *
     * @access protected
     * @param  ResultSet $results Query results
     * @return User[]    Array of users
     */
    protected static function returnAsUsers(Everyman\Neo4j\Query\ResultSet $results)
    {
        $CI = get_instance();
        $userArray = array();
        foreach ($results as $row) {

            $user = $CI->user->fromNode($row['x']->getLabel());
            if (isset($row['common'])) {
                $user->commonFriends = $row['common'];
            }
            $userArray[] = $user;
        }

        return $userArray;
    }
    /**
     * Creates an array of books from a ResultSet
     *
     * @access protected
     * @param  ResultSet $results Query results
     * @return Book[]    Array of books
     */
    protected static function returnAsBooks(Everyman\Neo4j\Query\ResultSet $results)
    {
        $CI = get_instance();
        $book_array = array();
        foreach ($results as $row) {
            $book = $CI->book->fromNode($row['x']);
            if (isset($row['common'])) {
                $book->commonReaders = $row['common'];
            }
            $book_array[] = $book;
        }

        return $book_array;
    }
}