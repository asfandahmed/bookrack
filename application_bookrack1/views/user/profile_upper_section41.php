


<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
	<div class="row panel">
		<div class="col-md-4 bg_blur ">
    	    <a href="#" class="follow_btn hidden-xs">Follow</a>
		</div>
        <div class="col-md-8  col-xs-12">
           <img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="img-thumbnail picture hidden-xs" />
           <img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="img-thumbnail visible-xs picture_mob" />
           <div class="header">
                <h1>Muneeb</h1>
                <h4>Web Developer</h4>
                <span>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."
"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."</span>
           </div>
        </div>
    </div>   
    
	<div class="row nav">    
        <div class="col-md-4"></div>
        <div class="col-md-8 col-xs-12" style="margin: 0px;padding: 0px;">
            <div class="col-md-4 col-xs-4 well"><i class="fa fa-weixin fa-lg"></i> <a href="<?=site_url('profile').'/'.$user->getId()?>"<?=($this->router->method=="index")?' class="active"':""?>>Timeline</a></div>
            <div class="col-md-4 col-xs-4 well"><i class="fa fa-heart-o fa-lg"></i> 14</div>
            <div class="col-md-4 col-xs-4 well"><i class="fa fa-thumbs-o-up fa-lg"></i> 26</div>
        </div>
    </div>
</div>


	<div class="col-sm-16 col-md-16 col-lg-16 user-basic-info-section">
		
		<div class="col-sm-16 col-md-16 col-lg-16 bar">
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
