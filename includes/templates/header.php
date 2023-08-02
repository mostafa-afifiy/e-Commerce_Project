<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<!-- <link rel="icon" href="./favicon.ico" />
		<link rel="apple-touch-icon" href="%PUBLIC_URL%/logo192.png" /> -->
		<title><?= isset($title) ? $title : 'Shopping';?></title>
		<link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css" />
		<link rel="stylesheet" href="<?php echo $css ?>front.css" />
	</head>
	<body>
	<div class="upper-bar">
		<div class="container">

				<img class="my-image img-thumbnail img-circle" src="img.png" alt="" />
				<div class="btn-group my-info">
					<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</span>
					<ul class="dropdown-menu">
						<li><a href="#">My Profile</a></li>
						<li><a href="#">New Item</a></li>
						<li><a href="profile.php#my-ads">My Items</a></li>
						<li><a href="#">Logout</a></li>
					</ul>
				</div>

			<a href="login.php">
				<span class="pull-right">Login/Signup</span>
			</a>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
	  <div class="container">
	    <div class="navbar-header">
	      <button 
	      		type="button" 
	      		class="navbar-toggle collapsed" 
	      		data-toggle="collapse" 
	      		data-target="#app-nav" 
	      		aria-expanded="false">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="index.php">Homepage</a>
	    </div>
	    <div class="collapse navbar-collapse" id="app-nav">
	      <ul class="nav navbar-nav navbar-right">
				<li>
					<a href="categories.php?pageid=' . $cat['ID'] . '">
					</a>
				</li>
	      </ul>
	    </div>
	  </div>
	</nav>