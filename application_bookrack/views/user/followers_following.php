<?php $this->load->view('user/profile_upper_section.php')?>
<div class="row">
	<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-sm-2 col-md-2 col-lg-2">&nbsp;</div>
	<div class="middle-content col-sm-9 col-md-9 col-lg-9">
		

		<?php //if(isset($followings)):
				//foreach ($followings as $following): 
					//$data['following']=$following;
					$this->load->view('user/user_box.php');
		?>

		<?php //endforeach;?>
		<?php //endif;?>
	</div>
</div>