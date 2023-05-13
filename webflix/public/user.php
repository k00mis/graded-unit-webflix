<?php # Display complete Registration Page
	
	# START STEP 1 - Get & display account info
	$page_title = 'My Account';
	include('includes/logout.html');
	
	# Access session & redirect if not logged in
	include ( 'includes/start_session.php' );
	
	# Open database connection
	require ( 'connect_db.php' );
	
	# Retrieve items from 'webflix_users' database table
	$q = "SELECT * FROM webflix_users WHERE user_id = {$_SESSION['user_id']}";
	$r = mysqli_query( $link, $q );
	if( mysqli_num_rows( $r ) > 0 ){
		echo '
			<head>
				<!-- Custom CSS -->
				<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
			</head>
			<div class="container">
			<div class="row">
		';

		# Retrieve the current user's subscription status
		$user_id = $_SESSION[ 'user_id' ];
  
		# Query the database to retrieve the subscribed value for the logged-in user
		$sql = "SELECT subscribed FROM webflix_users WHERE user_id = $user_id";
		$result = mysqli_query($link, $sql);
		$status = mysqli_fetch_assoc($result);
		$subscribed = $status['subscribed'];
  
		# If the user is already subscribed display appropriate status
		if ($subscribed > 0){
			while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC )){
				echo '
					<div class="col-sm">
					  <div class="alert alert-dark" role="alert">	
					  <h1>'  . $row['first_name'] . ' '  . $row['last_name'] . '<strong>  </h1> 
					  <p><strong> User ID : WF2023 '  . $row['user_id'] . ' </strong></p>
					  <p><strong> Date of birth : </strong> '  . $row['date_of_birth'] . ' </p>
					  <p><strong> Email : </strong> '  . $row['email'] . ' </p>
					  <p><strong> Phone number : </strong> '  . $row['phone'] . ' </p>
					  <p><strong> Country : </strong> '  . $row['country'] . ' </p>
					  <p><strong> Registration Date : </strong> '  . $row['reg_date'] . ' </p>
					  <p><strong> Subscription Status : Current Subscriber</strong></p>
					  <p><a href="subscribe_info.php">Manage my Subscription</a></p>
					  <!-- Button trigger modal -->
						<button type="button" class="btn btn-link" data-toggle="modal" data-target="#password">
						<i class="fa fa-edit"></i>  Change Password
						</button>
					 </div>
					</div>
				';
			}
		} else { # If the user is not subscribed display appropriate status
			while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC )){
				echo '
					<div class="col-sm">
					  <div class="alert alert-dark" role="alert">	
					  <h1>'  . $row['first_name'] . ' '  . $row['last_name'] . '<strong>  </h1> 
					  <p><strong> User ID : WF2023 '  . $row['user_id'] . ' </strong></p>
					  <p><strong> Date of birth : </strong> '  . $row['date_of_birth'] . ' </p>
					  <p><strong> Email : </strong> '  . $row['email'] . ' </p>
					  <p><strong> Phone number : </strong> '  . $row['phone'] . ' </p>
					  <p><strong> Country : </strong> '  . $row['country'] . ' </p>
					  <p><strong> Registration Date : </strong> '  . $row['reg_date'] . ' </p>
					  <p><strong> Subscription Status : None</strong></p>
					  <a href="subscribe_info.php">Learn about Webflix Subscriptions</a>
					  <!-- Button trigger modal -->
						<button type="button" class="btn btn-link" data-toggle="modal" data-target="#password">
						<i class="fa fa-edit"></i>  Change Password
						</button>
					 </div>
					</div>
				';
			}
		}	
		# Close database connection
		# mysqli_close( $link );
	} else { echo '<h3>No user details.</h3>'; }
	# END OF STEP 1
	
	# START STEP 2 - Get & dispay user card details
	
	# Retrieve items from 'webflix_users' database table
	$q = "SELECT * FROM webflix_users WHERE user_id={$_SESSION['user_id']}";
	$r = mysqli_query( $link, $q );
	if ( mysqli_num_rows( $r ) > 0){
		echo '<div class="col-sm">';
		while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC )){
			echo '
				<div class="alert alert-secondary" role="alert">
					<h1>Card Stored</h1>
						<p><strong> Card Holder : </strong> '  . $row['first_name'] . '  '  . $row['last_name'] . ' </p>
						<p><strong> Card Number : </strong> '  . $row['card_number'] . ' </p>
						<p><strong> Expiry Date : </strong> '  . $row['exp_month'] . ' / '  . $row['exp_year'] . '</p>
					<button type="button" class="btn btn-link" data-toggle="modal" data-target="#card">
						<i class="fa fa-credit-card"></i>  Update Card 
					</button>
				</div>
			</div>
			';
		}
		# Close Database Connection
		mysqli_close( $link );
	} else {
		echo '
			<div class="alert alert-danger" alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h1>Card Stored</h1>
				<h3>No card stored.</h3>
			</div>
		';
	}
	
	echo '</div></div>';
	
	# Display footer section
	include ( 'includes/footer.html' );
	# END OF STEP 2
