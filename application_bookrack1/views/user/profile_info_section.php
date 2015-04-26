<ul class="list-group profile-info-section">
	<li class="list-group-item">
	<div class="row">
		<?php if($owner){?>
		<div class="col-lg-8"><h5><center><?=ucfirst($user->first_name).' '.ucfirst($user->last_name);?></center></h5></div>
		<div class="col-lg-4"><a href="<?=site_url('profile/edit')?>" title="Edit profile" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a></div>
		<?php }else{?>
		<div class="col-lg-12"><h5><center><?=ucfirst($user->first_name).' '.ucfirst($user->last_name);?></center></h5></div>
		<?php }?>
	</div>
	</li>
	<li class="list-group-item"><b>Date of Birth</b> <?=isset($user->dob)?$user->dob:"Not entered"?></li>
	<li class="list-group-item"><b>Location</b> <?=isset($user->location)?$user->location:"Not entered"?></li>
	<li class="list-group-item"><b>About</b> <p><?=isset($user->about)?$user->about:"Not entered"?></p></li>
</ul>