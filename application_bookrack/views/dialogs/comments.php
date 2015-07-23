<?php if(isset($comments)):
$imagePath = base_url().'assets/uploads/thumbs/';
$profile_url = site_url('profile') ?>
<?php foreach ($comments as $comment):
?>
<div class="row comment"> 
<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><a href="<?=$profile_url.'/'.$comment->userId?>"><img alt="<?=$comment->fullname?>" title="See <?=$comment->fullname?>'s profile" src="<?=$imagePath.$comment->image?>"></a></div>
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
<a href="<?=$profile_url.'/'.$comment->userId?>"><span class="username"><?=$comment->fullname?></span></a><br>
<?=$comment->commentText?>
</div>
</div>
<hr>
<?php endforeach;else:?>
<div class="row"> 
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">Nothing to show</div>
</div>
<?php endif;?>