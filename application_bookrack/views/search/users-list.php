<?php 
$url  = site_url('list/owners');
$url .= !empty($bookId)?'/'.urldecode($bookId):'';
$url .= !empty($bookTitle)?'/'.urldecode($bookTitle):'';

?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#post-content').scrollPagination({
					nop     : 10, // The number of posts per scroll to be loaded
					offset  : 0, // Initial offset, begins at 0 in this case
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
<div id="post-content" class="middle-content col-sm-6 col-md-6 col-lg-6">
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		Nearby users having <?=$bookTitle?> book:
	</div>
</div>

</div>