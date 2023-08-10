<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
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

				<img class="my-image img-thumbnail img-circle" src="./uploads/img.png" alt="" />
				<div class="btn-group my-info">
					<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</span>
					<ul class="dropdown-menu">
						<li><a href="profile.php">My Profile</a></li>
						<?php 
							if(isset($_SESSION['user'])) {
								echo '<li><a href="logout.php">Logout</a></li>';
							}
						?>
					</ul>
				</div>
				
				<a href="cart.php">
					<i class="fa-solid fa-cart-shopping"></i>
					<?php
						if(isset($_SESSION['user'])) {
								$conn = new Connection();
								$count = $conn->fetch_data("count(user_id) as quantity", "cart", "user_id", $_SESSION['user_id']);
						if(isset($count) && $count['quantity'] > 0 ) {
					?>
							<span 
								style="
									width:30px;
									height:30px;
									position:absolute;
									right:145px;
									top:5px;
									background-color:green;
									display: flex;
									justify-content: center;
									align-items: center;
									border-radius:50%;
									font-size: 18px;
									font-weight:bold;
									color:white;
									z-index:100;
									"><?= $count['quantity'];?></span>
					<?php }}?>
							<span class="pull-right">/ My Cart</span>
				</a>
				<?php 
					if(!isset($_SESSION['user'])) {
						echo '<a href="login.php"><span class="pull-right">/ Login /</span></a>';
						echo '<a href="register.php"><span class="pull-right"> Signup /</span></a>';
					}
				?>
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
	      <a class="navbar-brand" href="index.php">Home</a>
	    </div>
	    <div class="collapse navbar-collapse" id="app-nav">
	        <ul class="nav navbar-nav navbar-right">
				<?php
					$connect = new Connection();
					$all_cats = $connect->fetch_data("id, name", "categories", "visibility", "1", "ORDER BY ordaring", all: "fetchAll");
					if(!empty($all_cats)) {
						foreach($all_cats as $cat) {
							echo "<li>
									<a href='index.php?cat=$cat[name]'>$cat[name]</a>
								</li>";
						}
					}
				?>
				
	        </ul>
	    </div>
	  </div>
	</nav>