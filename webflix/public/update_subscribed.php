<?php

if (isset($_POST['subscribe_button'])) {
	# Access session.
	session_start() ; 
	
	# Open database connection
	require ( 'connect_db.php' );

	# Retrieve the current user's user_id from the session
	$user_id = $_SESSION[ 'user_id' ];

    // Update the 'subscribed' value to 1 in the database for the user
	// Also updates the subscription start and end dates
    $query = "UPDATE webflix_users SET subscribed = 1, 
		sub_start_date = CURDATE(), 
		sub_end_date = DATE_ADD(CURDATE(), INTERVAL 1 YEAR) 
		WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $query);

    if ($result) {
        echo "User subscribed successfully!";
		// Redirect to the previous page
		$previous_page = $_SERVER['HTTP_REFERER'];
		header("Location: $previous_page");
		exit;
    } else {
        echo "Error subscribing user: " . mysqli_error($link);
		load ( 'subscribe_info.php' ) ;
    }
}

?>
