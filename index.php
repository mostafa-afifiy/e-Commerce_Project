<?php
ob_start(); // Output Buffering Start
session_start();
include 'init.php';

$fetch_items = new Connection();

if(isset($_GET['cat'])) {
	$cat = $fetch_items->fetch_data("name", "categories", "name", $_GET['cat']);

	if(!empty($cat)) {
		$items = $fetch_items->fetch_data("*", "items", "approve = 1 AND category", $_GET['cat'] , all: "fetchAll");
	} else {
		$items = $fetch_items->fetch_data("*", "items", "approve", "1" , all: "fetchAll");
	}
} else {
	$items = $fetch_items->fetch_data("*", "items", "approve", "1" , all: "fetchAll");
}
?>
<div class="container">
	
	
	<?php 
	$i = 0;
	foreach($items as $item) {
		if($i == 0 ) echo '<div class="row">';
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
		<?php
			$i++;
		if($i == 4 ) {
			echo '</div>';
			echo '<hr class="custom-hr">';
			$i = 0;
		}
			}?>
	
	
</div>
<?php 
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>