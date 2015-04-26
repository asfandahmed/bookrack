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
	<div class="[ container text-center ]">
    <div class="[ row ]">
        <div class="[ col-xs-12 ]" style="padding-bottom: 30px;">
            <p>Follower <a target="_blank" href="http://www.bootsnipp.com/maridlcrmn"></a> <a target="_parent" href="http://bootsnipp.com/maridlcrmn/snippets/QbEpr"></a></p>
        </div>
    </div>
</div>
<div class="[ container text-center ]">
	<div class="[ row ]">
		<div class="[ col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 ]" role="tabpanel">
            <div class="[ col-xs-4 col-sm-12 ]">
                <!-- Nav tabs -->
                <ul class="[ nav nav-justified ]" id="nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#dustin" aria-controls="dustin" role="tab" data-toggle="tab">
                            <img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/dustinlamont/128.jpg" />
                            <span class="quote"><i class="fa fa-quote-left"></i></span>
                        </a>
                    </li>
                    <li role="presentation" class="">
                        <a href="#daksh" aria-controls="daksh" role="tab" data-toggle="tab">
                            <img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/dakshbhagya/128.jpg" />
                            <span class="quote"><i class="fa fa-quote-left"></i></span>
                        </a>
                    </li>
                    <li role="presentation" class="">
                        <a href="#anna" aria-controls="anna" role="tab" data-toggle="tab">
                            <img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/annapickard/128.jpg" />
                            <span class="quote"><i class="fa fa-quote-left"></i></span>
                        </a>
                    </li>
                    <li role="presentation" class="">
                        <a href="#wafer" aria-controls="wafer" role="tab" data-toggle="tab">
                            <img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/waferbaby/128.jpg" />
                            <span class="quote"><i class="fa fa-quote-left"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="[ col-xs-8 col-sm-12 ]">
                <!-- Tab panes -->
                <div class="tab-content" id="tabs-collapse">            
                    <div role="tabpanel" class="tab-pane fade in active" id="dustin">
                        <div class="tab-inner">                    
                            <p class="lead">is new Bookrack member and has started to follow you </p>
                            <hr>
                            <p><strong class="text-uppercase"> MAlik Riaz</strong></p>
                            <p><em class="text-capitalize"> Reader</em> at <a href="#">BookRack</a></p>                 
                        </div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="daksh">
                        <div class="tab-inner">
                            <p class="lead">Book Rack is the Best site for sharing review On Books that i have read
                            <hr>
                            <p><strong class="text-uppercase">Ali ANwar</p>
                            <p><em class="text-capitalize"> UX designer</em> at <a href="#">Google</a></p>
                        </div>
                    </div>
                    
                    

                   
                </div>
            </div>        
        </div>
	</div>
</div>
</div>