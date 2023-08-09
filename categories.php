<?php 
session_start();
$title = "Categories";
include 'init.php';
?>
<div class="container">
	<h1 class="text-center">Show Category Items</h1>
	<div class="row">
				<div class="col-sm-6 col-md-3"> 
					<div class="thumbnail item-box"> 
						<span class="price-tag">100$</span> 
						<img class="img-responsive" src="./uploads/img.png" alt="" /> 
						<div class="caption"> 
							<h3><a href="items.php?itemid='. $item['Item_ID'] .'"></a>iphone</h3> 
							<p>mobile phone</p> 
							<div class="date">20-11-2024</div> 
						</div> 
					</div> 
				</div> 
	</div>
</div>

<?php include $tpl . 'footer.php';  ?>