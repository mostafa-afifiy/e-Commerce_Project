<?php
session_start();

include 'init.php';
?>
<h1 class="text-center"></h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img class="img-responsive img-thumbnail center-block" src="img.png" alt="" />
		</div>
		<div class="col-md-9 item-info">
			<h2></h2>
			<p></p>
			<ul class="list-unstyled">
				<li>
					<i class="fa fa-calendar fa-fw"></i>
					<span>Added Date</span> : 
				</li>
				<li>
					<i class="fa fa-money fa-fw"></i>
					<span>Price</span> : 
				</li>
				<li>
					<i class="fa fa-building fa-fw"></i>
					<span>Made In</span> :
				</li>
				<li>
					<i class="fa fa-tags fa-fw"></i>
					<span>Category</span> : <a href="categories.php?pageid="></a>
				</li>
				<li>
					<i class="fa fa-user fa-fw"></i>
					<span>Added By</span> : <a href="#"></a>
				</li>
				<li class="tags-items">
					<i class="fa fa-user fa-fw"></i>
					<span>Tags</span> : 
								<a href='tags.php?name={$lowertag}'></a>
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
				<form action="" method="POST">
					<textarea name="comment" required></textarea>
					<input class="btn btn-primary" type="submit" value="Add Comment">
				</form>

								<div class="alert alert-success">Comment Added</div>

							<div class="alert alert-danger">You Must Add Comment</div>
			</div>
		</div>
	</div>
	<!-- End Add Comment -->
		<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment
	<hr class="custom-hr">
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
		<hr class="custom-hr">
</div>
		<div class="container">
			<div class="alert alert-danger">There\'s no Such ID Or This Item Is Waiting Approval</div>
		</div>

		<?php include $tpl . 'footer.php'; ?>