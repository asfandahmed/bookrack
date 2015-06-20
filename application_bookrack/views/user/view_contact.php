<a href="<?=site_url('profile/edit_contact')?>" id="edit-contact">Edit</a>

<div class="form-group">
<label for="inputEmail" class="col-sm-4 col-md-4 col-lg-4 control-label">Email</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<label class="control-label"><?=$user->email?></label>
</div>
</div>

<div class="form-group">
<label for="inputSkype" class="col-sm-4 col-md-4 col-lg-4 control-label">Skype</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<label class="control-label"><?=isset($user->skype)?$user->skype:"-"?></label>
</div>
</div>

<div class="form-group">
<label for="inputFacebook" class="col-sm-4 col-md-4 col-lg-4 control-label">Facebook</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<label class="control-label"><?=isset($user->facebook)?$user->facebook:"-"?></label>
</div>
</div>

<div class="form-group">
<label for="inputTwitter" class="col-sm-4 col-md-4 col-lg-4 control-label">Twitter</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<label class="control-label"><?=isset($user->twitter)?$user->twitter:"-"?></label>
</div>
</div>

<div class="form-group">
<label for="inputGoogle+" class="col-sm-4 col-md-4 col-lg-4 control-label">Google+</label>
<div class="col-sm-7 col-md-7 col-lg-7">
<label class="control-label"><?=isset($user->googlePlus)?$user->googlePlus:"-"?></label>
</div>
</div>
