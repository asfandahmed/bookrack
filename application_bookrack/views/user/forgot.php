<div class="row">
	<div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-sm-5 col-md-5 col-lg-5  custom-panel" id="forgot-form-page">
		<h4>We 'll help you to recover your password.</h4>
		<?php 
			echo validation_errors();
			echo form_open(site_url('forgot'),array('id'=>'forgot-form','name'=>'forgot_form','class'=>'form-horizontal', 'role'=>'form'));
		?>
		<div class="form-group">
		<div class="col-sm-12 col-md-12 col-lg-12">
		<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter your email" required>
		</div>
		</div>
		<div class="form-group">
		<div class="col-sm-4 col-md-4 col-lg-4">
		<input type="submit" name='login_form' class="btn btn-primary" value="Go!">
		</div>
		</div>
		
	</div>
</div>