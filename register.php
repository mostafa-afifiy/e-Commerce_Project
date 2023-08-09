<?php
session_start();
$title = "Signup";
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['signup'])) {
        $new_user = new User();
        $form_errors = $new_user->register($_POST['full_name'], $_POST['username'],
        $_POST['email'], $_POST['password'], $_POST['confirm_password']);
	}
}
?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected"  data-class="signup">Signup</span>
	</h1>
	<!-- Start Login Form -->
	<form class="login" action="<?= $_SERVER['PHP_SELF'];?>" method="POST">
		<div class="input-container">
			<input 
				pattern=".{4,}"
				title="Username Must Be Between 4 Chars"
				class="form-control" 
				type="text" 
				name="full_name" 
				autocomplete="off"
				placeholder="Type your Full Name" 
                value = "<?= @$_POST['full_name'];?>"
				 />
		</div>
		<div class="input-container">
			<input 
				pattern=".{4,}"
				title="Username Must Be Between 4 Chars"
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
				type="email" 
				name="email" 
				placeholder="Type a Valid email" 
                value = "<?= @$_POST['email'];?>"
                />
		</div>
		<div class="input-container">
			<input 
				minlength="4"
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type a Complex password" 
				 />
		</div>
		<div class="input-container">
			<input 
				minlength="4"
				class="form-control" 
				type="password" 
				name="confirm_password" 
				autocomplete="new-password"
				placeholder="Type a password again" 
				 />
		</div>
		<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
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