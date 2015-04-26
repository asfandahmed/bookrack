<div class="row">
	<div class="left-panel col-sm-offset-1 col-md-offset-1 col-sm-offset-1 col-sm-2 col-md-2 col-lg-2">
		<?php $this->load->view('search/filters.php')?>
	</div>
	<div class="middle-content col-sm-6 col-md-6 col-lg-6">
		<?php if(isset($results)):?>
			<?php if(empty($results)):?>
				<div class="custom-panel">Sorry, no matches.</div>
			<?php else:
					
					$base_url=base_url();
					$site_url=site_url();
					foreach ($results as $key):
						$label=$key["type"][0];
						switch ($label) {
							case 'User':
			?>	
				<div class="custom-panel">
					<div class="row">
						<div class="col-sm-2 col-md-2 col-lg-2"><img src="<?=$base_url.'assets/images/user-pic.jpg'?>" alt="" title=""></div>
						<div class="col-sm-8 col-md-8 col-lg-8"><a class="username" href="<?=$site_url?>/profile/<?=$key["id"]?>"><?=$key["name"]?></a></div>
						<div class="col-sm-2 col-md-2 col-lg-2"></div>
					</div>
				</div>
			<?php			
							break;
							case 'Book':
			?>
				<div class="custom-panel">
					<div class="row">
						<div class="col-sm-2 col-md-2 col-lg-2"><img src="<?=$base_url.'assets/images/user-pic.jpg'?>" alt="" title=""></div>
						<div class="col-sm-8 col-md-8 col-lg-8"><a class="username" href="<?=$site_url?>/book/<?=$key["id"]?>"><?=$key["name"]?></a></div>
						<div class="col-sm-2 col-md-2 col-lg-2"></div>
					</div>
				</div>
			<?php			
							break;
							case 'Author':
			?>
				<div class="custom-panel">
					<div class="row">
						<div class="col-sm-2 col-md-2 col-lg-2"><img src="<?=$base_url.'assets/images/user-pic.jpg'?>" alt="" title=""></div>
						<div class="col-sm-8 col-md-8 col-lg-8"><a class="username" href="<?=$site_url?>/author/<?=$key["id"]?>"><?=$key["name"]?></a></div>
						<div class="col-sm-2 col-md-2 col-lg-2"></div>
					</div>
				</div>
			<?php			
							break;
							case 'Publisher':
			?>
				<div class="custom-panel">
					<div class="row">
						<div class="col-sm-2 col-md-2 col-lg-2"><img src="<?=$base_url.'assets/images/user-pic.jpg'?>" alt="" title=""></div>
						<div class="col-sm-8 col-md-8 col-lg-8"><a class="username" href="<?=$site_url?>/publisher/<?=$key["id"]?>"><?=$key["name"]?></a></div>
						<div class="col-sm-2 col-md-2 col-lg-2"></div>
					</div>
				</div>
			<?php } ?>
			<?php endforeach;?>
			<?php endif;?>
		<?php else:?>
			<div class="custom-panel">Sorry, no matches.</div>
		<?php endif;?>
	</div>
	<div class="right-panel col-sm-3 col-md-3 col-lg-3">
		<?php
			$this->load->view('site/suggestions.php');
		?>
	</div>
</div>