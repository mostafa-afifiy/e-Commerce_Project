<?php
session_start();
$title = "Items";
include 'init.php';

if(isset($_SESSION['admin'])) {
	$item = new Item();
	// if($_SERVER['REQUEST_METHOD'] == 'POST') {

		if(isset($_GET['do'])) {

			if($_GET['do'] == 'Insert') {
				$insert_errors = $item->insert_item( 
					$_POST['name'], 
					$_POST['description'], 
					$_POST['price'], 
					$_POST['country'], 
					$_POST['status'], 
					$_POST['category']
				);
			}
			elseif($_GET['do'] == 'Update') {
				if(isset($_GET['edit_id']) && is_int($_GET['edit_id'])) {
					var_dump($_GET['edit_id']);
					// $update_errors = $item->update_item(
					// 	$_POST['name'], 
					// 	$_POST['description'], 
					// 	$_POST['price'], 
					// 	$_POST['country'], 
					// 	$_POST['status'], 
					// 	$_POST['category'],
					// 	$_GET['edit_id']
					// );
				}
			}
			elseif($_GET['do'] == 'Delete') {
				if(isset($_GET['de_id']) && is_int($_GET['de_id']) ) {
					$delete_error = $item->delete_item($_GET['de_id']);
				}
			}
			elseif($_GET['do'] == 'approve') {
				if(isset($_GET['ap_id']) && is_int($_GET['ap_id']) ) {
					$approve_error = $item->approve_item($_GET['ap_id']);
				}
			}

		}
	// }
	
	
?>

<h1 class="text-center">Manage Items</h1>
<div class="container">
	<div class="table-responsive">
		<table class="main-table text-center table table-bordered">
			<tr>
				<td>#ID</td>
				<td>Item Name</td>
				<td>Description</td>
				<td>Price</td>
				<td>Category</td>
				<td>Status</td>
				<td>Adding Date</td>
				<td>Control</td>
			</tr>
				<?php 
					$fetch_all = new Item();
					$all_items = $fetch_all->get_item("*", "approve", "0", NULL, "fetchAll");

					$item_id = (int)$items['item_id'];
					foreach($all_items as $items) {
						echo "<tr>";
						echo "<td>$item_id</td>";
						echo "<td>$items[name]</td>";
						echo "<td>$items[description]</td>";
						echo "<td>$items[price]</td>";
						echo "<td>$items[category]</td>";
						echo "<td>$items[item_status]</td>";
						echo "<td>$items[item_date]</td>";
					
						echo "<td>
							<a href='?do=Update&up_id=$item_id' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
							<a href='?do=Delete&de_id=$items[item_id]' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>
							<a href='?do=Approve&ap_id=$items[item_id]' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>
						</td>";
						echo "</tr>";
					}
				?>
		</table>
		<div class='container'>
			<?php 
				if(isset($delete_error)) {
					echo "<div class='alert alert-danger'>$delete_error</div>";
				}

				if(isset($approve_error)) {
					echo "<div class='alert alert-danger'>$approve_error</div>";
				}
			?>
		</div>
	</div>
	<a href="?Insert" class="btn btn-sm btn-primary">
		<i class="fa fa-plus"></i> New Item
	</a>
</div>


<!-- <div class="container">
	<div class="nice-message">There\'s No Items To Show</div>
	<a href="?iiiii" class="btn btn-sm btn-primary">
		<i class="fa fa-plus"></i> New Item
	</a>
</div> -->


<?php 
	if(isset($_GET['Insert'])) {
	?>
	<h1 class="text-center">Add New Item</h1>
	<div class="container">
		<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-date">
			<!-- Start Name Field -->
			<div class="form-group form-group-lg">
				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10 col-md-6">
					<input 
						type="text" 
						name="name" 
						class="form-control" 
						placeholder="Name of The Item"
						value = "<?= @$_POST['name'];?>" />
				</div>
			</div>
			<!-- End Name Field -->
			<!-- Start Description Field -->
			<div class="form-group form-group-lg">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10 col-md-6">
					<input 
						type="text" 
						name="description" 
						class="form-control" 
						placeholder="Description of The Item" 
						value = "<?= @$_POST['description'];?>" />
				</div>
			</div>
			<!-- End Description Field -->
			<!-- Start Price Field -->
			<div class="form-group form-group-lg">
				<label class="col-sm-2 control-label">Price</label>
				<div class="col-sm-10 col-md-6">
					<input 
						type="text" 
						name="price" 
						class="form-control" 
						placeholder="Price of The Item" 
						value = "<?= @$_POST['price'];?>" />
				</div>
			</div>
			<!-- End Price Field -->
			<!-- Start Country Field -->
			<div class="form-group form-group-lg">
				<label class="col-sm-2 control-label">Country</label>
				<div class="col-sm-10 col-md-6">
					<input 
						type="text" 
						name="country" 
						class="form-control" 
						placeholder="Country of Made" 
						value = "<?= @$_POST['country'];?>" />
					</div>
				</div>
				<!-- required="required"  -->
			<!-- End Country Field -->
			<!-- Start Status Field -->
			<div class="form-group form-group-lg">
				<label class="col-sm-2 control-label">Status</label>
				<div class="col-sm-10 col-md-6">
					<select name="status">
						<option value="">...</option>
						<option value="new"<?= @$_POST['status'] === 'new' ? 'selected' : ''; ?>>New</option>
						<option value="like new"<?= @$_POST['status'] === 'like new' ? 'selected' : ''; ?>>Like New</option>
						<option value="used"<?= @$_POST['status'] === 'used' ? 'selected' : ''; ?>>Used</option>
						<option value="very old"<?= @$_POST['status'] === 'very old' ? 'selected' : ''; ?>>Very Old</option>
					</select>
				</div>
			</div>
			<!-- End Status Field -->
			<div class="form-group form-group-lg">
				<!-- Start Members Field -->
				<!-- <label class="col-sm-2 control-label">Member</label>
				<div class="col-sm-10 col-md-6">
					<select name="member">
						<option value="0">...</option>
							<option value='vv'>oo/option>
					</select>
				</div>
				</div> -->
				<!-- End Members Field -->
				<!-- Start Categories Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Category</label>
					<div class="col-sm-10 col-md-6">
						<select name="category">
							<option value="">...</option>
							<option value="pc"<?= @$_POST['category'] === 'pc' ? ' selected' : ''; ?>>PC</option>
							<option value="laptop"<?= @$_POST['category'] === 'laptop' ? ' selected' : ''; ?>>laptop</option>
						</select>
					</div>
				</div>

				<!-- End Categories Field -->
				<!-- Start Tags Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Image</label>
					<div class="col-sm-10 col-md-6">
						<input 
							type="file" 
							name="file[]" 
							class="form-control" 
							placeholder="Separate Tags With " />
					</div>
				</div>
				<!-- End Tags Field -->
				<!-- Start Tags Field -->
				<!-- <div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Tags</label>
					<div class="col-sm-10 col-md-6">
						<input 
							type="text" 
							name="tags" 
							class="form-control" 
							placeholder="Separate Tags With " />
					</div>
				</div> -->
				
				<!-- End Tags Field -->
				<!-- Start Submit Field -->
				<div class="form-group form-group-lg">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
					</div>
				</div>
			</div>
			<!-- End Submit Field -->
		</form>
		<div class='container'>
			<?php 
				if(isset($insert_errors)) {
					foreach ($insert_errors as $error) {
						echo "<div class='alert alert-danger'>$error</div>";
					}
				}
			?>
		</div>
	</div>
<?php
 }elseif(isset($_GET['do']) && $_GET['do'] == "Update") {
var_dump($_GET['up_id']);
	if(isset($_GET['up_id']) && is_int($_GET['up_id'])) {
		$item_id = $_GET['up_id'];

		$update_item = $fetch_all->get_item("*", "item_id", $item_id);
		// echo "<pre>";
		// print_r($update_item);
		// echo "</pre>";
		if(!empty($update_item)) {
	
?>

			<h1 class="text-center">Edit Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update&edit_id=<?= @$item_id;?>" method="POST">
					<input type="hidden" name="itemid" value="" />
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								placeholder="Name of The Item"
								value="<?= @$update_item['name'];?>" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								placeholder="Description of The Item"
								value="<?= @$update_item['description'];?>" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="price" 
								class="form-control" 
								placeholder="Price of The Item"
								value="<?= @$update_item['price'];?>" />
						</div>
					</div>
					<!-- End Price Field -->
					<!-- Start Country Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="country" 
								class="form-control" 
								placeholder="Country of Made"
								value="<?= @$update_item['country'];?>" />
						</div>
					</div>
					<!-- End Country Field -->
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-6">
							<select name="status">
								<option value="">...</option>
								<option value="new" <?= @$update_item['item_status'] === 'new' ? 'selected' : '';?>>New</option>
								<option value="like new" <?= @$update_item['item_status'] === 'like new' ? 'selected' : '';?> >Like New</option>
								<option value="used" <?= @$update_item['item_status'] === 'used' ? 'selected' : '';?> >Used</option>
								<option value="very old" <?= @$update_item['item_status'] === 'very old' ? 'selected' : '';?> >Very Old</option>
							</select>
						</div>
					</div>
					<!-- End Status Field -->
					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
								<option value="">...</option>
								<option value="pc"<?= @$update_item['category'] === 'pc' ? ' selected' : ''; ?>>PC</option>
								<option value="laptop"<?= @$update_item['category'] === 'laptop' ? ' selected' : ''; ?>>laptop</option>
							</select>
						</div>
					</div>
					<!-- End Categories Field -->
					<!-- Start Members Field -->
					<!-- <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10 col-md-6">
							<select name="member">
										<option value=''>oo</option>
							</select>
						</div>
					</div> -->
					<!-- End Members Field -->
					
					<!-- Start Tags Field -->

					<!-- <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="tags" 
								class="form-control" 
								placeholder="Separate Tags With " 
								value="<?= @$update_item['tags'];?>" />
						</div>
					</div> -->
					<!-- End Tags Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
				<div class='container'>
					<?php 
						if(isset($update_errors)) {
							foreach ($update_errors as $error) {
								echo "<div class='alert alert-danger'>$error</div>";
							}
						}
					?>
				</div>
			</div>
<?php }}}?>

					<!-- <h1 class="text-center">Manage [ ] Comments</h1>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>
							
								<tr>
									<td></td>
									<td></td>
									<td></td>
									
									<td>
										<a href='' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a> 
										<a href='' 
											class='btn btn-info activate'>
											<i class='fa fa-check'></i> Approve</a>
									</td>
								</tr>		
								</tr>		
						</table>
					</div>

				</div> -->


				<div class='container'>

				<!-- <div class="alert alert-danger">Theres No Such ID</div> -->


				</div>

<!-- 
			<h1 class='text-center'>Update Item</h1>
			<div class='container'>

			

			</div>


			<h1 class='text-center'>Delete Item</h1>
		<div class='container'>


			</div>


			<h1 class='text-center'>Approve Item</h1>
			<div class='container'>

			

			</div> -->


<?php include $tpl . 'footer.php'; ?>

<?php 
} else {
	header("location: index.php");
	exit();
}