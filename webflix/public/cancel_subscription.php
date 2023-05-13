<?php

if (isset($_POST['unsubscribe_button'])) {
	# Access session.
	session_start() ; 
	
	# Open database connection
	require ( 'connect_db.php' );

	# Retrieve the current user's user_id from the session
	$user_id = $_SESSION[ 'user_id' ];

    // Update the 'subscribed' value to 0 in the database for the user
	// Also updates the subscription start and end dates
    $query = "UPDATE webflix_users SET subscribed = 0, 
		sub_start_date = NULL, 
		sub_end_date = CURDATE() 
		WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $query);

	// If the update is successful, provide a message
    if ($result) {
        echo "User unsubscribed successfully!";
		// Redirect to the previous page
		$previous_page = $_SERVER['HTTP_REFERER'];
		header("Location: $previous_page");
		exit;
    } else {
		// If the update is unsuccessful, provide an error message
        echo "Error unsubscribing user: " . mysqli_error($link);
		// Redirect to the subscribe_info page, which will remain unchanged
		load ( 'subscribe_info.php' ) ;
    }
}

?>
