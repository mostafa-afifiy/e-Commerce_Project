<?php
ob_start(); // Output Buffering Start
session_start();
$title = "Login";
$no_navbar = "";

if(isset($_SESSION['admin'])) {
	header("location: dashboard.php");
	exit();
}
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$new_user = new User();
	$login_errors = $new_user->login($_POST['username'], $_POST['pass']);
}

?>
<div class="container login-page">
	<h1 class="text-center">
		<span>Admin Login</span>
	</h1>
	<form class="login" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
		<input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" value = "<?= @$_POST['username'];?>"/>
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary btn-block" type="submit" value="Login" />
	</form>

	<?php 
		if(isset($login_errors)) {
			foreach($login_errors as $error) {
				echo $error;
			}
		}
	?>
</div>

<?php 
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>