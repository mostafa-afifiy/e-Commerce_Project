<?php
session_start();
$title = "Login";
include 'init.php';
?>
<div class="container">
	<div class="row">
			<h1 class='text-center'></h1>
				<div class="col-sm-6 col-md-3">
					<div class="thumbnail item-box">
						<span class="price-tag"></span>
						<img class="img-responsive" src="./uploads/img.png" alt="" />
						<div class="caption">
							<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>
							<p>' . $item['Description'] . '</p>
							<div class="date">' . $item['Add_Date'] . '</div>
						</div>
					</div>
				</div>
	</div>
</div>

<?php include $tpl . 'footer.php'; ?>
