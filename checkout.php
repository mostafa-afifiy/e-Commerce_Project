<?php
ob_start(); // Output Buffering Start
session_start();

if(isset($_SESSION['user'])) {
    include 'init.php';
    ?>
    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            <strong>Success!</strong> Your Checkout Was Completed Successfully.
        </div>
    </div>
    <?php
    $connect = new Connection();
    $delete = $connect->conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $delete->execute(array($_SESSION['user_id']));
    ?>
<?php 
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>
<?php 
}else {
    header("location: index.php");
    exit();
}
?>
<?php 
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>
