
<?php

$base_url=base_url();
$profile_url=site_url('profile');
$comments_url=site_url('showcomments');
$site_url=site_url();
$full_name=ucfirst($this->session->userdata('first_name')).' '.ucfirst($this->session->userdata('last_name'));
if($this->session->userdata('profile_image'))
	$image_path=$base_url.'assets/uploads/thumbs/'.$this->session->userdata('profile_image');
else
	$image_path=$base_url.'assets/images/user-pic.jpg';

if(isset($posts)):
foreach ($posts as $post):
?>
<div class="col-sm-12 col-md-12 col-lg-12 custom-panel post posts" id="post_<?=$post->statusId?>">
		
		<div class="row">
			<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2"><a  href="<?=$profile_url.'/'.$post->userIdForPost?>" rel="nofollow"><img src="<?=$base_url.'assets/uploads/thumbs/'.$post->userImageForPost?>" alt="" title="" style="width:50px;height:43px;"></a></div>
			<div class="col-sm-10 col-md-10 col-lg-10"><a  href="<?=$profile_url.'/'.$post->userIdForPost?>"><b class="post-username"><?=$post->userNameForPost?></b></a> <?php if($post->bookPost !== null):?><em>added a book.</em><?php endif;?>
				<div class="dropdown pull-right">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
		          	<span class="caret"></span>
		          </a>
		          <ul class="dropdown-menu" role="menu">
		            <li><a class="btn-hide" data-post="<?=$post->statusId?>" href="#">Hide</a></li>
		            <?php if($post->owner):?>
		            <li class="divider"></li>
		            <li><a class="btn-remove" data-postId="<?=$post->statusId?>" data-url="<?=$site_url?>/post/delete" href="#">Remove</a></li>
		          	<?php endif;?>
		          </ul>
		        </div>
			</div>
		</div>
		<div class="row postBook">
			<?php if($post->bookPost !== null):?>
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-6 col-sm-4 col-md-4 col-lg-4"><img src="<?=base_url().'assets/images/book-256.png'?>" height="120px" width="120px" alt="" title=""></div>
			<div class="col-sm-6 col-md-6 col-lg-6 post-book-info">
				<ul>
					<li><a class="username" href="<?=$site_url.'/book/'.$post->bookPost->getId()?>"><?=$post->bookPost->getProperty('title');?></a></li>
					<li>by </li>
					<li>Ratings</li>
				</ul>
			</div>
			<?php else:?>
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-10 col-md-10 col-lg-10">
				<?=$post->title;?>
			</div>
			<?php endif;?>
		</div>

		

	<div class="col-sm-12 col-md-12 col-lg-12 social-bar">
		<ul>
			<li><?php if(empty($post->likes)):?>
					<a href="<?=$site_url.'/like/'.$post->statusId?>" class="like-button"><span>Like</span></a>
				<?php else:?>
					<a href="<?=$site_url.'/unlike/'.$post->statusId?>" class="unlike-button"><span>Unlike</span></a>
				<?php endif;?>
			</li>
			<li><a href="#" class="comment-button" data-post="<?=$post->statusId?>"><span>Comment</span></a></li>
			<!--<li><a href="#">Favorite</a></li>-->
			<?php if($post->bookPost !== null && $post->owner==false):?>
			<li><a class="btn-wishlist" data-book="<?=$post->bookPost->getProperty('title');?>" href="<?=$site_url?>/wishlist">Wishlist</a></li>
			<?php endif;?>
			<!--<li><a href="#">Share</a></li>-->
		</ul>
	</div>
	<hr>

	<div class="col-sm-12 col-md-12 col-lg-12 comment_bar" id="commentbar_<?=$post->statusId?>">
		<div class="row"><a class="commentsloader" href="<?=$comments_url.'/'.$post->statusId?>">view comments</a></div>
		<div class="row">
			<div class="col-sm-2 col-md-2 col-lg-2"><img src="<?=$image_path?>" alt="" title="" style="width:50px;height:43px;"></div>
			<div class="col-sm-10 col-md-10 col-lg-10">
				<?php echo form_open($site_url.'/post/comment', array('id'=>'form_'.$post->statusId, 'name'=>'comment_form', 'onsubmit'=>'return false;', 'class'=>'form-horizontal', 'method'=>'post'));?>
					<input type="hidden" name="strsts" value="<?=sha1($post->statusId)?>">
					<input type="hidden" name="statusId" value="<?=$post->statusId?>">
					<div class="input-group">
					<input type="text" name="comment" placeholder="Comment" class="form-control" value="" autocomplete="off">
						<div class="input-group-btn">
						<input type="submit" name="submitcomment" onclick="postComment(form_<?=$post->statusId?>)" value="comment" class="btn btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12" style="visibility:hidden">
		<a class="more" href="<?=$site_url?>/load/posts/<?=isset($skip)?$skip:0?>/<?=isset($limit)?$limit:10?>"></a>
	</div>

</div>
<?php 
endforeach; endif;
?>