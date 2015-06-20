<div class="middle-content col-sm-6 col-md-6 col-lg-6">
<div class="row">
	<div class="col-md-12">
		Nearby users having <?=$bookTitle?> book:
	</div>
</div>
<?php
	if(isset($users)):
	$site_url=site_url();
	foreach ($users as $user):?>
		<div class="row">
					<div class="col-md-12">
			            <div class="well well-sm">
			                <div class="media">
			                    <a class="pull-left" href="<?=$site_url?>/user/<?=$user["id"]?>">
			                        <img class="media-object" src="<?=base_url('assets/uploads/profile_images')?>/<?=($user["image"])?$user["image"]:"user-pic.jpg"?>" height="72px" width="72px">
			                    </a>
			                    <div class="media-body">
			                        <h4 class="media-heading"><a class="username" href="<?=$site_url?>/user/<?=$user["id"]?>"><?=$user["username"]?></a></h4>
			                		<p><span class="label label-info"><?=$this->common_functions->convert_distance($user["distance"])?> miles</span> <a class="btnBorrow" href="<?=$site_url?>/borrow/request" bookid="<?=$bookId?>" Booktitle="<?=$bookTitle?>" to="<?=$user["id"]?>"><span class="label label-warning">Borrow request</span></a></p>
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
endforeach;
else:?>
<script type="text/javascript">$(document).ready(function(){getLocation();});</script>
<?php endif;?>
</div>