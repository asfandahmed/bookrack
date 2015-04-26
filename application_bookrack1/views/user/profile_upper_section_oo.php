
<header id="header">
	<div id="head" class="parallax" parallax-speed="2">
		<h1 id="logo" class="text-center">
			<img class="img-circle" src="<?=base_url().'assets/images/muneeb.jpg'?>" alt="" >

			<span class="title">Muhammad Muneeb</span>

			<span class="tagline">A mystery person<br>
				<span calss="glyphicon glyphicon-camera"></span>
				<a href="">anthony.russel42@example.com</a></span>
		</h1>
	</div>
	<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true" >
    
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">change profile </a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">change cover</a></li>
   
  </ul>
</div>
<span class="glyphicon glyphicon-camera" aria-hidden="true"></span>

<div class="row user-upper-section">
	
	<div class="col-sm-8 col-md-8 col-lg-16 user-basic-info-section">
	

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
