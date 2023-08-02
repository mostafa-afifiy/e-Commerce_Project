<?php 
session_start();
include 'init.php';
?>
<h1 class="text-center">My Profile</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>
						<span>Login Name</span> : 
					</li>
					<li>
						<i class="fa fa-envelope-o fa-fw"></i>
						<span>Email</span> : 
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Full Name</span> : 
					</li>
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Registered Date</span> : 
					</li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						<span>Fav Category</span> :
					</li>
				</ul>
				<a href="#" class="btn btn-default">Edit Information</a>
			</div>
		</div>
	</div>
</div>
<div id="my-ads" class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Items</div>
			<div class="panel-body">
					<div class="row">
						<div class="col-sm-6 col-md-3">
							<div class="thumbnail item-box">
									<span class="approve-status">Waiting Approval</span> 
								<span class="price-tag"></span>
								<img class="img-responsive" src="./uploads/img.png" alt="" />
								<div class="caption">
									<h3><a href="items.php?itemid='. $item['Item_ID'] .'"></a></h3>
									<p></p>
									<div class="date"></div>
								</div>
							</div>
						</div>
					</div>
					Sorry There\' No Ads To Show, Create <a href="newad.php">New Ad</a>
			</div>
		</div>
	</div>
</div>
<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Latest Comments</div>
			<div class="panel-body">
						<p>' . $comment['comment'] . '</p>
			</div>
		</div>
	</div>
</div>
<?php include $tpl . 'footer.php'; ?>