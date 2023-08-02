<?php

session_start();
$title = "Dashboard";
include 'init.php';

if(isset($_SESSION['admin'])) {
?>
<div class="home-stats">
	<div class="container text-center">
		<h1><?= $title;?></h1>
		<div class="row">
			<div class="col-md-3">
				<div class="stat st-members">
					<i class="fa fa-users"></i>
					<div class="info">
						Total Members
						<span>
							<?php
								$count = new Database();
								$all_members = $count->get_all("count(user_id) as all_users", "users");
								?>
								<a href="members.php"><?= isset($all_members) ? $all_members['all_users'] : "0";?></a>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-pending">
					<i class="fa fa-user-plus"></i>
					<div class="info">
						Pending Members
						<span>
							<?php 
								$pending = $count->get_all("count(user_id) as all_pending", "users", "reg_status = 0");
							?>
							<a href="#"><?= isset($pending) ? $pending['all_pending'] : "0";?></a>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-items">
					<i class="fa fa-tag"></i>
					<div class="info">
						Total Items
						<span>
							<?php
								$all_items = new Item();
								$count_items = $all_items->get_item("count(item_id) as all_items", "approve", "1");
							?>
							<a href="items.php"><?= isset($count_items) ? $count_items['all_items'] : '';?></a>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-comments">
					<i class="fa fa-comments"></i>
					<div class="info">
						Total Comments
						<span>
							<a href="comments.php">0</a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="latest">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-users"></i> 
						Latest Registerd Users 
						<span class="toggle-info pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
					</div>
					<div class="panel-body">
						<ul class="list-unstyled latest-users">
							<li>  
								<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">  
									<span class="btn btn-success pull-right">  
										<i class="fa fa-edit"></i> Edit  
											<a 
												href=""
												class='btn btn-info pull-right activate'>
												<i class='fa fa-check'></i> Activate</a>  
									</span>  
								</a>  
							</li>  
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-tag"></i> Latest Items 
						<span class="toggle-info pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
					</div>
					<div class="panel-body">
						<ul class="list-unstyled latest-users">
							<li>  
								<a href="">  
								<span class="btn btn-success pull-right">  
									<i class="fa fa-edit"></i> Edit  
										<a href='' class='btn btn-info pull-right activate'>
											<i class='fa fa-check'></i> Approve</a>  
								</span>  
							</a>  
							</li>  
						</ul>
					</div>
				</div>
			</div>
		</div>
    
		<!-- Start Latest Comments -->
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-comments-o"></i> 
						Latest  Comments 
						<span class="toggle-info pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
					</div>
					<div class="panel-body">
						<div class="comment-box">  
						<ul class="list-unstyled latest-users">
							<li>  
								<a href="">  
								<span class="btn btn-success pull-right">  
									<i class="fa fa-edit"></i> Edit  
										<a href='' class='btn btn-info pull-right activate'>
											<i class='fa fa-check'></i> Approve</a>  
								</span>  
							</a>  
							</li>  
						</ul>
						</div>  
					</div>
				</div>
			</div>
		</div>
		<!-- End Latest Comments -->
	</div>
</div>

<?php include $tpl . 'footer.php'; ?>

<?php 
} else {
	header("location: index.php");
	exit();
}