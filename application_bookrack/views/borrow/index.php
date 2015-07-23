<script type="text/javascript">
$(document).ready(function(){
	$('div#received').scrollPagination({
					nop     : 10, // The number of posts per scroll to be loaded
					offset  : 0, // Initial offset, begins at 0 in this case
					error   : 'No More Posts!', // When the user reaches the end this is the message that is
					                            // displayed. You can change this if you want.
					delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
					               // This is mainly for usability concerns. You can alter this as you see fit
					scroll  : true, // The main bit, if set to false posts will not load as the user scrolls. 
					               // but will still load if the user clicks.
					url		: "<?=site_url('borrow/load/received')?>"
				});
});
	  

var sent = true;	
$(document).on("click",".nav-tabs a[href=#sent]", function(e){
	if(sent){
		$('div#sent').scrollPagination({
					nop     : 10, // The number of posts per scroll to be loaded
					offset  : 0, // Initial offset, begins at 0 in this case
					error   : 'No More Posts!', // When the user reaches the end this is the message that is
					                            // displayed. You can change this if you want.
					delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
					               // This is mainly for usability concerns. You can alter this as you see fit
					scroll  : true, // The main bit, if set to false posts will not load as the user scrolls. 
					               // but will still load if the user clicks.
					url		: "<?=site_url('borrow/load/sent')?>"
			});
		e.preventDefault();
	  	$(this).tab('show');
	  	sent=false;	
	}
	
});

</script>
<div class="row">
	<div id="post-content" class="middle-content  col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-7 col-sm-7 col-md-7 col-lg-7">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
	    <li role="presentation" class="active"><a href="#received" aria-controls="received" role="tab" data-toggle="tab">Received</a></li>
	    <li role="presentation"><a href="#sent" aria-controls="sent" role="tab" data-toggle="tab">Sent</a></li>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="received"></div>
	    <div role="tabpanel" class="tab-pane" id="sent"></div>
	  </div>
	</div>
</div>