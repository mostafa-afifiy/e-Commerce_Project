<?php
session_start();

if(isset($_SESSION['admin'])) {
	$title = "Items";  
	include 'init.php';
	
    $item = new Item();

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') { 
        $fetch_all = new Item();
                            
                            if(isset($_GET['approve_items']) && $_GET['approve_items'] == '1') {
                                $value = $_GET['approve_items'];
                                $display = "style='display:none;'";
                            }
                            else {
                                $value = '0';
                                $display = '';
                            }

                            $all_items = $fetch_all->fetch_data("*", "items", "approve", $value, all:"fetchAll");
                            
                            if(!empty($all_items)) {
        ?>
        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>Avatar</td>
                        <td>Item Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Category</td>
                        <td>Status</td>
                        <td>Adding Date</td>
                        <td>Control</td>
                        <img src="" alt="">
                    </tr>
                        <?php 
                            
                                foreach($all_items as $items) {
                                    echo "<tr>";
                                    echo "<td><img src='$items[image]' alt='Avatar' style='width:50px; max-width:100%;' ></td>";
                                    echo "<td>$items[name]</td>";
                                    echo "<td>$items[description]</td>";
                                    echo "<td>$items[price]</td>";
                                    echo "<td>$items[category]</td>";
                                    echo "<td>$items[item_status]</td>";
                                    echo "<td>$items[item_date]</td>";
                                
                                    echo "<td>
                                        <a href='?do=Edit&item_id=$items[item_id]' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='?do=Delete&item_id=$items[item_id]' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>
                                        <a href='?do=Approve&item_id=$items[item_id]' class='btn btn-info activate' $display><i class='fa fa-check'></i> Approve</a>
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
                <a href="?do=Add" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> New Item
                </a>
                <a href="?approve_items=1" class="btn btn-sm btn-primary">
                <i class='fa fa-check'></i>Approve
                </a>
                <a href="?do=Manage" class="btn btn-sm btn-danger">
                    <i class="fa fa-plus"></i> Back
                </a>
                <br><br><br><br>
            <?php
                } else{ ?>

                    <div class="container">  
					 <div class="nice-message">There\'s No Items To Show</div>  
					 <a href="items.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Item
						</a>  
				 </div>  
                 
                <?php } ?>
        </div>
        <?php } elseif ($do == 'Add') { ?>
            <h1 class="text-center">Add New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
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
                    <!-- <div class="form-group form-group-lg"> -->
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
									<?php
										$categories = new Category();
										$cats = $categories->fetch_data("name", "categories", order: 'ORDER BY ordaring', all:'fetchAll');
										foreach($cats as $cat) {
											echo "<option value='$cat[name]'>$cat[name]</option>";
										}
									?>
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
                                    name="avatar" 
                                    class="form-control"/>
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
                                <a class="add-category btn btn-danger" href="?do=Manage">Back</a>
                            </div>
                        </div>
                    <!-- </div>
                    </div> -->
                    <!-- End Submit Field -->
                </form>
            </div>
                
            
        <?php } elseif ($do == 'Insert') { 
                    if($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $insert_errors = $item->insert_item( 
                            $_POST['name'], 
                            $_POST['description'], 
                            $_POST['price'], 
                            $_POST['country'], 
                            $_POST['status'], 
                            $_POST['category'],
                            $_FILES['avatar']
                        );
                    }else{
                        header("location:items.php?do=Manage");
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
            if(isset($_GET['item_id']) && is_numeric($_GET['item_id'])) {
                $item_id = intval($_GET['item_id']);
        
                $update_item = $item->fetch_data("*", "items", "item_id", $item_id);
                // echo "<pre>";
                // print_r($update_item);
                // echo "</pre>";
                if(!empty($update_item)) {
            
        ?>
        
                    <h1 class="text-center">Edit Item</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?do=Update&item_id=<?= @$item_id;?>" method="POST" enctype="multipart/form-data">
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
									<?php
										$categories = new Category();
										$cats = $categories->fetch_data("name", "categories", order: 'ORDER BY ordaring', all:'fetchAll');
										foreach($cats as $cat) {?>
											<option value='<?= $cat['name']?>' <?= @$update_item['category'] === $cat['name'] ? 'selected' : '';?>><?= $cat['name']?></option>
                                    <?php }?>
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
                            
                <!-- Start Image Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-10 col-md-6">
                            <input 
                                type="file" 
                                name="avatar" 
                                class="form-control" 
                                value="<?= @$update_item['image'];?>" />
                        </div>
                    </div>
                    <!-- End Image Field -->
                            <!-- Start Submit Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
                                    <a class="add-category btn btn-danger" href="?do=Manage">Back</a>
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
            <?php }
            } else{
                header("location:items.php?do=Manage");
                exit();   
            }
            
        } elseif ($do == 'Update') {
                if($_SERVER['REQUEST_METHOD'] == 'POST') {

                    if(isset($_GET['item_id']) && is_numeric($_GET['item_id'])) {

                        $update_errors = $item->update_item(
                            $_POST['name'], 
                            $_POST['description'], 
                            $_POST['price'], 
                            $_POST['country'], 
                            $_POST['status'], 
                            $_POST['category'],
                            $_FILES['avatar'],
                            intval($_GET['item_id'])
                        );
                    } 
                    // echo "$update_errors";
                }else{
                    header("location:items.php?do=Manage");
                    exit();   
                }
                echo " <div class='container'>";
                if(isset($update_errors)) {
                    foreach ($update_errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }
                
                // echo " <div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>
                // echo "You Will be redirect to Previous Page After 5 Seconds";
                echo "<div class='alert alert-primary'>You Will be redirect to Previous Page After 3 Seconds</div>";
                header("refresh:3;url=items.php?do=Manage");
                echo "</div>";	
                
                ?>
        <?php  } elseif ($do == 'Delete') { 

                if(isset($_GET['item_id']) && is_numeric($_GET['item_id']) ) {
                    $delete_error = $item->delete_item($_GET['item_id']);

                    echo " <div class='container'>";
                    if(isset($delete_error)) {
                            echo "<div class='alert alert-danger'>$delete_error</div>";
                    }
                    echo "You Will be redirect to Previous Page After 2 Seconds";
                    header("refresh:2;url=items.php?do=Manage");
                    echo "</div>";	
                }
            ?>
        <?php  } elseif ($do == 'Approve') { 

                    if(isset($_GET['item_id']) && is_numeric($_GET['item_id']) ) {
                        $approve_error = $item->approve_item($_GET['item_id']);
                        
                        echo " <div class='container'>";
                        if(isset($approve_error)) {
                                echo "<div class='alert alert-danger'>$approve_error</div>";
                        }
                        echo "You Will be redirect to Previous Page After 2 Seconds";
                        header("refresh:2;url=items.php?do=Manage");
                        echo "</div>";	
                    }
    } else{
        header("location:items.php?do=Manage");
        exit();   
    }

	include $tpl . 'footer.php'; 


} else {
	header("location: index.php");
	exit();
}