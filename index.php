<?php
session_start();
include 'init.php';
?>
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail item-box">
				<span class="price-tag"></span>
				<img class="img-responsive" src="./uploads/img.png" alt="" />
				<div class="caption">
					<h3><a href="items.php?itemid="></a></h3>
					<p></p>
					<div class="date"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?= include $tpl . 'footer.php'; ?>