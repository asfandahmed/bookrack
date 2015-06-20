<!DOCTYPE html>
<html>
<head>
<title><?=$title?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<!-- Bootstrap -->

<link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" media="screen">
<link href="<?=base_url('assets/css/jquery-ui.min.css')?>" rel="stylesheet" media="screen">
<link href="<?=base_url('assets/css/capSlide.min.css')?>" rel="stylesheet" media="screen">
<link href="<?=base_url('assets/css/templatemo-style.css')?>" rel="stylesheet" media="screen">
<link href="<?=base_url('assets/css/style.css')?>" rel="stylesheet" media="screen">
<link href="<?=base_url('assets/css/styleGroups.css')?>" rel="stylesheet" media="screen">				
<link href="<?=base_url('assets/css/owl-carousel.css')?>" rel="stylesheet" media="screen">
<link href="<?=base_url('assets/css/stylesbook.css')?>" rel="stylesheet" media="screen">
<link href="<?=base_url('assets/css/jquery-ui.css')?>" rel="stylesheet" media="screen">

<link href="<?=base_url('assets/css/libnotify.css')?>" rel="stylesheet" media="screen">

<script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
</head>
<body>
<!--<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1628567297365505',
      xfbml      : true,
      version    : 'v2.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>-->
<div class="header">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=site_url()?>">BOOKRACK</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <?php if($this->common_functions->is_logged_in()):?>
      <ul class="nav navbar-nav">
        <li <?=($this->router->class=="site")?'class="active"':""?>><a href="<?=site_url('home')?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
        <li <?=($this->router->class=="notifications")?'class="active"':""?>><a href="<?=site_url('notifications')?>"><span class="glyphicon glyphicon-bell"></span> Notifications</a></li>
        <li <?=($this->router->class=="borrows")?'class="active"':""?>><a href="<?=site_url('borrows')?>"><span class="glyphicon glyphicon-book"></span> Requests</a></li>
        <li><a href="<?=site_url('messages/load_message_panel')?>" data-toggle="modal" data-target="#contentModal" id="load_messages"><span class="glyphicon glyphicon-envelope"></span> Messages</a></li>
      </ul>
      <form name="search_form" id="search-form" action="<?=site_url('search')?>" method="GET" class="navbar-form navbar-left" role="search">
        <div class="input-group">
          <input type="text" name="search" value="<?=isset($keywords)?$keywords:""?>" class="form-control col-lg-4" placeholder="search" autocomplete="off">
          <div class="input-group-btn">
            <button type="submit" onclick="search_submit()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
          </div>
        </div>
      </form>

      <?php endif;?>
      <ul class="nav navbar-nav navbar-right">
        <?php if(!$this->common_functions->is_logged_in()):?>
        <li><a href="<?=site_url('login')?>">Sign in</a></li>
        <li><a href="<?=site_url('register')?>">Sign up</a></li>
        
        <?php else:?>
        <li <?=($this->router->class=="users")?'class="active"':""?>><a href="<?=site_url('profile')?>"><?php echo $this->session->userdata('first_name');?></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="index.html">Account Settings</a></li>
            <li><a href="<?=site_url('logout')?>">Logout</a></li>
            <li class="divider"></li>
            <li><a href="#">Help</a></li>
            <li><a href="#">Support</a></li>
          </ul>
        </li>
        <?php endif;?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>  
<div class="container-fluid" id="content">
  <?php if($this->common_functions->is_logged_in()):?>
  <div class="row">
    <div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-sm-5 col-md-5 col-lg-5">
      <ul id="search-results"></ul>
    </div>
  </div>
  <?php endif;?>