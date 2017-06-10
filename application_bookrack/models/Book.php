<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Book extends MY_Model
{
	public $id;
	public $title="";
	public $description="";
	public $author="";
	public $publisher="";
	public $published_date="";
	public $edition="";
	public $isbn_10="";
	public $isbn_13="";
	public $category="";
	public $language="";
	public $ratings="";
	public $total_pages="";
	public $image="";
	public $date_time="";

	const BOOK = 1;
	
	public function __construct() {
		parent::__construct();
	}

	
	public function relate_author($bookId,$author_name){
		$query="MATCH (n:Book)
				WHERE ID(n) = {id}
				MERGE (m:Author {name:{name}})
				CREATE UNIQUE (m)-[r:WROTE]->(n)
				RETURN r,n,m";
		return $this->neo->execute_query($query, array('id'=>intval($bookId),'name'=>$author_name));
	}
	public function relate_publisher($bookId,$publisher_name){
		$query="MATCH (n:Book)
				WHERE ID(n) = {id}
				MERGE (m:Publisher {company:{name}})
				CREATE UNIQUE (m)-[r:PUBLISHED]->(n)
				RETURN r,n,m";
		return $this->neo->execute_query($query, array('id'=>intval($bookId),'name'=>$publisher_name));
	}
	public function set_book() {
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$data=array(
			'title'=>$this->input->post('title'),
			'description'=>$this->input->post('description'),
			'published_date'=>$this->input->post('published_date'),
			'edition'=>$this->input->post('edition'),
			'isbn_10'=>$this->input->post('isbn_10'),
			'isbn_13'=>$this->input->post('isbn_13'),
			'language'=>$this->input->post('language'),
			'ratings'=>$this->input->post('ratings'),
			'total_pages'=>$this->input->post('total_pages'),
			'image'=>$this->input->post('image'),
			'dateTime'=>mdate($datestring, $time),
			);
		return $this->neo->insert('Book',$data);
	}
	public function update_book() {
		$id=$this->input->post('id');
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i %a";
		$time = time();
		$data=array(
			'title'=>$this->input->post('title'),
			'description'=>$this->input->post('description'),
			'published_date'=>$this->input->post('published_date'),
			'edition'=>$this->input->post('edition'),
			'isbn_10'=>$this->input->post('isbn_10'),
			'isbn_13'=>$this->input->post('isbn_13'),
			'language'=>$this->input->post('language'),
			'ratings'=>$this->input->post('ratings'),
			'total_pages'=>$this->input->post('total_pages'),
			'image'=>$this->input->post('image'),
			'dateTime'=>mdate($datestring, $time),
			);
		return $this->neo->update($id,$data);
	}
	public function fromNode(Everyman\Neo4j\Node $node) {
		$book = new Book();
		$book->id=$node->getId();
		$book->title=$node->getProperty('title');
		$book->description=$node->getProperty('description');
		$book->edition=$node->getProperty('edition');
		$book->isbn_10=$node->getProperty('isbn_10');
		$book->isbn_13=$node->getProperty('isbn_13');
		$book->language=$node->getProperty('language');
		$book->ratings=$node->getProperty('ratings');
		$book->total_pages=$node->getProperty('total_pages');
		$book->published_date=$node->getProperty('published_date');
		$book->date_time=$node->getProperty('dateTime');
		return $book;
	}
}