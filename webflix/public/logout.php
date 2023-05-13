<?php
#This script logs users out of their account

	#Access session
	session_start();
	
	# Redirect if not logged in
	if ( !isset( $_SESSION['user_id'] ) ){
		require( 'login_tools.php' );
		load();
	}
	
	# Set page title and display header section
	$page_title = 'Home';
	include ( 'includes/logout.html' );	
	
	#Clear existing variables
	$_SESSION = array();
	
	#Destroy the session
	session_destroy();
	
	#Display body section
	echo '
			<head>
			<!-- Custom CSS -->
			<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
			</head>
			<div class="d-flex justify-content-center">
				<div class="card">
					<h1>Goodbye!</h1> 
					<br>
					<p>You are now logged out of your account.</p>
					<br>
					<a class="btn btn-dark" href="login.php" role="button">Login</a>
				</div>
			</div>';

	#Display footer section
	include ( 'includes/footer.html' );
?>