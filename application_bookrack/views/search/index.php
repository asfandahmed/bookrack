<div class="row">
	<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-sm-2 col-md-2 col-lg-2">
		<?php $this->load->view('search/filters.php')?>
	</div>
	<div class="middle-content col-sm-6 col-md-6 col-lg-6">
		<?php if(isset($results)):?>
			<?php if(empty($results)):?>
				<div class="custom-panel">Sorry, no matches.</div>
			<?php else:
					
					$base_url=base_url();
					$site_url=site_url();
					foreach ($results as $key):
						$label=$key["type"][0];
						switch ($label) {
							case 'User':
			?>

			<div class="row">
				<div class="col-md-12">
		            <div class="well well-sm">
		                <div class="media">
		                    <a class="thumbnail pull-left" href="<?=$site_url?>/profile/<?=$key["id"]?>">
		                        <img class="media-object" src="<?=base_url('assets/uploads/thumbs')?>/<?=($key["image"])?$key["image"]:"user-pic.jpg"?>" height="72px" width="72px">
		                    </a>
		                    <div class="media-body">
		                        <h4 class="media-heading"><a class="username" href="<?=$site_url?>/profile/<?=$key["id"]?>"><?=$key["name"]?></a></h4>
		                		<p><span class="label label-info"><?=$key['books']?> books</span> <span class="label label-warning"><?=$key['followers']?> followers</span></p>
		                        <p>
		                            <?php if(!$key['relation']):?>
		                            <a href="<?=site_url('user/follow')?>" id="followBtn" userToBeFollowed="<?=$key["id"]?>" class="btn btn-xs btn-default">Follow</a>
		                        	<?php else:?>
		                        	<a href="<?=site_url('user/unfollow')?>" id="unfollowBtn" usertobeunfollowed="<?=$key["id"]?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Unfollow</a>
		                        	<a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-comment"></span> Message</a>	
		                        	<?php endif;?>
		                        	<!--<a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-heart"></span> Favorite</a>-->
		                        </p>
		                    </div>
		                </div>
		            </div>
		        </div>
			</div>
				<!-- <div class="custom-panel">
					<div class="row">
						<div class="col-sm-2 col-md-2 col-lg-2"><img src="<?=$base_url.'assets/images/user-pic.jpg'?>" alt="" title=""></div>
						<div class="col-sm-8 col-md-8 col-lg-8"><a class="username" href="<?=$site_url?>/profile/<?=$key["id"]?>"><?=$key["name"]?></a></div>
						<div class="col-sm-2 col-md-2 col-lg-2"></div>
					</div>
				</div> -->
			<?php			
							break;
							case 'Book':
			?>
				<div class="row">
					<div class="col-md-12">
			            <div class="well well-sm">
			                <div class="media">
			                    <a class="thumbnail pull-left" href="<?=$site_url?>/book/<?=$key["id"]?>">
			                        <img class="media-object" src="<?=base_url('assets/uploads/profile_images')?>/<?=($key["image"])?$key["image"]:"user-pic.jpg"?>" height="72px" width="72px">
			                    </a>
			                    <div class="media-body">
			                        <h4 class="media-heading"><a class="username" href="<?=$site_url?>/book/<?=$key["id"]?>"><?=$key["name"]?></a></h4>
			                		<p><a href="<?=$site_url?>/search/book/<?=$key["id"]?>/<?=$key["name"]?>"><span class="label label-info"><?=$key["owners"]?> owners</span></a> <!--<span class="label label-warning">150 followers</span>--></p>
			                        <p>
			                            <!--<a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-comment"></span> Message</a>
			                            <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-heart"></span> Favorite</a>
			                            <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Unfollow</a>-->
			                        </p>
			                    </div>
			                </div>
			            </div>
			        </div>
				</div>
			<?php			
							break;
							case 'Author':
			?>
				<div class="row">
					<div class="col-md-12">
			            <div class="well well-sm">
			                <div class="media">
			                    <a class="thumbnail pull-left" href="<?=$site_url?>/author/<?=$key["id"]?>">
			                        <img class="media-object" src="<?=base_url('assets/uploads/profile_images')?>/<?=($key["image"])?$key["image"]:"user-pic.jpg"?>" height="72px" width="72px">
			                    </a>
			                    <div class="media-body">
			                        <h4 class="media-heading"><a class="username" href="<?=$site_url?>/author/<?=$key["id"]?>"><?=$key["name"]?></a></h4>
			                		<p><span class="label label-info">888 books</span> <span class="label label-warning">150 followers</span></p>
			                        <p>
			                            <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-comment"></span> Message</a>
			                            <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-heart"></span> Favorite</a>
			                            <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Unfollow</a>
			                        </p>
			                    </div>
			                </div>
			            </div>
			        </div>
				</div>
			<?php			
							break;
							case 'Publisher':
			?>
				<div class="row">
					<div class="col-md-12">
			            <div class="well well-sm">
			                <div class="media">
			                    <a class="thumbnail pull-left" href="<?=$site_url?>/publisher/<?=$key["id"]?>">
			                        <img class="media-object" src="<?=base_url('assets/uploads/profile_images')?>/<?=($key["image"])?$key["image"]:"user-pic.jpg"?>" height="72px" width="72px">
			                    </a>
			                    <div class="media-body">
			                        <h4 class="media-heading"><a class="username" href="<?=$site_url?>/publisher/<?=$key["id"]?>"><?=$key["name"]?></a></h4>
			                		<p><span class="label label-info">888 books</span> <span class="label label-warning">150 followers</span></p>
			                        <p>
			                            <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-comment"></span> Message</a>
			                            <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-heart"></span> Favorite</a>
			                            <a href="#" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Unfollow</a>
			                        </p>
			                    </div>
			                </div>
			            </div>
			        </div>
				</div>
			<?php } ?>
			<?php endforeach;?>
			<?php endif;?>
		<?php else:?>
			<div class="custom-panel">Sorry, no matches.</div>
		<?php endif;?>
	</div>
	<div class="right-panel col-sm-3 col-md-3 col-lg-3">
		<?php
			$this->load->view('site/suggestions.php');
		?>
	</div>
</div>