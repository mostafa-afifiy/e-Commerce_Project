<?php
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
	$login_errors = $new_user->login($_POST['user'], $_POST['pass']);
}

?>
	<form class="login" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" value = "<?= @$_POST['user'];?>"/>
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary btn-block" type="submit" value="Login" />
	</form>

	<?php 
		if(isset($login_errors)) {
			foreach($login_errors as $error) {
				echo "<div class='alert alert-danger'>$error</div>";
			}
		}
	?>

<?php include $tpl . 'footer.php'; ?>