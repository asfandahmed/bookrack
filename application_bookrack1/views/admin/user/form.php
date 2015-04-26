<div id="bookinfo-form" class="col-sm-5 col-md-5 col-lg-5">
<?php echo validation_errors()?>
<?php echo form_open($post_url,array('class'=>'form-horizontal', 'role'=>'form')) ?>

	<div class="form-group">
	<label for="inputFirstname" class="col-sm-4 col-md-4 col-lg-4 control-label">First name</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="first_name" value="<?=isset($first_name)?$first_name:set_value('first_name')?>" class="form-control" id="inputFirstname" placeholder="Firstname">
	</div>
	</div>

	<div class="form-group">
	<label for="inputLastname" class="col-sm-4 col-md-4 col-lg-4 control-label">Last name</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="last_name" value="<?=isset($last_name)?$last_name:set_value('last_name')?>" class="form-control" id="inputLastname" placeholder="Lastname">
	</div>
	</div>

	<div class="form-group">
	<label for="inputEmail" class="col-sm-4 col-md-4 col-lg-4 control-label">Email</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="email" name="email" value="<?=isset($email)?$email:set_value('email')?>" class="form-control" id="inputEmail" placeholder="Email">
	</div>
	</div>

	<div class="form-group">
	<label for="inputPassword" class="col-sm-4 col-md-4 col-lg-4 control-label">Password</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
	</div>
	</div>

	<div class="form-group">
	<label for="inputdob" class="col-sm-4 col-md-4 col-lg-4 control-label">Date of Birth</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="dob" value="<?=isset($dob)?$dob:set_value('dob')?>" class="form-control" id="inputdob" placeholder="dob">
	</div>
	</div>


	<div class="form-group">
	<label for="inputAbout" class="col-sm-4 col-md-4 col-lg-4 control-label">About</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<textarea name="about" class="form-control" id="inputAbout" placeholder="Write something about user."><?=isset($about)?$about:set_value('about')?></textarea>
	</div>
	</div>

	<div class="form-group">
	<label for="inputLocation" class="col-sm-4 col-md-4 col-lg-4 control-label">Location</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="location" value="<?=isset($location)?$location:set_value('location')?>" class="form-control" id="inputLocation" placeholder="Location">
	</div>
	</div>

	<div class="form-group">
	<label for="inputProfileURL" class="col-sm-4 col-md-4 col-lg-4 control-label">ProfileURL</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="profile_url" value="<?=isset($profile_url)?$profile_url:set_value('profile_url')?>" class="form-control" id="inputProfileURL" placeholder="ProfileURL">
	</div>
	</div>

	<div class="form-group">
	<label for="inputSkype" class="col-sm-4 col-md-4 col-lg-4 control-label">Skype</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="skype" value="<?=isset($skype)?$skype:set_value('skype')?>" class="form-control" id="inputSkype" placeholder="Skype">
	</div>
	</div>

	<div class="form-group">
	<label for="inputFacebook" class="col-sm-4 col-md-4 col-lg-4 control-label">Facebook</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="facebook" value="<?=isset($facebook)?$facebook:set_value('facebook')?>" class="form-control" id="inputFacebook" placeholder="Facebook">
	</div>
	</div>

	<div class="form-group">
	<label for="inputTwitter" class="col-sm-4 col-md-4 col-lg-4 control-label">Twitter</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="twitter" value="<?=isset($twitter)?$twitter:set_value('twitter')?>" class="form-control" id="inputTwitter" placeholder="Twitter">
	</div>
	</div>

	<div class="form-group">
	<label for="inputGoogle+" class="col-sm-4 col-md-4 col-lg-4 control-label">Google+</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="googlePlus" value="<?=isset($googlePlus)?$googlePlus:set_value('googlePlus')?>" class="form-control" id="inputGoogle+" placeholder="Google+">
	</div>
	</div>

	<div class="form-group">
	<label for="inputV-email" class="col-sm-4 col-md-4 col-lg-4 control-label">Verified Email</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<select name="verified_email" class="form-control" id="inputV-email">
		<option value="1" <?php if(isset($verified_email)){if($verified_email==1) echo 'selected="true"';}?> >Yes</option>
		<option value="0" <?php if(isset($verified_email)){if($verified_email==0) echo 'selected="true"';}?> >No</option>
	</select>
	</div>
	</div>

	<div class="form-group">
	<label for="inputV-account" class="col-sm-4 col-md-4 col-lg-4 control-label">Verified account</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<select name="verified_account" class="form-control" id="inputV-account">
		<option value="1" <?php if(isset($verified_account)){if($verified_account==1) echo 'selected="true"';}?> >Yes</option>
		<option value="0" <?php if(isset($verified_account)){if($verified_account==0) echo 'selected="true"';}?> >No</option>
	</select>
	</div>
	</div>

	<div class="form-group">
	<label for="inputActive" class="col-sm-4 col-md-4 col-lg-4 control-label">Active</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<select name="active" class="form-control" id="inputActive">
		<option value="1" <?php if(isset($active)){if($active==1) echo 'selected="true"';}?> >Yes</option>
		<option value="0" <?php if(isset($active)){if($active==0) echo 'selected="true"';}?> >No</option>
	</select>
	</div>
	</div>
	
	<div class="form-group">
	<label for="inputActive" class="col-sm-4 col-md-4 col-lg-4 control-label">Is admin?</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<select name="admin" class="form-control" id="inputActive">
		<option value="1" <?php if(isset($is_admin)){if($is_admin==1) echo 'selected="true"';}?> >Yes</option>
		<option value="0" <?php if(isset($is_admin)){if($is_admin==0) echo 'selected="true"';}?> >No</option>
	</select>
	</div>
	</div>

	<div class="form-group">
	<label for="inputLast-login" class="col-sm-4 col-md-4 col-lg-4 control-label">Last login</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="last_login" class="form-control" id="inputLast-login" placeholder="Last-login">
	</div>
	</div>
	<?=isset($id)?form_hidden('id',$id):""?>
	<div class="form-group">
	<input type="submit" name="register" class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-5 col-md-5 col-lg-5 btn btn-primary" value="<?=$buttonText?>">
	</div>

</form>

</div>
