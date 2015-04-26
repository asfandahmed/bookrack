<?php 
	$fullname=ucfirst($this->session->userdata('first_name')).' '.ucfirst($this->session->userdata('last_name'));
	if($this->session->userdata('profile_image'))
		$image_path=base_url().'assets/uploads/thumbs/'.$this->session->userdata('profile_image');
	else
		$image_path=base_url().'assets/images/user-pic.jpg';
?>

<div class="container">
	<div class="row">
		<div class="col-lg-3 col-sm-6">

			            		<div class="card hovercard">
					                <div class="cardheader">

					                </div>
							               	 <div class="avatar">
					                   <img src="<?=$image_path?>" alt="<?=$fullname?>" title="<?=$fullname?>">
					                </div>
					                <div class="info">
					                    <div class="title">
					                        <div class="col-sm-4 col-md-8 col-lg-8"><?=$fullname?></div>
					                    </div>
					                   
					                </div>    








								<div class="col-sm-4 col-md-6 col-lg-8 user-info-table">
									<table class="table table-responsive">
										<tr>
											<th>Books</th><th>Following</th><th>Followers</th>
										</tr>
										<tr>
											<td><a href="<?=site_url('shelf')?>"><?=$user_info[2][0]['books']?></a></td><td><a href="<?=site_url('following')?>"><?=$user_info[0][0]['following']?></a></td><td><a href="<?=site_url('followers')?>"><?=$user_info[1][0]['followers']?></a></td>
										</tr>
									</table>
								</div>
							</div>


<div class="container">
	<div class="row">
		<div class="col-lg-3 col-sm-6">

            <div class="card hovercard">
                <div class="cardheader">

                </div>
                <div class="avatar">
                    <img src="<?=$image_path?>" alt="<?=$fullname?>" title="<?=$fullname?>">
                </div>
                <div class="info">
                    <div class="title">
                    
                        <a href="http://scripteden.com/"><?=$fullname?></a>
                    </div>
                    <div class="desc">Passionate designer</div>
                    <div class="desc">Curious developer</div>
                    <div class="desc">Tech geek</div>
                </div>
                <div class="bottom">
                    <a class="btn btn-primary btn-twitter btn-sm" href="https://twitter.com/webmaniac">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a class="btn btn-danger btn-sm" rel="publisher"
                       href="https://plus.google.com/+ahmshahnuralam">
                        <i class="fa fa-google-plus"></i>
                    </a>
                    <a class="btn btn-primary btn-sm" rel="publisher"
                       href="https://plus.google.com/shahnuralam">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a class="btn btn-warning btn-sm" rel="publisher" href="https://plus.google.com/shahnuralam">
                        <i class="fa fa-behance"></i>
                    </a>

         
                </div>
            </div>

        </div>

	</div>
</div>



