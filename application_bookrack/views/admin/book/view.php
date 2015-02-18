<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<ul class="list-group">
			<li class="list-group-item"><b>Title</b> <?=isset($title)?$title:""?></li>
			<li class="list-group-item"><b>Description</b> <p><?=isset($description)?$description:""?></p></li>
			<li class="list-group-item"><b>Author</b> <?=isset($author)?$author:""?></li>
			<li class="list-group-item"><b>Genre</b> <?=isset($genre)?$genre:""?></li>
			<li class="list-group-item"><b>Publisher</b> <?=isset($publisher)?$publisher:""?></li>
			<li class="list-group-item"><b>Published date</b> <?=isset($published_date)?$published_date:""?></li>
			<li class="list-group-item"><b>Edition</b> <?=isset($edition)?$edition:""?></li>
			<li class="list-group-item"><b>ISBN-10</b> <?=isset($isbn_10)?$isbn_10:""?></li>
			<li class="list-group-item"><b>ISBN-13</b> <?=isset($isbn_13)?$isbn_13:""?></li>
			<li class="list-group-item"><b>Language</b> <?=isset($language)?$language:""?></li>
			<li class="list-group-item"><b>Ratings</b> <?=isset($ratings)?></li>
			<li class="list-group-item"><b>Pages</b> <?=isset($total_pages)?$total_pages:""?></li>
		</ul>
	</div>
	</div>