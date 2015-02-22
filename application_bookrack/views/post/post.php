
<?php 
if(isset($user)){
	$full_name=ucfirst($user->first_name).' '.ucfirst($user->last_name);
	if(!empty($user->profile_image))
		$image_path=base_url().'assets/uploads/profile_images/'.$user->profile_image;
	else
		$image_path=base_url().'assets/images/user-pic.jpg';
}
else{
	$full_name=ucfirst($this->session->userdata('first_name')).' '.ucfirst($this->session->userdata('last_name'));
	if($this->session->userdata('profile_image'))
		$image_path=base_url().'assets/uploads/profile_images/'.$this->session->userdata('profile_image');
	else
		$image_path=base_url().'assets/images/user-pic.jpg';
}
if(isset($posts)):
foreach ($posts as $post):
?>
<div class="col-sm-12 col-md-12 col-lg-12 custom-panel post posts">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			<div class="col-sm-2 col-md-2 col-lg-2"><a  href="<?=site_url('profile/')?>" rel="nofollow"><img src="<?=$image_path?>" alt="" title="" style="width:50px;height:43px;"></a></div>
			<div class="col-sm-10 col-md-10 col-lg-10"><a  href="<?=site_url('profile/')?>"><b class="post-username"><?=$full_name?></b></a> <!--<em>is reading</em>-->
				<div class="dropdown pull-right">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></a>
		          <ul class="dropdown-menu" role="menu">
		            <li><a href="#">Hide</a></li>
		            <li class="divider"></li>
		            <li><a href="#">Remove</a></li>
		          </ul>
		        </div>
			</div>
		</div>
		
		<div class="row" id="post_<?=$post->statusId?>">
			<!--<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-2 col-md-2 col-lg-2"><img src="<?=base_url().'assets/images/user-pic.jpg'?>" alt="" title=""></div>
			<div class="col-sm-8 col-md-8 col-lg-8 post-book-info">
				<ul>
					<li>The fault in our stars</li>
					<li>by</li>
					<li>Ratings</li>
				</ul>
			</div>-->
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-10 col-md-10 col-lg-10">
				<?=$post->title;?>
			</div>
		</div>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 social-bar">
		<ul>
			<li><a href="#" class="like-button">Like</a></li><li><a href="#" onclick="showcommentbox(<?=$post->statusId?>)">Comment</a></li><li><a href="#">Favorite</a></li><li><a href="#">Wishlist</a></li><li><a href="#">Share</a></li>
		</ul>
	</div>
	<hr>
	<div class="col-sm-12 col-md-12 col-lg-12 comment_bar" id="commentbar_<?=$post->statusId?>">
		<div class="row"><div class="col-sm-12 col-md-12 col-lg-12">view all comments</div></div>
		<div class="row">
			<div class="col-sm-2 col-md-2 col-lg-2"><img src="<?=$image_path?>" alt="" title=""></div>
			<div class="col-sm-10 col-md-10 col-lg-10">
			</div>
		</div>
	</div>
</div>
<?php 
endforeach; endif;
?>