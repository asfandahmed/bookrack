<script type="text/javascript">
	$(document).ready(function(){
		$('div#post-content').scrollPagination({
			nop     : 10, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : 'No More Posts!', // When the user reaches the end this is the message that is
			                            // displayed. You can change this if you want.
			delay   : 100, // When you scroll down the posts will load after a delayed amount of time.
			               // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true, // The main bit, if set to false posts will not load as the user scrolls. 
			               // but will still load if the user clicks.
			url 	: "<?=site_url('load/posts')?>",
		});
	});
</script>
<div class="left-panel col-xs-12 col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-sm-2 col-md-2 col-lg-2">
<?php $this->load->view('user/user_info.php');?>
</div>
<div class="middle-content col-xs-12 col-sm-5 col-md-5 col-lg-5">
<?php 
$this->load->view('post/post_form.php');
$this->load->view('post/post.php');
?>
<div id="post-content"></div>
</div>
<div class="right-panel col-xs-12 col-sm-3 col-md-3 col-lg-3">
<?php $this->load->view('site/suggestions.php')?>
</div>