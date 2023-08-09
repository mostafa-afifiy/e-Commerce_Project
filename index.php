<?php
session_start();
include 'init.php';
$fetch_items = new Connection();
$items = $fetch_items->fetch_data("*", "items", "approve", "1" , all: "fetchAll");
// print_r($items);

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
					<p><?= $item['description'];?></p>
					<div class="date"><?= $item['item_date'];?></div>
				</div>
			</div>
		</div>
		<?php }?>
	</div>
</div>
<?= include $tpl . 'footer.php'; ?>