<?php 
require 'Book_List.php';

class Shelf extends Book_List{
	public function __construct() {
		parent::__construct();
		$this->relation = 'OWNS';
	}
}
/* End of file Shelf.php */