<?php

session_start();
include 'include/constant.php';

if(isset($_SESSION['user_id'])){
	header('Location: '.SITEURL.'/profile.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login/Signup Form</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
  <link rel="stylesheet" href="assets/style.css">

</head>
<body>
	<div class="container <?php echo (isset($_GET['action']) && $_GET['action'] == 'sign-up')? 'right-panel-active': ''; ?>" id="container">
		<div class="form-container sign-up-container">
			<form action="include/action.php" method="POST">

				<?php if(isset($_GET['action']) and $_GET['action'] == 'sign-up'){
						 if(isset($_GET['error'])){ ?>
					<span class="error"><?php echo str_replace('-', ' ', ucfirst($_GET['error'])) ?></span>
				<?php }else if(isset($_GET['success'])){ ?>
					<span class="success"><?php echo str_replace('-', ' ', ucfirst($_GET['success'])) ?></span>
				<?php } } ?>

				<h1>Create Account</h1>
				<span>use your email for registration</span>
				<div>
					<input type="text" name="first_name" placeholder="First Name" required>
					<input type="text" name="last_name" placeholder="Last Name" required style="margin-left: 10px;width: calc(50% - 10px);">
				</div>
				<input type="text" placeholder="Address" name="address" />
				<div>
					<input type="text" name="username" required placeholder="User Name">
					<input type="tel" name="phone" placeholder="Mobile Number" style="margin-left: 10px;width: calc(50% - 10px);">
				</div>
				<input type="email" name="email" placeholder="Email" required />
				<div>
					<input type="password" name="password" required placeholder="Password">
					<input type="password" name="confirm_password" required placeholder="Verify Password" style="margin-left: 10px;width: calc(50% - 10px);">
				</div>
				<input type="hidden" name="action" value="sign-up">
				<button>Sign Up</button>
			</form>
		</div>
		<div class="form-container sign-in-container">

			<?php if(isset($_GET['action']) and $_GET['action'] == '2fa'){ ?>
				<form action="include/action.php" method="POST">

					<?php if(isset($_GET['action']) and $_GET['action'] == '2fa'){
							if(isset($_GET['error'])){ ?>
						<span class="error"><?php echo str_replace('-', ' ', ucfirst($_GET['error'])) ?></span>
					<?php }else if(isset($_GET['success'])){ ?>
						<span class="success"><?php echo str_replace('-', ' ', ucfirst($_GET['success'])) ?></span>
					<?php } } ?>

					<h1>Two Factor Verification</h1>
					<span>code here</span>
					<input type="text" name="code" placeholder="Verification Code" />
					<input type="hidden" name="action" value="2fa">
					<button>Verify</button>

				</form>
			<?php } else{ ?>

			<form action="include/action.php" method="POST">

				<?php if(isset($_GET['action']) and $_GET['action'] == 'login'){
						 if(isset($_GET['error'])){ ?>
					<span class="error"><?php echo str_replace('-', ' ', ucfirst($_GET['error'])) ?></span>
				<?php }else if(isset($_GET['success'])){ ?>
					<span class="success"><?php echo str_replace('-', ' ', ucfirst($_GET['success'])) ?></span>
				<?php } } ?>

				<h1>Sign in</h1>
				<span>use your account</span>
				<input type="text" name="username" placeholder="Username" />
				<input type="password" name="password" placeholder="Password" />
				<input type="hidden" name="action" value="login">
				<button>Sign In</button>
			</form>

			<?php } ?>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Welcome Back!</h1>
					<p>To keep connected with us please login with your personal info</p>
					<button class="ghost" id="signIn">Sign In</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Hello, Friend!</h1>
					<p>Enter your personal details and start journey with us</p>
					<button class="ghost" id="signUp">Sign Up</button>
				</div>
			</div>
		</div>
	</div>


	<script src="assets/script.js"></script>

</body>
</html>
