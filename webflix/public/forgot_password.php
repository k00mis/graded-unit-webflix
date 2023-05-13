<?php
session_start();
include('includes/login.html');

# Redirect to home page if already logged in.
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}

# Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $country = $_POST['country'];

  # Open database connection.
  require ( 'connect_db.php' ) ;

# Sanitize user inputs.
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $country = mysqli_real_escape_string($link, $_POST['country']);

    # Check if email exists in database.
    $e = mysqli_real_escape_string($link, $_POST['email']);
    $q = "SELECT user_id, email, phone, country FROM webflix_users WHERE email='$e'";
    $r = mysqli_query($link, $q);
    if (mysqli_num_rows($r) == 1) {
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		
		# Check if the user's input matches the database data
        if ($row['phone'] == $phone && $row['country'] == $country) {
            
			# Generate temporary password on success
            $tp = bin2hex(random_bytes(6));
			
			# Hash the temporary password
            $hashed_password = hash('sha256', $tp);

            # Update user's password in database with the hashed password.
            $uid = $row['user_id'];
            $q = "UPDATE webflix_users SET pass='$hashed_password' WHERE user_id=$uid";
            $r = mysqli_query($link, $q);

            # Show temporary password in modal window.
            # echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
            echo '<script type="text/javascript">
                    $(document).ready(function(){
                        $("#myModal").modal("show");
                    });
                    </script>';
            echo '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Temporary Password</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          </div>
                          <div class="modal-body">
                            <p>Your temporary password is: '.$tp.'</p>
                          </div>
                          <div class="modal-footer">
                            <a href="login.php" class="btn btn-primary">Login Now</a>
                          </div>
                        </div>
                      </div>
                    </div>';
        } else {
            # Invalid input for email, phone or country.
            echo '<div class="alert alert-danger" role="alert">Invalid input for email, phone or country.</div>';
        }
    } else {
        # Email not found in database.
        echo '<div class="alert alert-danger" role="alert">This email address is not registered.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Forgot Password</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="country">Country:</label>
                                <input type="text" class="form-control" id="country" name="country" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
	#Display footer section
	include ( 'includes/footer.html' );
?>