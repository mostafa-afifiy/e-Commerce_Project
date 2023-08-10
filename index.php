<?php
ob_start(); // Output Buffering Start
session_start();
include 'init.php';

$fetch_items = new Connection();

if(isset($_GET['cat'])) {
	$items = $fetch_items->fetch_data("*", "items", "approve = 1 AND category", $_GET['cat'] , all: "fetchAll");
} else {
	$items = $fetch_items->fetch_data("*", "items", "approve", "1" , all: "fetchAll");
}
?>
<div class="container">
	<div class="row">
	<?php 
	foreach($items as $item) {
	?>
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail item-box">
				<span class="price-tag"><?= $item['price'];?></span>
				<img class="img-responsive" src="<?= $item['image'];?>" alt="avatar" />
				<div class="caption">
					<h3><a href="items.php?itemid=<?= $item['item_id'];?>"><?= $item['name'];?></a></h3>
					<p><?= substr($item['description'], 0, 75);?></p>
					<div class="date"><?= $item['item_date'];?></div>
				</div>
			</div>
		</div>
		<?php }?>
	</div>
</div>
<?php 
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>