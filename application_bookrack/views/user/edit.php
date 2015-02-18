<div class="row">
	<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-sm-2 col-md-2 col-lg-2">
	    <ul class="list-group">
	      <li class="list-group-item"><a class="edit-link" href="<?=site_url('profile/edit_information')?>"><class="icon-chevron-right"> Personal Information</a></li>
	      <li class="list-group-item"><a class="edit-link" href="<?=site_url('profile/edit_contact')?>"><i class="icon-chevron-right"></i> Contact</a></li>
	    </ul>
	</div>
	<div class="middle-content col-sm-5 col-md-5 col-lg-5" id="content-loader">
		<?php $this->load->view('user/edit_information.php')?>	
	</div>
</div>