?>

<head>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
</head>

<!-- START STEP 3 - Create Update User Data HTML Form -->
<!-- Change Password  Modal -->
<div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="password" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Change Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!-- Modal Body -->  
			<div class="modal-body">
				<form action="change-password.php" method="post">
					<!-- Input box for Card Number -->
					<div class="form-group">
                <input type="password" 
				       name="pass1" 
					   class="form-control" 
					   placeholder="New Password"
					   value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" required>

            </div>
            <div class="form-group">
                <input type="password" 
					   name="pass2" 
					   class="form-control" 
					   placeholder="Confirm New Password"
					   value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" required>

            </div>
				<div class="modal-footer">
				  <div class="form-group">
					<input type="submit" name="btnChangePassword" class="btn btn-secondary btn-block" value="Save Changes"/>
				  </div>
				</div>
         </form>
					
			</div><!-- Close modal body -->
		</div><!-- Close modal-content -->
	</div><!-- Close modal-dialog -->
</div> <!-- Close modal-fade -->

<!-- Change Card Details Modal -->
<div class="modal fade" id="card" tabindex="-1" role="dialog" aria-labelledby="card" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Update Payment Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!-- Modal Body -->  
			<div class="modal-body">
				<form action="change-card.php" method="post">
					<!-- Input box for E-mail Address -->
					<div class="form-group">
						<input type="email"  name="email" 
						 class="form-control"  
						 placeholder="Confirm Email"
						 value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" 
						 required>
					</div>
					<!-- Input box for Card Number -->
					<div class="form-group">
						<input type="text"
							name="card_number" 
							class="form-control" 
							placeholder="Card Number "
							value="<?php if (isset($_POST['card_number'])) echo $_POST['card_number']; ?>" 
							required>
					</div>
					<!-- Input box for Expiry Month -->
					<div class="form-group">
						<input type="text" 
						  name="exp_month" 
						  class="form-control" 
						  placeholder="MM"
						  value="<?php if (isset($_POST['exp_month'])) echo $_POST['exp_month']; ?>" 
						required>
					</div>
					<!-- Input box for Expiry Year -->
					<div class="form-group">
						<input type="text" 
						  name="exp_year" 
						  class="form-control" 
						  placeholder="YY"
						  value="<?php if (isset($_POST['exp_year'])) echo $_POST['exp_exp_year']; ?>" 
						required>
					</div>
					<!-- Input box for CVV Code -->
					<div class="form-group">
						<input type="text" 
						  name="cvv" 
						  class="form-control" 
						  placeholder="CVV (3 digits found on the back of card) "
						  value="<?php if (isset($_POST['cvv'])) echo $_POST['cvv']; ?>" 
						required>
					</div>
					<!-- Modal Footer -->
					<div class="modal-footer">
						<div class="form-group">
							<input type="submit"
							name="btnChangeCard" 
							class="btn btn-dark btn-lg btn-block" 
							value="Save Changes"/>
						</div>
					</div>
				</form>
			</div><!-- Close modal body -->
		</div><!-- Close modal-content -->
	</div><!-- Close modal-dialog -->
</div> <!-- Close modal-fade -->
<!-- END OF STEP 3-->

