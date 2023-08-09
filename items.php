<?php
session_start();

include 'init.php';



if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
	$check_item = new Connection();
	$item = $check_item->fetch_data("*", "items", "item_id", intval($_GET['itemid']));
	if(!empty($item)){

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(isset($_SESSION['user'])) {
				$comment_msg = comment_item($_POST['comment'], $item['item_id'], $_SESSION['user_id']);
			}
		}
?>
		<h1 class="text-center">Item Information</h1>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<img class="img-responsive img-thumbnail center-block" src="<?= $item['image']; ?>" alt="avatar" />
				</div>
				<div class="col-md-9 item-info">
					<h2><?= $item['name']; ?></h2>
					<p><?= $item['description']; ?></p>
					<ul class="list-unstyled">
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<span>Added Date</span> : <?= $item['item_date']; ?>
						</li>
						<li>
							<i class="fa fa-money fa-fw"></i>
							<span>Price</span> : <?= $item['price']; ?>
						</li>
						<li>
							<i class="fa fa-building fa-fw"></i>
							<span>Made In</span> : <?= $item['country']; ?>
						</li>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<span>Category</span> : <a href="categories.php?cat_id=<?= $item['item_id']; ?>"><?= $item['category']; ?></a>
						</li>
						<!-- <li>
							<i class="fa fa-user fa-fw"></i>
							<span>Added By</span> : <a href="#"></a>
						</li> -->
						<!-- <li class="tags-items">
							<i class="fa fa-user fa-fw"></i>
							<span>Tags</span> : 
										<a href='tags.php?name={$lowertag}'></a>
						</li> -->
					</ul>
				</div>
			</div>
			<hr class="custom-hr">
			<!-- Start Add Comment -->
			<div class="row">
				<div class="col-md-offset-3">
					<div class="add-comment">
						<h3>Add Your Comment</h3>
						<form action="<?= $_SERVER['PHP_SELF'];?>" method="POST">
							<textarea name="comment" ></textarea>
							<input class="btn btn-primary" type="submit" value="Add Comment">
						</form>
						<?php 
							if(isset($comment_msg)) {
								foreach($comment_msg as $msg) {
									echo $msg;
								}
							}
						?>
					</div>
				</div>
			</div>
			<!-- End Add Comment -->
			<?php
				if(!isset($_SESSION['user'])) {
					echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment';
				}
			?>
			<!-- <hr class="custom-hr">
				<div class="comment-box">
					<div class="row">
						<div class="col-sm-2 text-center">
							<img class="img-responsive img-thumbnail img-circle center-block" src="img.png" alt="" />
						</div>
						<div class="col-sm-10">
							<p class="lead"></p>
						</div>
					</div>
				</div>
				<hr class="custom-hr"> -->
		</div>
		<?php 
			} else { ?>
					<div class="container">  
						<div class="alert alert-danger">There\'s no Such ID Or This Item Is Waiting for Approval</div>
						<div class="alert alert-danger">You Will Return to the previous page after 3 Seconds</div>
					<?php 
						header("refresh:3;url=index.php");
					?>
					</div>  
					<?php }?>
	<?php }?>
		<?php include $tpl . 'footer.php'; ?>