<?php
# Access session.
session_start() ; 

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set page title and display header section.
$page_title = 'Subscribe to Webflix' ;
include ( 'includes/logout.html' ) ;

	# Open database connection
	require ( 'connect_db.php' );

  # Retrieve the current user's user_id from the session
  $user_id = $_SESSION[ 'user_id' ];
  
  # Query the database to retrieve the user's subscription status
	$sql = "SELECT subscribed FROM webflix_users WHERE user_id = $user_id";
	$result = mysqli_query($link, $sql);
	$status = mysqli_fetch_assoc($result);
	$subscribed = $status['subscribed'];
  
  # If the user is already subscribed display the appropraite message and button
  if ($subscribed > 0){
	  
	  // Retrieve subscription start and end dates for the current user
		$query = "SELECT sub_start_date, sub_end_date FROM webflix_users WHERE user_id = $user_id";
		$sub_info = mysqli_query($link, $query);

		if ($sub_info) {
			$row = mysqli_fetch_assoc($sub_info);
			$sub_start_date = $row['sub_start_date'];
			$sub_end_date = $row['sub_end_date'];
		} else {
			echo "Error retrieving subscription information: " . mysqli_error($link);
		}

		// Format the subscription dates for display
		$formatted_start_date = date("j F, Y", strtotime($sub_start_date));
		$formatted_end_date = date("j F, Y", strtotime($sub_end_date));
 
	  echo '
			<head>
			<!-- Custom CSS -->
			<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
			<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
			</head>
			<div class="container">
				<div class="jumbotron jumbotron-fluid">
					<h1 class="display-4">Thank you for being a Webflix Subscriber</h1>
					<p class="lead">Welcome to a whole new world of entertainment!</p>
				</div>
				<div class="jumbotron jumbotron-fluid">
					<h3>Your subscription information:</h3>
					<p>Subscription started on ' . $formatted_start_date . '</p>
					<p>Subscription ends on ' . $formatted_end_date . '</p>
					<p>Not the information you were looking for?</p>
					<a href="user.php">Manage your account information</a>
				</div>
				<div class="jumbotron jumbotron-fluid">
					<h4>Thinking about leaving us?</h4>
					<p>We\'re sorry to see you go.</p>
					<p>Please know we\'re here for you if you change your mind.</p>
					<form method="POST" action="cancel_subscription.php">
						<button type="submit" name="unsubscribe_button" class="btn btn-secondary">Cancel my Subscription</button>
					</form>
				</div>	
			</div>
			</body>
	  ';} 
	  else {
	  echo '
			<head>
			<!-- Custom CSS -->
			<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
			<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
			</head>
			<body>
				<div class="container">
					<div class="jumbotron jumbotron-fluid">
						<h1 class="display-4">Become a Webflix Subscriber</h1>
						<p class="lead">We\'re thrilled that you are enjoying our platform and all the great content we have to offer.</p>
						<p>Joining Webflix is free, but did you know that by upgrading to our premium subscription, you\'ll unlock a whole new world of entertainment?</p>
						<h5>Upgrade to our premium subscription today and take your streaming experience to the next level!</h5>
					</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
							<h4 class="card-title">Basic Webflix Account</h4>
							<p class="text-left"><span class="material-symbols-rounded">paid</span>Price: Free</p>
							<p class="text-left"><span class="material-symbols-rounded">check_circle</span>Browse our catalogue & watch trailers</p>
							<p class="text-left"><span class="material-symbols-rounded">check_circle</span>Ad-free experience</p>
							<p class="text-left"><span class="material-symbols-rounded">check_circle</span>Compatible with multiple devices</p>
							<p class="text-left"><span class="material-symbols-rounded">cancel</span>Stream high quality movies</p>
							<p class="text-left"><span class="material-symbols-rounded">cancel</span>Stream high quality TV shows</p>
							<a href="home.php" class="btn btn-secondary">Remain Basic</a>
						</div>
					</div>
				</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Subscibed Weblix Account</h4>
						<p class="text-left"><span class="material-symbols-rounded">paid</span>Price: £8.33 per month (£99.99 per year)</p>
						<p class="text-left"><span class="material-symbols-rounded">check_circle</span>Browse our catalogue & watch trailers</p>
						<p class="text-left"><span class="material-symbols-rounded">check_circle</span>Ad-free experience</p>
						<p class="text-left"><span class="material-symbols-rounded">check_circle</span>Compatible with multiple devices</p>
						<p class="text-left"><span class="material-symbols-rounded">check_circle</span>Stream high quality movies</p>
						<p class="text-left"><span class="material-symbols-rounded">check_circle</span>Stream high quality TV shows</p>
						<form method="POST" action="update_subscribed.php">
							<button type="submit" name="subscribe_button" class="btn btn-primary">Subscribe Now!</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	</body>
	';}
	# Close database connection.
	mysqli_close( $link) ; 
	
	# Display footer section.
	include ( 'includes/footer.html' ) ;
?>