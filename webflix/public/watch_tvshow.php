<?php
	
	$page_title = 'Watch TV Show';
	include('includes/logout.html');
	
	# Access session.
	session_start() ; 

	# Redirect if not logged in.
	if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }
	
	# Get passed product id and assign it to a variable.
	if ( isset( $_GET['episode_id'] ) ) $id = $_GET['episode_id'] ;
	
	# Open database connection
	require ( 'connect_db.php' );
	
	# Retrieve items from 'webflix_episodes' database table
	$q = "SELECT * FROM webflix_episodes WHERE episode_id = $id";
	$r = mysqli_query( $link, $q );
	if( mysqli_num_rows( $r ) > 0 ){
		echo '
			<head>
				<!-- Custom CSS -->
				<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
			</head>
			<div class="container">
		';

		# Retrieve the current user's subscription status
		$user_id = $_SESSION[ 'user_id' ];
  
		# Query the database to retrieve the subscribed value for the logged-in user
		$sql = "SELECT subscribed FROM webflix_users WHERE user_id = $user_id";
		$result = mysqli_query($link, $sql);
		$status = mysqli_fetch_assoc($result);
		$subscribed = $status['subscribed'];
  
		# If the user is already subscribed display the tv show
		if ($subscribed > 0){
			while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC )){
				echo '
					<h1 class="display-4" style="color:#ffffff!important;">'.$row['episode_title'].'</h1>
					<div class="row">
						<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" src='. $row['episode_url'].' 
							frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
							allowfullscreen>
							</iframe>
						</div>
					</div>
				';
			}
		} else { # If the user is not subscribed display a message
			while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC )){
				echo '
				<div class="row">
				  <div class="col-md-3 d-flex justify-content-center">
					<div class="card">
						<div class="card-body">
							<p>Sorry, only Webflix subscribers can stream our content.</p>
							<p>Want a slice of the action? <a href="subscribe_info.php"> Subscribe today!</a></p>
						</div>
					</div>
				  </div>
				</div>';
			}
		}	
		# Close database connection
		# mysqli_close( $link );
	} else { echo '<h3>This TV show is not availble</h3>'; }
	
	echo '</div>';
	
	# Display footer section
	include ( 'includes/footer.html' );

?>

