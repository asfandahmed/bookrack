<?php 
if(isset($books)):
	$url=site_url('/books');
foreach ($books as $book):
	?>
<div class="col-sm-12 col-md-4 col-lg-4 ic_container">
	<img src="<?=base_url().'assets/images/book-256.png'?>" class="img-responsive" alt="<?=$book->title?>"/>
	<div class="overlay" style="display:none;"></div>
	<div class="ic_caption">
		<p class="ic_category">
			<?=isset($book->genre->name) ? ucfirst($book->genre->name) : "Other" ?>
		</p>
		<h5>
			<a href="<?=site_url()."/book/".$book->id?>"><?=ucfirst($book->title)?></a>
		</h5>
		<p class="ic_text"><?= substr($book->description, 0, 30) ?></p>
	</div>
</div>
<?php endforeach;endif;?>