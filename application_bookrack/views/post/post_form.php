<?php
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
?>
<div class="col-sm-12 col-md-12 col-lg-12 custom-panel post">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			<div class="col-sm-2 col-md-2 col-lg-2"><img src="<?=$image_path?>" style="width:50px;height:43px;" alt="" title=""></div>
			<div class="col-sm-10 col-md-10 col-lg-10 status-post-control">
				<?php echo form_open(site_url('post'), array('id'=>'statusForm','name'=>'status_form','class'=>'form-horizontal', 'role'=>'form'));?>
					<div class="input-group">
						<input type="text" name="status" value="" class="form-control" placeholder="What are you reading?" autocomplete="off">
						<div class="input-group-btn"><button type="submit" name="post-status" onclick="postStatus()" class="btn btn-primary">Post</button></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>