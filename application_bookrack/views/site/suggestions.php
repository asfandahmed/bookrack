<div class="col-sm-12 col-md-12 col-lg-12 suggestion">
	<?php if(isset($suggestions)):?>
	<div class='row'>
	<div class="col-sm-12 col-md-12 col-lg-12"><em style="text-transform:uppercase">suggested users</em></div></div><br>
	<?php 
	$site_url=site_url();
	$image_path=base_url().'assets/uploads/thumbs/';
	foreach ($suggestions as $usr):?>
		<div class="row" id="row-<?=$usr->id?>">
			<div class="col-sm-4 col-md-4 col-lg-4">
			<img src="<?=$image_path?>/<?=empty($usr->profile_image)?'user-pic.jpg':$usr->profile_image?>" alt="<?=$usr->first_name.' '.$usr->last_name?>" title="<?=$usr->first_name.' '.$usr->last_name?>">
			</div>
			<div class="col-sm-8 col-md-8 col-lg-8">
				<span><a href="<?=$site_url.'/profile/'.$usr->id?>" class="username"><?=$usr->first_name.' '.$usr->last_name?></a></span>
				<br><a href="<?=site_url('user/follow')?>" id="u<?=$usr->id?>" class="SuggfollowBtn" data-user="<?=$usr->id?>"><span class="low-attention">Follow</span></a>
				<br><a href="#" class="" data-user="<?=$usr->id?>"><span class="low-attention"><?=($usr->commonFriends>0)?$usr->commonFriends.' common following ':''?></span></a>
				
			</div>
		</div>
		<hr style="margin:0px 0px 5px 0px;line-height:0px;">
	<?php endforeach;endif;?>
	&nbsp;
</div>
<br><br>
<div class="col-sm-12 col-md-12 col-lg-12 custom-panel">
	&nbsp;
</div>