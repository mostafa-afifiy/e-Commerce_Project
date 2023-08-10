<?php
ob_start(); // Output Buffering Start
session_start();
include 'init.php';

if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
	$check_item = new Connection();
	$item = $check_item->fetch_data("*", "items", "item_id", intval($_GET['itemid']));
	if(!empty($item)){

		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			if(isset($_SESSION['user'])) {
				
				$push = new Item();

				if(isset($_POST['quantity'])) {
					$push->push_item($item['item_id'], $_SESSION['user_id'], $_POST['number']);
				}
				elseif(isset($_POST['comments'])) {
					$comment_msg = $push->push_comment($item['item_id'], $_SESSION['user_id'], $_POST['comment']);
				}
			}
			else {
				echo "<script>
						if (confirm('Please log in to access your cart. Do you want to proceed to the login page?')) {
							window.location.href = 'login.php'; // Redirect to the login page
						} else {
							// User chose to cancel, redirect back to the previous page
							history.back(); // Redirect to the previous page
						}
					</script>";
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
						<i class="fa fa-tags fa-fw"></i>
							<span>Status</span> : <?= $item['item_status']; ?>
						</li>
						<li>
							<i class="fa fa-building fa-fw"></i>
							<span>Made In</span> : <?= ucfirst($item['country']); ?>
						</li>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<span>Category</span> : <?= $item['category']; ?>
						</li>
						<li>
							<form action="<?= $_SERVER['PHP_SELF'];?>?itemid=<?= $item['item_id'];?>" method="POST">
							<span>Quantity</span> : <input type="number" name="number" min="1" max="100" value="<?= isset($_POST['quantity']) ? $_POST['number'] : 1;?>">
						</li>
						<li>
							<input class="btn btn-primary btn-block" name="quantity" type="submit" value="Add To Cart" />
						</form>
					</li>
					</ul>
				</div>
			</div>
			<hr class="custom-hr">
			<!-- Start Add Comment -->
			<div class="row">
				<div class="col-md-offset-3">
					<div class="add-comment">
						<h3>Add Your Comment</h3>
						<form action="?itemid=<?= $item['item_id'];?>" method="POST">
							<textarea name="comment" ></textarea>
							<input class="btn btn-primary" name="comments" type="submit" value="Add Comment">
						</form>
						<?php 
							if(isset($comment_msg)) {
									echo $comment_msg;
							}
						?>
					</div>
				</div>
			</div>
			<!-- End Add Comment -->
			<?php
				if(!isset($_SESSION['user'])) {
					echo '<a href="login.php">Login</a> or <a href="register.php">Register</a> To Add Comment';
				}
			?>
				<?php
					$connect = new Connection();
					$stmt = $connect->conn->prepare("SELECT u.full_name, u.image, c.comment
														FROM users u LEFT JOIN comments c
														ON u.user_id = c.com_from_user
														WHERE c.com_to_item = ?
														");
					$stmt->execute(array($_GET['itemid']));
					$comments = $stmt->fetchAll();
					
					if(isset($comments)) {
						echo '<hr class="custom-hr">';
						foreach($comments as $comment) {
							?>
							<div class="comment-box">
								<div class="row">
									<div class="col-sm-2 text-center">
										<img class="img-responsive img-thumbnail img-circle center-block" src="./uploads/img.png" alt="" />
									</div>
									<div class="col-sm-10">
										<p class="lead"><?= $comment['comment'] ?></p>
									</div>
								</div>
							</div>
							<?php
							}
							echo '<hr class="custom-hr">';
							}?>
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
<?php 
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>