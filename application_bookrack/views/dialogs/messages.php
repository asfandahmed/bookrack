<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <div class="row">
	    	<div class="col-sm-12 col-md-12 col-lg-12">
	    		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    	</div>
	    </div>
	    <div class="row">
	    	<div class="col-sm-6 col-md-6 col-lg-6"><a id="load_message_compose" class="btn btn-default"  url="<?=site_url('messages/load_compose_panel')?>"><span class="glyphicon glyphicon-envelope"></span> Compose</a></div>
	    	<div class="col-sm-6 col-md-6 col-lg-6"><h4 class="modal-title" id="BookrackInbox">Inbox</h4></div>	    	
	    </div>
	  </div>
	  <div class="modal-body">
	  <div class="col-sm-6 col-md-6 col-lg-6">
	    <ul>
	    <?php if(isset($messages)): 
	    		foreach ($messages as $message):
	    ?>
	    	<li>
    		<div class="row">
    			<a href="#" class="show-messages" data-url="<?=(site_url('messages/show').'/'.urlencode($message['email']))?>"><span><?=$message['username']?></span></a>
    		</div>
	    	</li>	
	    <?php 	endforeach;?>
	    </ul>
	    <?php else: ?>
			No messages
	    <?php endif;?>
	  </div>
	  </div>
	  <div class="modal-footer">
	    
	  </div>
	</div>
</div>