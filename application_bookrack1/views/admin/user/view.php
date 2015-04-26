<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<ul class="list-group">
			<li class="list-group-item"><b>First name</b> <?=isset($first_name)?$first_name:""?></li>
			<li class="list-group-item"><b>Last name</b> <?=isset($last_name)?$last_name:""?></li>
			<li class="list-group-item"><b>Email</b> <?=isset($email)?$email:""?></li>
			<li class="list-group-item"><b>Date of Brith</b> <?=isset($dob)?$dob:""?></li>
			<li class="list-group-item"><b>About</b> <p><?=isset($about)?$about:""?></p></li>
			<li class="list-group-item"><b>Location</b> <?=isset($location)?$location:""?></li>
			<li class="list-group-item"><b>Profile Url</b> <?=isset($profile_url)?$profile_url:""?></li>
			<li class="list-group-item"><b>Skype</b> <?=isset($skype)?$skype:""?></li>
			<li class="list-group-item"><b>Facebook</b> <?=isset($facebook)?$facebook:""?></li>
			<li class="list-group-item"><b>Twitter</b> <?=isset($twitter)?$twitter:""?></li>
			<li class="list-group-item"><b>Google+</b> <?=isset($googlePlus)?$googlePlus:""?></li>
			<li class="list-group-item"><b>Verified Email</b> <?=isset($verified_email)?$verified_email:""?></li>
			<li class="list-group-item"><b>Verified Account</b> <?=isset($verified_account)?$verified_account:""?></li>
			<li class="list-group-item"><b>Active</b> <?=isset($active)?$active:""?></li>
			<li class="list-group-item"><b>Admin?</b> <?=isset($is_admin)?$is_admin:""?></li>
			<li class="list-group-item"><b>Last login</b> <?=isset($last_login)?$last_login:""?></li>
		</ul>
	</div>
	</div>