<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
	<div class="row panel">
		<div class="col-md-4 bg_blur ">
    	    <!--<a href="#" class="follow_btn hidden-xs">Follow</a>-->
		</div>
        <div class="col-md-8  col-xs-12">
            <div class="img-thumbnail picture hidden-xs" >
                <?php if($owner) {
           		if(!empty($user->profile_image))
					$image_path=base_url().'assets/uploads/profile_images/'.$user->profile_image;
				else
					$image_path=base_url().'assets/images/user-pic.jpg';
           	    ?>
				
                <img id="profilePicture" src="<?=$image_path?>" height="140px" width="140px">
                <div class="overlay" style="display:none;"></div>
                <a href="<?=site_url('users/load_user_pic_uploader')?>" data-target="#contentModal" data-toggle="modal" id="upload_image_loader">
                    <div class="ic_caption">
    					&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-camera"></span>&nbsp;&nbsp;<span style="font-size:0.8em">Update Picture</span><br><br>
                    </div>
                </a>	
            
                <?php }else{?>
                <img src="<?=base_url().'assets/images/user-pic.jpg'?>" height="140px" width="140px">	
                <?php }?>

            </div>    
            </div>


         <div class="headerInfo">

                <h1><?=ucfirst($user->first_name).' '.ucfirst($user->last_name)?></h1>
                <!--<h4>&nbsp;&nbsp;&nbsp;&nbsp;Web Developer</h4>-->
                <span><?=$user->about?></span>
                <br>

                <table class="tableForCover">
            <tr>
                <th <?=($this->router->method=="shelf")?'class="active"':""?>>Books</th><th<?=($this->router->method=="following")?' class="active"':""?>>Following</th><th<?=($this->router->method=="followers")?' class="active"':""?>>Followers</th>
            </tr>
            <tr>
                <td <?=($this->router->method=="shelf")?'class="active"':""?>><a href="<?=site_url('shelf').'/'.$user->id?>"><?=$user_info[2][0]['books']?></a></td>
                <td<?=($this->router->method=="following")?' class="active"':""?>><a href="<?=site_url('following').'/'.$user->id?>"><?=$user_info[0][0]['following']?></a></td>
                <td<?=($this->router->method=="followers")?' class="active"':""?>><a href="<?=site_url('followers').'/'.$user->id?>"><?=$user_info[1][0]['followers']?></a></td>
            </tr>
            </table>

           </div>
        </div>
      
    
	<div class="row nav">    
        <div class="col-md-4"></div>
        <div class="col-md-8 col-xs-12" style="margin: 0px;padding: 0px;">
            <div class="col-md-4 col-xs-4 well"><i class="fa fa-weixin fa-lg"></i> <a href="<?=site_url('profile').'/'.$user->id?>"<?=($this->router->method=="index")?' class="active"':""?>>Timeline</a></div>
            <div class="col-md-4 col-xs-4 well"><i class="fa fa-heart-o fa-lg"></i><a href="<?=site_url('shelf').'/'.$user->id?>">Shelf</a></div>
            <div class="col-md-4 col-xs-4 well"><i class="fa fa-thumbs-o-up fa-lg" ></i><a href="<?=site_url('wishlist').'/'.$user->id?>">Wishlist</a></div>
        </div>
    </div>

   
    </div>
</div>
</div>