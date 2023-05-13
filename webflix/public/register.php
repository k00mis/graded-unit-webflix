<?php
	# Include HTML static file login.html
	include ( 'includes/login.html' );
	
	# Check if the form has been submitted
	if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
				
		# Connect to the database
		require ('connect_db.php');
				
		# Initialise an error message array
		$errors = array();
				
		# Check for a first name
		if ( empty( $_POST[ 'first_name' ] )) {
			$errors[] = 'Enter your first name.';
		} else {
			$fn = mysqli_real_escape_string( $link, trim( $_POST[ 'first_name' ] ) );
		}
				
		# Check for last name
		if ( empty( $_POST[ 'last_name' ] ) ) {
			$errors[] = 'Enter your last name';
		} else {
			$ln = mysqli_real_escape_string( $link, trim( $_POST[ 'last_name' ] ) );
		}
		
		# Check for a date of birth
		if ( empty( $_POST[ 'date_of_birth' ] )) {
			$errors[] = 'Enter your date of birth.';
		} else {
			$dob = mysqli_real_escape_string( $link, trim( $_POST[ 'date_of_birth' ] ) );
		}
		
		# Check for email address
		if ( empty( $_POST[ 'email' ] ) ) {
			$errors[] = 'Enter your email';
		} else {
			$e = mysqli_real_escape_string( $link, trim( $_POST[ 'email' ] ) );
		}
				
		# Check if passwords match
		if ( !empty( $_POST[ 'pass1' ] ) ) {
			if ( $_POST[ 'pass1' ] != $_POST[ 'pass2' ] ) {
				$errors[] = 'Passwords do not match.' ;
			} else {
				$p = mysqli_real_escape_string( $link, trim( $_POST[ 'pass1' ] ) ) ;
			}
		} else {
			$p = 'Enter your password.' ;
		}
				
		# Check for phone number
		if ( empty( $_POST[ 'phone' ] )) {
			$errors[] = 'Enter your phone number.';
		} else {
			$phone = mysqli_real_escape_string( $link, trim( $_POST[ 'phone' ] ) );
		}
		# Check for country
		if ( empty( $_POST[ 'country' ] )) {
			$errors[] = 'Enter your country of residence.';
		} else {
			$country = mysqli_real_escape_string( $link, trim( $_POST[ 'country' ] ) );
		}
		
		# Check for card number
		if ( empty( $_POST[ 'card_number' ] )) {
			$errors[] = 'Enter your card number.';
		} else {
			$card_no = mysqli_real_escape_string( $link, trim( $_POST[ 'card_number' ] ) );
		}
				
		# Check for card expiry date
		if ( empty( $_POST[ 'exp_month' ] )) {
			$errors[] = 'Enter your card expiry month.';
		} else {
			$exp_m = mysqli_real_escape_string( $link, trim( $_POST[ 'exp_month' ] ) );
		}
		if ( empty( $_POST[ 'exp_year' ] )) {
			$errors[] = 'Enter your card expiry year.';
		} else {
			$exp_y = mysqli_real_escape_string( $link, trim( $_POST[ 'exp_year' ] ) );
		}
				
		# Check for card cvv code
		if ( empty( $_POST[ 'cvv' ] )) {
			$errors[] = 'Enter your CVV.';
		} else {
			$cvv = mysqli_real_escape_string( $link, trim( $_POST[ 'cvv' ] ) );
		}
				
		# Check if email address already registered
		if ( empty( $errors ) ) {
			$q = "SELECT user_id FROM webflix_users WHERE email='$e'" ;
			$r = @mysqli_query ( $link, $q ) ;
			if ( mysqli_num_rows( $r ) != 0 ) {
				$errors[] = 'Email address already registered.' ;
			}
		}
				
		# Insert user data into 'webflix_users' database table if registration successful
		if ( empty ( $errors ) ) {
			$q = "INSERT INTO webflix_users
			(first_name, last_name, date_of_birth, email, pass, phone, country, 
			card_number, exp_month, exp_year, cvv, reg_date)
			VALUES ('$fn', '$ln', '$dob', '$e', SHA2('$p',256), '$phone', '$country',
			'$card_no', '$exp_m', '$exp_y', '$cvv', NOW())" ;
			$r = @mysqli_query ( $link, $q ) ;
			if ($r) {
				echo '
				<head>
				<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
				</head>
				<p>You are now registered. <a href="login.php">Login now!</a></p></p>' ;
			}
					
			# Close database connection
			mysqli_close($link);
			exit();
		} else {
			echo '<head>
			<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
			</head>
			<div class="d-flex justify-content-center">
				<div class="card" style="width: 18rem;">
			<h1>Error!</h1><p id="err_msg">The following error(s) occured:<br>';
			foreach ( $errors as $msg ) {
				echo " - $msg<br>" ;
			}
			echo 'Please try again </p></div></div>';
			# Close database connection
			mysqli_close( $link );
		}
	}	
?>


<html>
<head>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
	
</head>
<div class="d-flex justify-content-center">
	<div class="card" style="width: 18rem;">
		<div class="card-body">
			<h3 class="card-title">Create an account: </h3>
			<!-- This is the Registeration form -->
			<form action="register.php" method = "POST">
				<label for="first_name">First name:</label><br>
				<input type="text" id="first_name" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>"><br>
				
				<label for="last_name">Last name:</label><br>
				<input type="text" id="last_name" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"><br>
				
				<label for="date_of_birth">Date of birth:</label><br>
				<input type="date" id="date_of_birth" name="date_of_birth" value="<?php if (isset($_POST['date_of_birth'])) echo $_POST['date_of_birth']; ?>"><br>
				
				<label for="email">Email:</label><br>
				<input type="email" id="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"><br>
				
				<label for="phone">Phone:</label><br>
				<input type="tel" id="phone" name="phone" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>"><br>
				
				<label for="country">Country:</label><br>
				<input type="text" id="country" name="country" value="<?php if (isset($_POST['country'])) echo $_POST['country']; ?>"><br>
				
				<label for="pass1">Password:</label><br>
				<input type="password" id="pass1" name="pass1" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"><br>
				
				<label for="pass2">Confirm Password:</label><br>
				<input type="password" id="pass2" name="pass2" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"><br>
				
				<br>
				<h4>Enter payment details</h4>
				<p>Don't worry, registering an account is free. Payment is only taken if you decide to subscribe to our service.</p>
				
				<label for="card_number">Card Number:</label><br>
				<input type="number" id="card_number" name="card_number" value="<?php if (isset($_POST['card_number'])) echo $_POST['card_number']; ?>"><br>
				
				<label for="exp_month">Expiry Month:</label><br>
				<input type="number" id="exp_month" name="exp_month" value="<?php if (isset($_POST['exp_month'])) echo $_POST['exp_month']; ?>"><br>
				
				<label for="exp_year">Expiry Year:</label><br>
				<input type="number" id="exp_year" name="exp_year" value="<?php if (isset($_POST['exp_year'])) echo $_POST['exp_year']; ?>"><br>
				
				<label for="cvv">CVV:</label><br>
				<input type="number" id="cvv" name="cvv" value="<?php if (isset($_POST['cvv'])) echo $_POST['cvv']; ?>"><br>
				
				<br>
				<input type="submit" value="Submit">
			</form>
		</div>
	</div>
</div>

</html>