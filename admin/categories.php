<?php
ob_start(); // Output Buffering Start
session_start();

if(isset($_SESSION['admin'])) {
	$title = "Categories";  
	include 'init.php';
	
    $category = new Category();

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') { 
		$category = new Category();
		$categories = $category->fetch_data("*", "categories", order: 'ORDER BY ordaring', all: 'fetchAll');
		if(!empty($categories)) {
		?>
			<h1 class="text-center">Manage Categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i> Manage Categories
						<div class="option pull-right">
							<!-- <i class="fa fa-sort"></i> Ordering: [
							<a class="" href="?sort=asc">Asc</a> | 
							<a class="" href="?sort=desc">Desc</a> ] -->
							<i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full">Full</span> |
							<span data-view="classic">Classic</span> ]
						</div>
					</div>
					<div class="panel-body">
		
					<?php
						foreach($categories as $cat) {
					?>
						<div class='cat'>    
							<div class='hidden-buttons'>
								<a href='?do=Edit&cat_id=<?= $cat['id'];?>' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>
								<a href='?do=Delete&cat_id=<?= $cat['id'];?>' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>
							</div>
							<h3><?= $cat['name'];?></h3>
							<div class='full-view'>
								<p><?= $cat['description'];?></p>
								<?= $cat['visibility'] == '0' ? '<span class="visibility cat-span"><i class="fa fa-eye"></i> Hidden</span>' : '';?>
								<?= $cat['allow_comment'] == '0' ? '<span class="commenting cat-span"><i class="fa fa-close"></i> Comment Disabled</span>' : '';?>
								<?= $cat['allow_ads'] == '0' ? '<span class="advertises cat-span"><i class="fa fa-close"></i> Ads Disabled</span>' : '';?>
							</div>    
		
								<!-- <h4 class='child-head'>Child Categories</h4>
								<ul class='list-unstyled child-cats'>
									<li class='child-link'>
										<a href=''></a>
										<a href='' class='show-delete confirm'> Delete</a>
									</li>
								</ul>
		-->
						</div>
						<hr>
						<?php }?>
						
					</div>
				</div>
				<a class="add-category btn btn-primary" href="?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
			</div>
			<?php 
			} else { ?>
					<div class="container">  
						<div class="nice-message">There\'s No Categories To Show</div>  
						<a href="categories.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Category
						</a>  
					</div>  
					<?php }?>

    <?php } elseif ($do == 'Add') { ?>
        <h1 class="text-center">Add New Category</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST">
				<!-- Start Name Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control" 
						autocomplete="off"  placeholder="Name Of The Category" 
						value='<?= @$_POST['name'];?>'/>
					</div>
				</div>
				<!-- End Name Field -->
				<!-- Start Description Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="description" class="form-control" 
						placeholder="Describe The Category" 
						value='<?= @$_POST['description'];?>'/>
					</div>
				</div>
				<!-- End Description Field -->
				<!-- Start Ordering Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Ordering</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="ordering" class="form-control" 
						placeholder="Number To Arrange The Categories" 
						value='<?= @$_POST['ordering'];?>'/>
					</div>
				</div>
				<!-- End Ordering Field -->
				<!-- Start Visibility Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Visible</label>
					<div class="col-sm-10 col-md-6">
						<div>
							<input id="vis-yes" type="radio" name="visibility" value="1" <?= @$_POST['visibility'] == '1' ? 'checked' : 'checked';?> />
							<label for="vis-yes">Yes</label> 
						</div>
						<div>
							<input id="vis-no" type="radio" name="visibility" value="0" <?= @$_POST['visibility'] == '0' ? 'checked' : '';?>/>
							<label for="vis-no">No</label> 
						</div>
					</div>
				</div>
				<!-- End Visibility Field -->
				<!-- Start Commenting Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Allow Commenting</label>
					<div class="col-sm-10 col-md-6">
						<div>
							<input id="com-yes" type="radio" name="commenting" value="1" <?= @$_POST['commenting'] == '1' ? 'checked' : 'checked';?> />
							<label for="com-yes">Yes</label> 
						</div>
						<div>
							<input id="com-no" type="radio" name="commenting" value="0" <?= @$_POST['commenting'] == '0' ? 'checked' : '';?> />
							<label for="com-no">No</label> 
						</div>
					</div>
				</div>
				<!-- End Commenting Field -->
				<!-- Start Ads Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Allow Ads</label>
					<div class="col-sm-10 col-md-6">
						<div>
							<input id="ads-yes" type="radio" name="ads" value="1" <?= @$_POST['ads'] == '1' ? 'checked' : 'checked';?> />
							<label for="ads-yes">Yes</label> 
						</div>
						<div>
							<input id="ads-no" type="radio" name="ads" value="0" <?= @$_POST['ads'] == '0' ? 'checked' : '';?> />
							<label for="ads-no">No</label> 
						</div>
					</div>
				</div>
				<!-- End Ads Field -->
				<!-- Start Submit Field -->
				<div class="form-group form-group-lg">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
                        <a class="add-category btn btn-danger" href="?do=Manage">Back</a>
					</div>
				</div>
				<!-- End Submit Field -->
			</form>
		
    <?php } elseif ($do == 'Insert') { 
                if($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $insert_errors = $category->insert_category( 
                        $_POST['name'], 
                        $_POST['description'], 
                        $_POST['ordering'], 
                        $_POST['visibility'], 
                        $_POST['commenting'], 
                        $_POST['ads']
                    );
                    }else{
                        header("location:categories.php?do=Manage");
                        exit();   
                    }
                    
                    echo " <div class='container'>";
                    if(isset($insert_errors)) {
                        foreach ($insert_errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    }
                    echo "You Will be redirect to Previous Page After 3 Seconds";
                    header("refresh:3;url=$_SERVER[HTTP_REFERER]");
                    echo "</div>";


    } elseif ($do == 'Edit') {

        if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
            $cat_id = intval($_GET['cat_id']);
    
            $cat = $category->fetch_data("*", "categories", "id", $cat_id);
            if(!empty($cat)) {
        
        ?>
       <h1 class="text-center">Edit Category</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update&cat_id=<?= $cat['id'];?>" method="POST">
						<input type="hidden" name="catid" value="<?= $cat['id'];?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" class="form-control"  placeholder="Name Of The Category" value="<?= $cat['name'];?>" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class="form-control" placeholder="Describe The Category" value="<?= $cat['description'];?>" />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Ordering Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Ordering</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" value="<?= $cat['ordaring'];?>" />
							</div>
						</div>
						<!-- End Ordering Field -->
						<!-- Start Visibility Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="vis-yes" type="radio" name="visibility" value="1" <?= $cat['visibility'] == '1' ? 'checked' : '';?>/>
									<label for="vis-yes">Yes</label> 
								</div>
								<div>
									<input id="vis-no" type="radio" name="visibility" value="0" <?= $cat['visibility'] == '0' ? 'checked' : '';?>/>
									<label for="vis-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Visibility Field -->
						<!-- Start Commenting Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commenting</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="com-yes" type="radio" name="commenting" value="1" <?= $cat['allow_comment'] == '1' ? 'checked' : '';?>/>
									<label for="com-yes">Yes</label> 
								</div>
								<div>
									<input id="com-no" type="radio" name="commenting" value="0" <?= $cat['allow_comment'] == '0' ? 'checked' : '';?>/>
									<label for="com-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Commenting Field -->
						<!-- Start Ads Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="ads-yes" type="radio" name="ads" value="1" <?= $cat['allow_ads'] == '1' ? 'checked' : '';?>/>
									<label for="ads-yes">Yes</label> 
								</div>
								<div>
									<input id="ads-no" type="radio" name="ads" value="0" <?= $cat['allow_ads'] == '0' ? 'checked' : '';?>/>
									<label for="ads-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Ads Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
                                <a class="add-category btn btn-danger" href="?do=Manage">Back</a>
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>
        <?php }
        } else{
            header("location:categories.php?do=Manage");
            exit();   
        }
        
    } elseif ($do == 'Update') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
                    $cat_id = intval($_GET['cat_id']);
                    $update_errors = $category->update_category(
                        $_POST['name'], 
                        $_POST['description'], 
                        $_POST['ordering'], 
                        $_POST['visibility'], 
                        $_POST['commenting'], 
                        $_POST['ads'],
                        $cat_id
                    );
                } 
            }else{
                header("location:categories.php?do=Manage");
                exit();   
            }
            echo " <div class='container'>";
            if(isset($update_errors)) {
                foreach ($update_errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
            
            echo "<div class='alert alert-primary'>You Will be redirect to Previous Page After 5 Seconds</div>";
            header("refresh:3;url=categories.php?do=Manage");
            echo "</div>";	
            
            ?>
    <?php  } elseif ($do == 'Delete') { 
        if(isset($_GET['cat_id']) && is_numeric($_GET['cat_id']) ) {

            $delete_error = $category->delete_category(intval($_GET['cat_id']));


            echo " <div class='container'>";
            if(isset($delete_error)) {
                    echo "<div class='alert alert-danger'>$delete_error</div>";
            }
            echo "You Will be redirect to Previous Page After 5 Seconds";
            header("refresh:3;url=categories.php?do=Manage");
            echo "</div>";	
        } 
    } else{
        header("location:categories.php?do=Manage");
        exit();   
    }

	include $tpl . 'footer.php'; 
	ob_end_flush();

} else {
	header("location: index.php");
	exit();
}