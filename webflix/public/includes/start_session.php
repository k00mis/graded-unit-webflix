<?php 
# This script accesses session data and redirects user to login page if they are not signed in
	
	#Access session
	session_start();
	
	# Redirect to login if user is not logged in
	if ( !isset( $_SESSION[ 'user_id' ] ) ) {
		require ( 'login_tools.php' );
		load();
	}
?>