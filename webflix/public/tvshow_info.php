<?php # DISPLAY COMPLETE LOGGED IN PAGE.
# Access session.
session_start() ; 

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set page title and display header section.
$page_title = 'TV Show Information' ;
include ( 'includes/logout.html' ) ;

# Get passed product id and assign it to a variable.
if ( isset( $_GET['id'] ) ) $id = $_GET['id'] ;

# Open database connection.
require ( 'connect_db.php' ) ;

# Retrieve selective item data from 'movie' database table. 
$q = "SELECT * FROM webflix_tvshows WHERE id = $id" ;
$r = mysqli_query( $link, $q ) ;
if ( mysqli_num_rows( $r ) == 1 )
{
  $row = mysqli_fetch_array( $r, MYSQLI_ASSOC );

  # Check if cart already contains one movie id.
  # if ( isset( $_SESSION['cart'][$id] ) )
  
  # Retrieve the current user's subscription status
  $user_id = $_SESSION[ 'user_id' ];
  
  # Query the database to retrieve the subscribed value for the logged-in user
	$sql = "SELECT subscribed FROM webflix_users WHERE user_id = $user_id";
	$result = mysqli_query($link, $sql);
	$status = mysqli_fetch_assoc($result);
	$subscribed = $status['subscribed'];
  
  # If the user is subscribed, display the appropraite message and "watch now" button
  if ($subscribed > 0){ 

    echo '
			<head>
				<!-- Custom CSS -->
				<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
			</head>
			<div class="container">
			<h1 class="display-4" style="color:#ffffff!important;">'.$row['tvshow_title'].'</h1>
		<div class="row">
			<div class="col-sm-12 col-md-4">
			  <div class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src='. $row['preview'].' 
					frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
					allowfullscreen>
				</iframe>
			   </div>
			</div>
			<div class="col-sm-12 col-md-4" style="color:#ffffff">
				<p>'.$row['further_info'].'</p>
			</div>
			<div class="col-sm-12 col-md-4">
				<h4 style="color:#ffffff!important;">TV Show Description</h4>
				<p>Genre: '.$row['genre'].'</p>
				<p>Year released: '.$row['release_year'].' </p>
				<p>Language: '.$row['language'].'</p>
				<p>Seasons: '.$row['seasons'].'</p>
				<p>Episodes: '.$row['episodes'].'</p>
				<h4 style="color:#ffffff!important;">Ready to watch?</h4>
				<hr>
				<p> As a Webflix Subscriber, you have premium access to stream our full range of content.</p>
				<a href="episode_list.php?id='.$row['id'].'">
				<span class="btn btn-secondary">Browse Episodes </span></a>  
			</div>
		</div>
		';
  }
else 
  { # if the user is not subscribed, show appropriate message and "subscribe now" button
 echo '<head>
		<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
		</head>
		<div class="container">
			<h1 class="display-4">'.$row['tvshow_title'].'</h1>
		<div class="row">
			<div class="col-sm-12 col-md-4">
			  <div class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src='. $row['preview'].' 
					frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
					allowfullscreen>
				</iframe>
			   </div>
			</div>
			<div class="col-sm-12 col-md-4">
				<p>'.$row['further_info'].'</p>
			</div>
			<div class="col-sm-12 col-md-4">
				<h4 style="color:#ffffff!important;">Movie Information</h4>
				<p>Genre: '.$row['genre'].'</p>
				<p>Year released: '.$row['release_year'].' </p>
				<p>Language: '.$row['language'].'</p>
				<p>Seasons: '.$row['seasons'].'</p>
				<p>Episodes: '.$row['episodes'].'</p>
				<h4 style="color:#ffffff!important;">Ready to watch?</h4>
				<p> Streaming full episodes is a premium feature exclusive to Webflix Subscribers.</p>
				<a href="subscribe_info.php">
				<span class="btn btn-secondary">Subscribe now! </span></a> 
			</div>
		</div>';
	}
}

# Close database connection.
mysqli_close($link);


# Display footer section.
include ( 'includes/footer.html' ) ;
?>