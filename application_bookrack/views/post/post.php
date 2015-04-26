
<?php 
/*
when image and user were comming from session or passed user
if(isset($user)){
	$full_name=ucfirst($user->first_name).' '.ucfirst($user->last_name);
	if(!empty($user->profile_image))
		$image_path=base_url().'assets/uploads/thumbs/'.$user->profile_image;
	else
		$image_path=base_url().'assets/images/user-pic.jpg';
}
else{
	$full_name=ucfirst($this->session->userdata('first_name')).' '.ucfirst($this->session->userdata('last_name'));
	if($this->session->userdata('profile_image'))
		$image_path=base_url().'assets/uploads/thumbs/'.$this->session->userdata('profile_image');
	else
		$image_path=base_url().'assets/images/user-pic.jpg';
}
*/
$base_url=base_url();
$site_url=site_url('profile');
$full_name=ucfirst($this->session->userdata('first_name')).' '.ucfirst($this->session->userdata('last_name'));
if($this->session->userdata('profile_image'))
	$image_path=$base_url.'assets/uploads/thumbs/'.$this->session->userdata('profile_image');
else
	$image_path=$base_url.'assets/images/user-pic.jpg';

if(isset($posts)):
foreach ($posts as $post):
?>

<div class="col-sm-12 col-md-12 col-lg-12 custom-panel post posts">
       
            <div class="[ panel panel-default ] panel-google-plus">
                <div class="dropdown">
                    <span class="dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="[ glyphicon glyphicon-chevron-down ]"></span>
                    </span>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                    </ul>
                </div>
                <div class="panel-google-plus-tags">
                    <ul>
                        <li>#Millennials</li>
                        <li>#Generation</li>
                    </ul>
                </div>
                <div class="panel-heading">
                <a  href="<?=$site_url.'/'.$post->userIdForPost?>" rel="nofollow"><img class="[ img-circle pull-left ]" src="<?=$base_url.'assets/uploads/thumbs/'.$post->userImageForPost?>" alt="" title="" style="width:50px;height:43px;"></a>
                   
                    <h3><a  href="<?=$site_url.'/'.$post->userIdForPost?>"><b class="post-username"><?=$post->userNameForPost?></b></a></h3>
                   
                </div>
                <div class="panel-body">
                   <h6> <p><?=$post->title;?></p> </h6>
                </div>
                <div class="panel-footer">
                    <button type="button" class="[ btn btn-default ]">+1</button>
                    <button type="button" class="[ btn btn-default ]">
                        <span class="[ glyphicon glyphicon-share-alt ]"></span>
                    </button>
                    <div class="input-placeholder">Add a comment...</div>
                </div>
                <div class="panel-google-plus-comment">
                    <img class="img-circle" src="https://lh3.googleusercontent.com/uFp_tsTJboUY7kue5XAsGA=s46" alt="User Image" />
                    <div class="panel-google-plus-textarea">
                        <textarea rows="4"></textarea>
                        <button type="submit" class="[ btn btn-success disabled ]">Post comment</button>
                        <button type="reset" class="[ btn btn-default ]">Cancel</button>
                    </div>
                    <div class="clearfix"></div> 
                </div>
            </div>
        
        
    </div>



<?php 
endforeach; endif;
?>