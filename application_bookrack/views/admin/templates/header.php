<!DOCTYPE html>
<html>
  <head>
    <title><?=(isset($title))?$title:"BookRack Admin panel" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url().'assets/css/bootstrap.min.css' ?>" />
    <link href="<?=base_url('assets/css/jquery-ui.min.css')?>" rel="stylesheet" media="screen">
    <script src="<?=base_url('assets/js/jquery-latest.min.js')?>"></script>
  </head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
		<div class="panel panel-default">
			<div class="panel-heading">Entities</div>
			<div class="panel-body">
				<ul>
					<li><a href="<?=site_url('admin/authors')?>">Author</a></li>
					<li><a href="<?=site_url('admin/books')?>">Book</a></li>
					<li><a href="<?=site_url('admin/genres')?>">Genre</a></li>
					<li><a href="<?=site_url('admin/publishers')?>">Publisher</a></li>
					<li><a href="<?=site_url('admin/users')?>">User</a></li>			
				</ul>
			</div>
		</div>
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">		
		<ul class="nav nav-tabs">
		  <li role="presentation" class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
		  <li role="presentation"><a href="<?=site_url()?>"><span class="glyphicon glyphicon-book"></span> Application</a></li>
		  <li role="presentation"><a href="<?=site_url('logout')?>"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
		</ul>
		</div>
	</div>