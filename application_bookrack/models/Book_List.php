<?php
class Book_List{
	protected $CI;
	protected $relation;
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('neo');
		$this->CI->load->model(array('genre','book','author'));
	}
	public function get($user_id)
	{
		$cypher = "START u=node({id}) 
			MATCH (u)-[:" . $this->relation . "]->(b:Book) 
			WITH b
			OPTIONAL MATCH (b)-[:GENRE]->(g:Genre)
			OPTIONAL MATCH (b)<-[:WROTE]-(a:Author)
			WITH b, g, a 
			RETURN b, g, a";
		$result = $this ->CI->neo->execute_query($cypher, array('id'=>intval($user_id)));
		return $this->return_mapped_content($result);
	}
	public function add_book($user_id, $title)
	{
		$query="MATCH (u:User {id:{userId}})
				MERGE (m:Book {title:{title}})
				CREATE UNIQUE (u)-[r:" . $this->relation . " {timestamp:{timestamp}}]->(b)
				RETURN r";
		return  $this->CI->neo->execute_query($cypher, array(
			'userId'=>intval($user_id),
			'name'=>intval($title),
			'timestamp'=>time()
			)
		);
	}
	public function delete_book($user_id, $book_id)
	{
		$cypher = "MATCH (u:User {id:{userId}})-[r:" . $this->relation . "]->(b:Book {id:{bookId}} DELETE r";
		return  $this->CI->neo->execute_query($cypher, array(
			'userId'=>intval($user_id),
			'bookId'=>intval($book_id)
			)
		);
	}
	public function return_mapped_content(Everyman\Neo4j\Query\ResultSet $results)
	{
		$mappedContentArray = array();
        foreach ($results as $row) {
            $mappedContentArray[] = $this->from_node(
                $row['b'],
                $row['g'],
                $row['a']
            );
        }

        return $mappedContentArray;
	}
	public function from_node(Everyman\Neo4j\Node $book, Everyman\Neo4j\Node $genre=NULL, Everyman\Neo4j\Node $author=NULL)
	{
			$book = $this->CI->book->fromNode($book);
			$book->genre = ($genre != NULL) ? $this->CI->genre->fromNode($genre) : NULL;
			$book->author = ($author != NULL) ? $this->CI->author->fromNode($author) : NULL;
			return $book;
	}
}