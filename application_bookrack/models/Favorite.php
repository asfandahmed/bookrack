<?php
require 'Book_List.php';

class Favorite extends Book_List{
	public function __construct()
	{
		parent::__construct();
		$this->relation = 'FAVORITES';
	}
}
