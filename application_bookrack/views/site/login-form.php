<?php 
echo validation_errors();
echo form_open($signin_post_url,array('id'=>'login-form','name'=>'login_form','class'=>'form-horizontal custom-panel', 'role'=>'form'));
?>

	<div class="form-group">
	<div class="col-sm-12 col-md-12 col-lg-12">
	<input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" id="inputEmail" placeholder="Email" required autofocus>
	</div>
	</div>

	<div class="form-group">
	<div class="col-sm-8 col-md-8 col-lg-8">
	<input type="password" name="password" class="form-control" value="" id="inputPassword" placeholder="Password" required>
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
	<input type="submit" name='login_form' class="btn btn-primary" value="Sign in">
	</div>
	</div>

	<div class="form-group">
		<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="checkbox">
		<label>
		<input type="checkbox">Remember me
		</label>
		</div>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6"><a href="<?=site_url('forgot')?>">Forgot passowrd?</a></div>
	</div>

</form>
<?php if(isset($msg)) echo $msg; ?>