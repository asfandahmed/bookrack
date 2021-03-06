<?php
$profile_url = site_url('profile');
$borrow_url = site_url('borrow');
?>
<?php if(!isset($sent) || count($sent)==0):?>

	<div class="row" style="background-color:rgb(245, 245, 245); font-size:0.9em;">	
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">You have no borrow requests.</div>
	</div>
	<?php else:
	foreach ($sent as $request):
	?>
	<div class="row" style="background-color:rgb(245, 245, 245); font-size:0.9em;">
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
	You sent you a borrow request to <a href="<?=$profile_url.'/'.$request['id']?>"><span style="font-weight:bold"><?=$request['username']?></span></a> at <?=gmdate("F j, Y g:i a",$request['r']->date_time);?>
	</div>
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<a href="<?=$borrow_url.'/cancel/'.$request['rel_id']?>" class="btn-cancel-borrow-request btn btn-sm btn-primary">cancel</a>
	</div>
	</div>

<?php endforeach; endif;?>