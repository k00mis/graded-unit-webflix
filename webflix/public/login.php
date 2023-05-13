<?php # Display complete login page

# Include HTML static file login.html
include ( 'includes/login.html' );

# Display any error messages if error is present
if ( isset ($errors) && !empty ($errors) ){
	echo ' <div class="d-flex justify-content-center">
	<div class="card" style="width: 18rem;">
		<div class="card-body">
			<p id="err-msg">Oops! There was a problem: <br>';
	foreach ( $errors as $msg ) {
		echo "- $msg <br>";
	} 
	echo 'Please try again or <a href="register.php">Register an Account</a></p>
	</div></div></div><br>';
}

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
</head>

	<div class="d-flex justify-content-center">
		<div class="card" style="width: 18rem;">
			<div class="card-body">
				<h3 class="card-title">Login: </h3>
				<!-- This is the login form -->
				<form action="login_action.php" method="post">
					<p>Email: <br><input type="text" name="email"></p>
					<p>Password: <input type="password" name="pass"></p>
					<p><input type="submit" value="Login"></p>
				</form>
				<p><a href="forgot_password.php">Forgot your Password?</a></p>
				<p>Are you new to Webflix?</p>
				<a href="register.php">Sign up to Webflix for free here!</a>
			</div>
		</div>
	</div>

	<?php
		include ( 'includes/footer.html' );
	?>
</html>