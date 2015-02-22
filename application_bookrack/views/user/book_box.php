<?php if(isset($books)):
$url=site_url('/books');
foreach ($books as $book):
?>
<div class="col-sm-12 col-md-4 col-lg-4 ic_container">
	    <img src="<?=base_url().'assets/images/book-256.png'?>" class="img-responsive" alt="<?=$book[0]->title?>"/>
	    <div class="overlay" style="display:none;"></div>
	    <div class="ic_caption">
	        <p class="ic_category"><?=isset($book['genre']['genre'])?ucfirst($book['genre']['genre']):"Other"?></p>
	        <h5><a href="<?=site_url()."/book/".$book[0]->getID()?>"><?=ucfirst($book[0]->title)?></a></h5>
	        <p class="ic_text"><?=substr($book[0]->description, 0,30)?></p>
	</div>
</div>
<?php endforeach;endif;?>