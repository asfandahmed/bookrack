<?php 
$url = site_url('search/results');
$url .= !empty($keywords)?'/'.urlencode($keywords):'';
$url .= !empty($filters)?'/'.urlencode($filters):'/anyting';
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#post-content').scrollPagination({
					nop     : 10, // The number of posts per scroll to be loaded
					offset  : 10, // Initial offset, begins at 0 in this case
					error   : 'No More Posts!', // When the user reaches the end this is the message that is
					                            // displayed. You can change this if you want.
					delay   : 100, // When you scroll down the posts will load after a delayed amount of time.
					               // This is mainly for usability concerns. You can alter this as you see fit
					scroll  : true, // The main bit, if set to false posts will not load as the user scrolls. 
					               // but will still load if the user clicks.
					url		: "<?=$url?>"
			});
	});
</script>
<div class="row">
	<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-sm-2 col-md-2 col-lg-2">
		<?php $this->load->view('search/filters.php');?>
	</div>
	<div id="post-content" class="middle-content col-sm-6 col-md-6 col-lg-6">
		<?php $this->load->view('search/search-results.php',$results);?>
	</div>
	<div class="right-panel col-sm-3 col-md-3 col-lg-3">
		<?php $this->load->view('site/suggestions.php');?>
	</div>
</div>