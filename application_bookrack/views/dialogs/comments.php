<?php if(isset($comments)):
foreach ($comments as $comment):
?>
<div class="row"> 
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><?=$comment->commentText?></div>
</div>
<?php endforeach;else:?>
<div class="row"> 
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">Nothing to show</div>
</div>
<?php endif;?>