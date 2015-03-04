<div class="row">
	<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-3 col-sm-2 col-md-2 col-lg-2">
		<?php $this->load->view('user/profile_info_section.php')?>
	</div>
	<div id="post_content" class="middle-content col-xs-6 col-sm-5 col-md-5 col-lg-5">
		<?php 
			if($owner)
				$this->load->view('post/post_form.php');
			$this->load->view('post/post.php');
		?>
	</div>
	<div class="right-panel col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<?php $this->load->view('site/suggestions.php')?>
	</div>
</div>
