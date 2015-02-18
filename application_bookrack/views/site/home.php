<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-sm-2 col-md-2 col-lg-2">
<?php $this->load->view('user/user_info.php');?>
</div>
<div class="middle-content col-sm-5 col-md-5 col-lg-5">
<?php 
$this->load->view('post/post_form.php');
$this->load->view('post/post.php');
?>
</div>
<div class="right-panel col-sm-3 col-md-3 col-lg-3">
<?php $this->load->view('site/suggestions.php')?>
</div>