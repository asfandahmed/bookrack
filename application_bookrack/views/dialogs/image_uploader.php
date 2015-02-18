<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <div class="row">
	    	<div class="col-sm-12 col-md-12 col-lg-12">
	    		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    	</div>
	    </div>
	    <div class="row">
	    	<center><h4 class="modal-title" id="BookrackInbox">Upload Image</h4></center>
	    </div>
	  </div>
	  <div class="modal-body">
	    <?php echo form_open_multipart('users/update_profile_picture');?>
	    <input name="userfile" id="imageInput" type="file" />
		<input type="submit" class="btn btn-primary" id="submit-btn" value="Upload" />
		<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
		</form>
		<div id="progressbox" style="display:none;"><div id="progressbar"></div ><div id="statustxt">0%</div></div>
		<div class="progress">
		  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
		    <span class="sr-only">45% Complete</span>
		  </div>
		</div>
		<div id="output"></div>
	  </div>
	</div>
</div>