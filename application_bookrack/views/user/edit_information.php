
	<?php echo $this->session->flashdata('success_msg'); ?>
	<?php echo form_open($post_url,array('class'=>'form-horizontal', 'role'=>'form')) ?>
	<div class="form-group">
	<label for="inputFirstname" class="col-sm-4 col-md-4 col-lg-4 control-label">First name</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="user[first_name]" class="form-control" value="<?=$user->first_name?>"/>
	</div>
	</div>

	<div class="form-group">
	<label for="inputLastname" class="col-sm-4 col-md-4 col-lg-4 control-label">Last name</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="user[last_name]" class="form-control" value="<?=$user->last_name?>"/>
	</div>
	</div>


	<div class="form-group">
	<label for="inputdob" class="col-sm-4 col-md-4 col-lg-4 control-label">Date of Birth</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<input type="text" name="user[dob]" class="form-control" value="<?=isset($user->dob)?$user->dob:"-"?>"/>
	</div>
	</div>


	<div class="form-group">
	<label for="inputAbout" class="col-sm-4 col-md-4 col-lg-4 control-label">About</label>
	<div class="col-sm-7 col-md-7 col-lg-7">
	<textarea name="user[about]"><?=isset($user->about)?$user->about:"-"?></textarea>
	</div>
	</div>

	<div class="form-group">
		<button class="btn btn-primary">Save</button>
		<a href="<?=site_url('profile/edit_information')?>" class="btn btn-default edit">Cancel</a>
	</div>
	</form>