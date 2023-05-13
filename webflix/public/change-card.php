<?php
#STEP 5 of PHP Update User Details practice exercise
#This script updates the user's card details
	# Access session.
session_start() ;

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set page title and display header section.
$page_title = 'Change Password' ;

# Check form submitted.
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
  # Connect to the database.
  require ('connect_db.php'); 
  
  # Initialize an error array.
  $errors = array();
    
   if ( empty( $_POST[ 'card_number' ] ) )
  { $errors[] = 'Enter account number printed on card'; }
  else
  { $card_number = mysqli_real_escape_string( $link, trim( $_POST[ 'card_number' ] ) ) ; }
  
  
  if ( empty( $_POST[ 'exp_month' ] ) )
  { $errors[] = 'Enter expiry date printed on card'; }
  else
  { $exp_m = mysqli_real_escape_string( $link, trim( $_POST[ 'exp_month' ] ) ) ; }

  if ( empty( $_POST[ 'exp_year' ] ) )
	  { $errors[] = 'Enter expiry date printed on card'; }
	  else
	  { $exp_y = mysqli_real_escape_string( $link, trim( $_POST[ 'exp_year' ] ) ) ; }
  
  if ( empty( $_POST[ 'cvv' ] ) )
	  { $errors[] = 'Enter security code printed on back of card'; }
	  else
	  { $cvv = mysqli_real_escape_string( $link, trim( $_POST[ 'cvv' ] ) ) ; }  
  
  # On success new password into 'users' database table.
  if ( empty( $errors ) ) 
  {
    $q = "UPDATE webflix_users SET card_number='$card_number', 
	exp_month='$exp_m', exp_year='$exp_y', cvv='$cvv' 
	WHERE user_id={$_SESSION['user_id']}";
    $r = mysqli_query ( $link, $q ) ;
    if ($r)
    {
       header("Location: user.php");
    } else {
        echo "Error deleting record: " . $link->error;
    }
  
    # Close database connection.
    
	mysqli_close($link); 
    exit();
  }
  # Or report errors.
  else 
  {  
    echo ' 
	<script type ="text/JavaScript">
	alert("' ;
    foreach ( $errors as $msg )
    { echo " - $msg " ; }
    echo 'Please try again.")</script>';
    # Close database connection.
    mysqli_close( $link );
  } 
# Continue to display login page on failure.
include ( 'user.php' ) ;  

}

?>