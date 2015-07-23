<?php 
	$fullname=ucfirst($this->session->userdata('first_name')).' '.ucfirst($this->session->userdata('last_name'));
	if($this->session->userdata('profile_image'))
		$image_path=base_url().'assets/uploads/thumbs/'.$this->session->userdata('profile_image');
	else
		$image_path=base_url().'assets/images/user-pic.jpg';
?>
<div class="col-sm-12 col-md-12 col-lg-12 custom-panel user-info-div">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">
			<img src="<?=$image_path?>" style="width:50px;height:43px" alt="<?=$fullname?>" title="<?=$fullname?>">
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8"><?=$fullname?></div>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 info-bar">
			<ul>
				<li><a href="<?=site_url('profile')?>">Timeline</a></li>
				<li><a href="<?=site_url('shelf')?>">Shelf</a></li>
				<li><a href="<?=site_url('wishlist')?>">Wishlist</a></li>
			</ul>
	</div>
	<div class="clear"></div>
	<div class="col-sm-12 col-md-12 col-lg-12 user-info-table">
		<table class="table table-responsive">
			<tr>
				<th>Books</th><th>Following</th><th>Followers</th>
			</tr>
			<tr>
				<td><a href="<?=site_url('shelf')?>"><?=$user_info[2][0]['books']?></a></td><td><a href="<?=site_url('following')?>"><?=$user_info[0][0]['following']?></a></td><td><a href="<?=site_url('followers')?>"><?=$user_info[1][0]['followers']?></a></td>
			</tr>
		</table>
	</div>
</div>