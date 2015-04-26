
<div class="col-sm-17 col-md-17 col-lg-17 profile-cover">
				<?php if($owner) {?>
				<div id="profile_cover" >
                    <img src="<?=base_url().'assets/images/2.png'?>" height="271px" width="100%">
                    <div class="overlay" style="display:none;"></div>
                    <a data-target="#inboxModal" data-toggle="modal">
                    <div class="ic_caption">
						&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-camera"></span>&nbsp;&nbsp;<span style="font-size:0.8em">Update Picture</span><br><br>
                    </div>
                	</a>	
                </div>
                <?php }else{?>
                <img src="<?=base_url().'assets/images/2.png'?>" height="130px">	
                <?php }?>
        </div>

<div class="row user-upper-section">
	<div class="col-sm-4 col-md-4 col-lg-4  user-image-section">
		<div class="col-sm-7 col-md-7 col-lg-7 bar left-bar">&nbsp;</div>
		<div class="col-sm-5 col-md-5 col-lg-5 profile-pic">
				<?php if($owner) {?>
				<div id="profile_pic_box" class="ic_container">
                    <img src="<?=base_url().'assets/images/user-pic.jpg'?>" height="130px">
                    <div class="overlay" style="display:none;"></div>
                    <a data-target="#inboxModal" data-toggle="modal">
                    <div class="ic_caption">
						&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-camera"></span>&nbsp;&nbsp;<span style="font-size:0.8em">Update Picture</span><br><br>
                    </div>
                	</a>	
                </div>
                <?php }else{?>
                <img src="<?=base_url().'assets/images/user-pic.jpg'?>" height="130px">	
                <?php }?>
        </div>
	</div>
	<div class="col-sm-8 col-md-8 col-lg-8 user-basic-info-section">
		<div class="col-sm-11 col-md-11 col-lg-11"><h3><?=ucfirst($user->first_name).' '.ucfirst($user->last_name)?></h3></div>
		<div class="col-sm-11 col-md-11 col-lg-11 bar">
			<ul>
				<li><a href="<?=site_url('profile').'/'.$user->getId()?>"<?=($this->router->method=="index")?' class="active"':""?>>Timeline</a></li>
				<li><a href="<?=site_url('shelf').'/'.$user->getId()?>">Shelf</a></li>
				<li><a href="<?=site_url('wishlist').'/'.$user->getId()?>">Wishlist</a></li>
			</ul>
		</div>
		<div class="clear"></div>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-3 col-md-3 col-lg-3">
			<table class="table table-responsive">
			<tr>
				<th <?=($this->router->method=="shelf")?'class="active"':""?>>Books</th><th<?=($this->router->method=="following")?' class="active"':""?>>Following</th><th<?=($this->router->method=="followers")?' class="active"':""?>>Followers</th>
			</tr>
			<tr>
				<td <?=($this->router->method=="shelf")?'class="active"':""?>><a href="<?=site_url('shelf').'/'.$user->getId()?>"><?=$user_info[1][0]['books']?></a></td>
				<td<?=($this->router->method=="following")?' class="active"':""?>><a href="<?=site_url('following').'/'.$user->getId()?>"><?=$user_info[0][0]['following']?></a></td>
				<td<?=($this->router->method=="followers")?' class="active"':""?>><a href="<?=site_url('followers').'/'.$user->getId()?>"><?=$user_info[0][0]['followers']?></a></td>
			</tr>
			</table>
			</div>
		</div>
	</div>
</div>
