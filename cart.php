<?php
ob_start(); // Output Buffering Start
session_start();

if(isset($_SESSION['user'])) {
	$title = "My Cart";  
	include 'init.php';
	
    $item = new Item();

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') { 
        $connect = new Connection();
        $stmt = $connect->conn->prepare("SELECT i.item_id, i.name, i.price, i.image, c.quantity
                                            FROM items i LEFT JOIN cart c
                                            ON i.item_id = c.item_id
                                            WHERE c.user_id = $_SESSION[user_id]

                                            ");
        $stmt->execute();
        $my_items = $stmt->fetchAll();
        if(!empty($my_items)) {
            ?>
            <h1 class="text-center">My Cart</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <thead> 
                            <tr>
                                <td>Avatar</td>
                                <td>Item Name</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>Control</td>
                            </tr>
                        </thead> 
                        <tbody>
                            <?php 
                                $total = 0;
                                    foreach($my_items as $item) {
                                        echo "<tr>";
                                        echo "<td><img src='$item[image]' alt='Avatar' style='width:50px; max-width:100%;' ></td>";
                                        echo "<td>$item[name]</td>";
                                        echo "<td>$item[price]</td>";
                                        echo "<td>$item[quantity]</td>";
                                        $total += intval($item['price']) * intval($item['quantity']) ;
                                    
                                        echo "<td>
                                            <a href='?do=Show&item_id=$item[item_id]' class='btn btn-info activate'><i class='fa fa-check'></i>Show</a>
                                            <a href='?do=Edit&item_id=$item[item_id]' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                            <a href='?do=Delete&item_id=$item[item_id]' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total Price:</td>
                                <td colspan="2"><?= @$total;?> $</td>
                                <td >
                                    <a href="checkout.php" class="btn btn-sm btn-primary">Checkout</a>
                                </td>
                            </tr>
                        </tfoot>
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
                    <a href="index.php" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Continue Shopping
                    </a>
                    <br><br><br><br>
                <?php
                    } else{ ?>

                        <div class="container">  
                            <div class="nice-message">There\'s No Items To Show</div>  
                            <a href="index.php" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i> Continue Shopping
                            </a>
                        </div>  
                    <?php } ?>
            </div>
            <?php }  elseif ($do == 'Show') {
            if(isset($_GET['item_id']) && is_numeric($_GET['item_id'])) {
                $item_id = intval($_GET['item_id']);
        
                $check_item = new Connection();
	            $item_data = $check_item->fetch_data("*", "items", "item_id", intval($_GET['item_id']));
                if(!empty($item_data)) {
            
        ?>
        
        <h1 class="text-center">Item Information</h1>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<img class="img-responsive img-thumbnail center-block" src="<?= $item_data['image']; ?>" alt="avatar" />
				</div>
				<div class="col-md-9 item-info">
					<h2><?= $item_data['name']; ?></h2>
					<p><?= $item_data['description']; ?></p>
					<ul class="list-unstyled">
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<span>Added Date</span> : <?= $item_data['item_date']; ?>
						</li>
						<li>
							<i class="fa fa-money fa-fw"></i>
							<span>Price</span> : <?= $item_data['price']; ?>
						</li>
						<li>
							<i class="fa fa-building fa-fw"></i>
							<span>Made In</span> : <?= ucfirst($item_data['country']); ?>
						</li>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<span>Category</span> : <?= $item_data['category']; ?>
						</li>
						<li>
							<form action="" method="POST">
                            <?php 
                                $connect = new Connection(); 
                                $count = $connect->fetch_data("quantity", "cart", "user_id = $_SESSION[user_id] AND item_id", $item_data['item_id'] );
                            ?>
							<span>Quantity</span> : <input type="number" name="number" readonly value="<?= isset($count) ? $count['quantity'] : 1;?>">
						</li>
						<li>
							<a href="cart.php"><input class="btn btn-primary btn-block" value="Back" /></a>
						</form>
					</li>
					</ul>
				</div>
			</div>
			<hr class="custom-hr">
			<!-- Start Add Comment -->
			<div class="row">
				<div class="col-md-offset-3">
					<div class="add-comment">
						<h3>Add Your Comment</h3>
						<form action="<?= $_SERVER['PHP_SELF'];?>" method="POST">
							<textarea name="comment" ></textarea>
							<input class="btn btn-primary" type="submit" value="Add Comment">
						</form>
						<?php 
							if(isset($comment_msg)) {
								foreach($comment_msg as $msg) {
									echo $msg;
								}
							}
						?>
					</div>
				</div>
			</div>
			<!-- End Add Comment -->
			<?php
				if(!isset($_SESSION['user'])) {
					echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment';
				}
			?>
		</div>
            <?php }
            } else{
                header("location:cart.php?do=Manage");
                exit();   
            }
            
        }  elseif ($do == 'Edit') {
            if(isset($_GET['item_id']) && is_numeric($_GET['item_id'])) {
                $item_id = intval($_GET['item_id']);
        
                $check_item = new Connection();
	            $item_data = $check_item->fetch_data("*", "items", "item_id", intval($_GET['item_id']));
                if(!empty($item_data)) {
            
        ?>
        
        <h1 class="text-center">Item Information</h1>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<img class="img-responsive img-thumbnail center-block" src="<?= $item_data['image']; ?>" alt="avatar" />
				</div>
				<div class="col-md-9 item-info">
					<h2><?= $item_data['name']; ?></h2>
					<p><?= $item_data['description']; ?></p>
					<ul class="list-unstyled">
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<span>Added Date</span> : <?= $item_data['item_date']; ?>
						</li>
						<li>
							<i class="fa fa-money fa-fw"></i>
							<span>Price</span> : <?= $item_data['price']; ?>
						</li>
						<li>
							<i class="fa fa-building fa-fw"></i>
							<span>Made In</span> : <?= ucfirst($item_data['country']); ?>
						</li>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<span>Category</span> : <?= $item_data['category']; ?>
						</li>
						<li>
							<form action="?do=Update&item_id=<?= $item_data['item_id']; ?>" method="POST">
                            <?php 
                                $connect = new Connection();
                                $count = $connect->fetch_data("quantity", "cart", "user_id = $_SESSION[user_id] AND item_id", $item_data['item_id'] );
                            ?>
							<span>Quantity</span> : <input type="number" name="number" min="1" max="100" value="<?= isset($count) ? $count['quantity'] : 1;?>">
						</li>
						<li>
							<input class="btn btn-primary btn-block" name="quantity" type="submit" value="Add To Cart" />
						</form>
					</li>
					</ul>
				</div>
			</div>
			<hr class="custom-hr">
			<!-- Start Add Comment -->
			<div class="row">
				<div class="col-md-offset-3">
					<div class="add-comment">
						<h3>Add Your Comment</h3>
						<form action="<?= $_SERVER['PHP_SELF'];?>" method="POST">
							<textarea name="comment" ></textarea>
							<input class="btn btn-primary" type="submit" value="Add Comment">
						</form>
						<?php 
							if(isset($comment_msg)) {
								foreach($comment_msg as $msg) {
									echo $msg;
								}
							}
						?>
					</div>
				</div>
			</div>
			<!-- End Add Comment -->
			<?php
				if(!isset($_SESSION['user'])) {
					echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment';
				}
			?>
		</div>
            <?php }
            } else{
                header("location:cart.php?do=Manage");
                exit();   
            }
            
        } elseif ($do == 'Update') {
                if($_SERVER['REQUEST_METHOD'] == 'POST') {

                    if(isset($_GET['item_id']) && is_numeric($_GET['item_id'])) {

                        if(isset($_SESSION['user'])) {
				
                            if(isset($_POST['quantity'])) {
                                $update_item = new Connection();

                                $stmt = $update_item->conn->prepare("UPDATE cart SET quantity = ? WHERE item_id = ? AND user_id = ?");
                                $stmt->execute(array($_POST['number'], intval($_GET['item_id']), $_SESSION['user_id']));
                            }
                        }
                    } 
                }else{
                    header("location:cart.php?do=Manage");
                    exit();   
                }
                echo " <div class='container'>";
                if(isset($update_errors)) {
                    foreach ($update_errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }

                echo "<div class='alert alert-success'>Done Updated</div>";
                header("refresh:1;url=cart.php?do=Manage");
                echo "</div>";	
                
                ?>
        <?php  } elseif ($do == 'Delete') {
            if(isset($_GET['item_id']) && is_numeric($_GET['item_id']) ) {
                    $delete_error = $item->delete_item($_GET['item_id'], $_SESSION['user_id']);

                    echo " <div class='container'>";
                    if(isset($delete_error)) { 
                        echo "<div class='alert alert-danger'>$delete_error</div>";
                    }
                    header("refresh:1;url=cart.php?do=Manage");
                    echo "</div>";	
                }
            ?>
        <?php  } else{
        header("location:cart.php?do=Manage");
        exit();   
    }

	include $tpl . 'footer.php'; 
	ob_end_flush();

} else {
    echo "<script>
            if (confirm('Please log in to access your cart. Do you want to proceed to the login page?')) {
                window.location.href = 'login.php'; // Redirect to the login page
            } else {
                // User chose to cancel, handle accordingly (e.g., redirect to another page)
                window.location.href = 'index.php'; // Redirect to another page
            }
          </script>";
}