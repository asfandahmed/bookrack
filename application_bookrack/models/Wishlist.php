<?php 
require 'Book_List.php';

class Wishlist extends Book_List{

	public function __construct()
	{
		parent::__construct();
		$this->relation='WISHES';
	}
}
/* End of file Wishlist.php */