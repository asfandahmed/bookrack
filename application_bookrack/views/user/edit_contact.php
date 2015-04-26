<?php echo $this->session->flashdata('success_msg'); ?>
 
<?php echo form_open($post_url,array('class'=>'form-horizontal', 'role'=>'form')) ?>
<div class="form-group">
<label for="inputEmail" class="col-sm-4 col-md-4 col-lg-4 control-label">Email</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<input type="text" name="user[email]" class="form-control" value="<?=$user->email?>"/>
</div>
</div>

<div class="form-group">
<label for="inputSkype" class="col-sm-4 col-md-4 col-lg-4 control-label">Skype</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<input type="text" name="user[skype]" class="form-control" value="<?=isset($user->skype)?$user->skype:"-"?>"/>
</div>
</div>

<div class="form-group">
<label for="inputFacebook" class="col-sm-4 col-md-4 col-lg-4 control-label">Facebook</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<input type="text" name="user[facebook]" class="form-control" value="<?=isset($user->facebook)?$user->facebook:"-"?>"/>
</div>
</div>

<div class="form-group">
<label for="inputTwitter" class="col-sm-4 col-md-4 col-lg-4 control-label">Twitter</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<input type="text" name="user[twitter]" class="form-control" value="<?=isset($user->twitter)?$user->twitter:"-"?>"/>
</div>
</div>

<div class="form-group">
<label for="inputGoogle+" class="col-sm-4 col-md-4 col-lg-4 control-label">Google+</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<input type="text" name="user[googlePlus]" class="form-control" value="<?=isset($user->googlePlus)?$user->googlePlus:"-"?>"/>
</div>
</div>

<div class="form-group">
	<button class="btn btn-primary">Save</button>
	<a href="<?=site_url('profile/view_information')?>" class="btn btn-default">Cancel</a>
</div>
</form>