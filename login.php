<?php
session_start();
$title = "Login";
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['login'])) {
		$new_user = new User();
		$form_errors = $new_user->login($_POST['username'], $_POST['password']);
	}
}
?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">Login</span>
	</h1>
	<!-- Start Login Form -->
	<form class="login" action="<?= $_SERVER['PHP_SELF'];?>" method="POST">
		<div class="input-container">
			<input 
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" 
				value = "<?= @$_POST['username'];?>"
				 />
		</div>
		<div class="input-container">
			<input 
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type your password" 
				 />
		</div>
		<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
	</form>
	<!-- End Login Form -->
	<div class="the-errors text-center">
		<?php 
			if(isset($form_errors)) {
				foreach($form_errors as $error) {
					echo $error;
				}
			}
		?>
	</div>
</div>
<?php include $tpl . 'footer.php'; ?>