<a href="<?=site_url('profile/edit_information')?>" id="edit-information">Edit</a>

	<div class="form-group">
	<label for="inputFirstname" class="col-sm-4 col-md-4 col-lg-4 control-label">First name</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<label class="control-label"><?=$user->first_name?></label>
	
	</div>
	</div>

	<div class="form-group">
	<label for="inputLastname" class="col-sm-4 col-md-4 col-lg-4 control-label">Last name</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<label class="control-label"><?=$user->last_name?></label>
	
	</div>
	</div>


	<div class="form-group">
	<label for="inputdob" class="col-sm-4 col-md-4 col-lg-4 control-label">Date of Birth</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	
	<label class="control-label"><?=isset($user->dob)?$user->dob:"-"?></label>
	</div>
	</div>


	<div class="form-group">
	<label for="inputAbout" class="col-sm-4 col-md-4 col-lg-4 control-label">About</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<label class="control-label"><?=isset($user->about)?$user->about:"-"?></label>
	
	</div>
	</div>