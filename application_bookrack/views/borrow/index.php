<div class="row">
	<div  class="middle-content  col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-7 col-sm-7 col-md-7 col-lg-7">
		<?php if(!isset($requests) || count($requests)==0):?>
			
		<div class="row" style="background-color:rgb(245, 245, 245); font-size:0.9em;">	
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">You have no borrow requests.</div>
		</div>
		<?php else:
				$profile_url = site_url('profile');
				$borrow_url = site_url('borrow');
				foreach ($requests as $request):
		?>
		<div class="row" style="background-color:rgb(245, 245, 245); font-size:0.9em;">
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
				<a href="<?=$profile_url.'/'.$request['id']?>"><span style="font-weight:bold"><?=$request['username']?></span></a> sent you a borrow request at <?=gmdate("F j, Y g:i a",$request['r']->date_time);?>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<a href="<?=$borrow_url.'/approve/'.$request['rel_id']?>" class="btn-approve-borrow-request btn btn-sm btn-primary">approve</a>
				<a href="<?=$borrow_url.'/ignore/'.$request['rel_id']?>" class="btn-ignore-borrow-request btn btn-sm btn-primary">ignore</a>
			</div>
		</div>	
		
		<?php endforeach; endif;?>
	</div>
</div>