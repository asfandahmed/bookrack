<?php 
$site_url=site_url('profile');
if(isset($followers)):
				foreach ($followers as $follower):
		?>
<div class="col-sm-4 col-md-4 col-lg-4 user-box">
<div class="row">
	<div class="col-sm-3 col-md-3 col-lg-3"><img src="<?=base_url().'assets/images/user-pic.jpg'?>" alt="" title=""></div>
	<div class="col-sm-9 col-md-9 col-lg-9">
		<div class="col-sm-12 col-md-12 col-lg-12"><a href="<?=$site_url?>/<?=$follower['id']?>" class="username"><?=ucfirst($follower["first_name"]).' '.ucfirst($follower["last_name"])?></a></div>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<p><?php echo substr($follower["about"], 0,15)?></p>
			<!--<button class="btn btn-primary pull-right" id="follow_unfollow" onclick="">Follow</button>-->
		</div>
	</div>
</div>
</div>
<?php endforeach;?>
<?php endif;?>
<?php if(isset($followings)):
				foreach ($followings as $following):
		?>
<div class="col-sm-4 col-md-4 col-lg-4 user-box">
<div class="row">
	<div class="col-sm-3 col-md-3 col-lg-3"><img src="<?=base_url().'assets/images/user-pic.jpg'?>" alt="" title=""></div>
	<div class="col-sm-9 col-md-9 col-lg-9">
		<div class="col-sm-12 col-md-12 col-lg-12"><a href="<?=$site_url?>/<?=$following['id']?>" class="username"><?=ucfirst($following["first_name"]).' '.ucfirst($following["last_name"])?></a></div>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<p><?php  echo substr($following["about"], 0,15)?></p>
			<!--<button class="btn btn-primary pull-right" id="follow_unfollow" onclick="">Follow</button>-->
		</div>
	</div>
</div>
</div>
<?php endforeach;?>
<?php endif;?>