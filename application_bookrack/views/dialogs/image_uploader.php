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
	    <br>
	    <div class="row">
	    	<div class="col-sm-12 col-md-12 col-lg-12">
			    <?php echo form_open_multipart('users/update_profile_picture', 'id="profile_image_form" class="form-inline" role="form" onsubmit="return false;"');?>
			    <div class="form-group">
			    	<input name="userfile" id="imageInput" type="file" />
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" id="submit-btn" value="Upload" onclick="uploadProfileImage();" />
				</div>
				<div class="form-group">
					<span id="pictureStatus"></span>
				</div>
				</form>
			</div>
		</div>
		<hr>
		<div class="row">
			<div id="output" class="col-sm-12 col-md-12 col-lg-12"></div>
		</div>
	  </div>
	</div>
</div>