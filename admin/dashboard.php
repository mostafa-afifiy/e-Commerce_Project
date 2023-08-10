<?php
ob_start(); // Output Buffering Start
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
								$count = new Connection();
								$all_members = $count->fetch_data("count(user_id) as all_users", "users");
								?>
								<a href="members.php"><?= isset($all_members) ? $all_members['all_users'] : '0';?></a>
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
								$count_items = $count->fetch_data("count(item_id) as all_items", "items", "approve", "1");
							?>
							<a href="items.php"><?= isset($count_items) ? $count_items['all_items'] : '0';?></a>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-pending">
				<i class="fa fa-tag"></i>
					<div class="info">
						Total Categories
						<span>
							<?php 
								$category = $count->fetch_data("count(id) as all_categories", "categories");
							?>
							<a href="#"><?= isset($category) ? $category['all_categories'] : '0';?></a>
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
						<?php
								$count_comments = $count->fetch_data("count(com_id) as all_comments", "comments");
							?>
							<a href="comments.php"><?= isset($count_comments) ? $count_comments['all_comments'] : '0';?></a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>
<?php 
} else {
	header("location: index.php");
	exit();
}