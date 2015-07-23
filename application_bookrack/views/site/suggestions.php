<div class="col-sm-12 col-md-12 col-lg-12 suggestion">
	<?php if(isset($folllow_suggestions)):?>
	<div class='row'>
	<div class="col-sm-12 col-md-12 col-lg-12"><em style="text-transform:uppercase">suggestions</em></div></div><br>
	<?php 
	$site_url=site_url();
	$image_path=base_url().'assets/uploads/thumbs/';
	foreach ($folllow_suggestions as $usr):?>
		<div class="row" id="row-<?=$usr->id?>">
			<div class="col-sm-4 col-md-4 col-lg-4">
			<a href="<?=$site_url.'/profile/'.$usr->id?>"><img src="<?=empty($usr->profile_image)?$image_path.'user-pic.jpg':$image_path.$usr->profile_image?>" alt="<?=$usr->first_name.' '.$usr->last_name?>" title="Click to see <?=$usr->first_name.' '.$usr->last_name?>'s profile"></a>
			</div>
			<div class="col-sm-8 col-md-8 col-lg-8">
				<span><a href="<?=$site_url.'/profile/'.$usr->id?>" class="username"><?=$usr->first_name.' '.$usr->last_name?></a></span>
				<br><a href="<?=site_url('user/follow')?>" id="u<?=$usr->id?>" title="Follow <?=$usr->first_name.' '.$usr->last_name?>" class="SuggfollowBtn" data-user="<?=$usr->id?>"><span class="low-attention">Follow</span></a>
				<br><a href="#" class="" data-user="<?=$usr->id?>"><span class="low-attention"><?=($usr->commonFriends>0)?$usr->commonFriends.' common following ':''?></span></a>
				
			</div>
		</div>
		<hr style="margin:2.5px 0px;line-height:0px;">
	<?php endforeach;endif;
		 if(isset($book_suggestions)):
	$site_url=site_url();
	$image_path=base_url().'assets/uploads/thumbs/';
	foreach ($book_suggestions as $book):?>
		<div class="row" id="row-<?=$book->id?>">
			<div class="col-sm-4 col-md-4 col-lg-4">
			<a href="<?=$site_url.'/book/'.$book->id?>"><img src="<?=$image_path?>/user-pic.jpg" alt="<?=$book->title?>" title="<?=$book->title?>"></a>
			</div>
			<div class="col-sm-8 col-md-8 col-lg-8">
				<span><a href="<?=$site_url.'/book/'.$book->id?>" class="username"><?=$book->title?></a></span>
				<br><a href="#" class="" data-user="<?=$book->id?>"><span class="low-attention"><?=($book->commonReaders>0)?$book->commonReaders.' common reader ':''?><?=($book->commonReaders>1)?'s':''?></span></a>
				
			</div>
		</div>
		<hr style="margin:2.5px 0px;line-height:0px;">
	<?php endforeach;endif;?>	
	&nbsp;
</div>