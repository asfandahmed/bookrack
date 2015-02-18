<?php echo validation_errors()?>
<?php echo form_open($register_post_url,array('id'=>'signup-form','name'=>'register_form','class'=>'form-horizontal custom-panel', 'role'=>'form')) ?>
<div class="col-sm-12 col-md-12 col-lg-12"><h4>You can <b>Signup</b> here!</h4><hr></div>
<div class="form-group">
<div class="col-sm-6 col-md-6 col-lg-6">
<input type="text" name="first_name" class="form-control" value="<?php echo set_value('first_name'); ?>" id="first-name" placeholder="First name" required>
</div>
<div class="col-sm-6 col-md-6 col-lg-6">
<input type="text" name="last_name" class="form-control" value="<?php echo set_value('last_name'); ?>" id="last-name" placeholder="Last name" required>
</div>
</div>

<div class="form-group">
<div class="col-sm-12 col-md-12 col-lg-12">
<select name="gender" class="form-control">
<option value="" disabled selected>Gender</option>
<option value="male">Male</option>
<option value="female">Female</option>
</select>
</div>
</div>

<div class="form-group">
<div class="col-sm-12 col-md-12 col-lg-12">
<input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" id="inputEmail3" placeholder="Email" required>
</div>
</div>

<div class="form-group">
<div class="col-sm-12 col-md-12 col-lg-12">
<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
</div>
</div>

<div class="form-group">
<input type="submit" name="register" class="col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-sm-5 col-md-5 col-lg-5 btn btn-primary" value="Sign up">
</div>

</form>