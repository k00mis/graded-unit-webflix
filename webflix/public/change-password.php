<?php
# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

# Set page title and display header section.
$page_title = 'Change Password';

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Connect to the database.
    require('connect_db.php');

    # Check for a password and matching input passwords.
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Passwords do not match.';
        } else {
            $p = mysqli_real_escape_string($link, trim($_POST['pass1']));
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    # Check if email address already registered.
    if (empty($errors)) {
        $q = "SELECT * FROM webflix_users WHERE user_id='{$_SESSION['user_id']}'";
        $r = mysqli_query($link, $q);
    }

    # On success new password into 'users' database table.
    if (empty($errors)) {
        $q = "UPDATE webflix_users SET pass= SHA2('$p',256) WHERE user_id='{$_SESSION['user_id']}'";
        $r = mysqli_query($link, $q);
        if ($r) {
            header("Location: user.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($link);
        }
    }
    # Or report errors.
    else {
        echo '<script type ="text/JavaScript">alert("';
        foreach ($errors as $msg) {
            echo " - $msg ";
        }
        echo 'Please try again.")</script>';
    }

    # Close database connection.
    mysqli_close($link);
}

# Continue to display login page on failure.
include('user.php');
?>
