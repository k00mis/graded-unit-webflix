<?php
# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require('login_tools.php');
    load();
}

include('includes/logout.html');

# Open database connection.
require('connect_db.php');

# Retrieve genres from 'webflix_movies' database table.
$q = "SELECT DISTINCT genre FROM webflix_tvshows";
$r = mysqli_query($link, $q);
if (mysqli_num_rows($r) > 0) {
    # Display genre filter form.
    echo '
		<div class="card mx-auto my-4" style="width: 21rem;">
			<form action="tvshows.php" method="POST">
			<label for="genre">Filter by Genre:</label>
			<select id="genre" name="genre">
			<option value="">All</option>
    ';
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<option value="' . $row['genre'] . '">' . $row['genre'] . '</option>';
    }
    echo '
            </select>
            <input type="submit" value="Filter">
        </form>
		</div>
    ';

    # Retrieve filtered movies from 'webflix_movies' database table.
    if (isset($_POST['genre']) && !empty($_POST['genre'])) {
        $genre = $_POST['genre'];
        $q = "SELECT * FROM webflix_tvshows WHERE genre='$genre'";
    } else {
        $q = "SELECT * FROM webflix_tvshows";
    }
    $r = mysqli_query($link, $q);
    if (mysqli_num_rows($r) > 0) {
        # Display body section.
        echo '
            <head>
                <!-- Custom CSS -->
                <link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
            </head>
            <div class="container">
            <div class="row">
        ';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo '
                <div class="col-md-3 d-flex justify-content-center">
                    <div class="card" style="width: 18rem;">
                        <div class="card text-center">
                            <img src=' . $row['img'] . ' alt="TV Show" class="img-thumbnail bg-secondary">
                            <h5 class="card-title">' . $row['tvshow_title'] . '</h5>
                            <a href="tvshow_info.php?id=' . $row['id'] . '" class="btn btn-secondary btn-block" role="button">
                                Watch Preview
                            </a>
                        </div>
                    </div>
                </div>
            ';
        }
        # Close database connection.
        mysqli_close($link);
        echo '</div></div>';

        # Display footer section.
        include('includes/footer.html');
    }
    # Or display message.
    else {
        echo '<p>There are currently no TV Shows available.</p>';
    }
} else {
    # Close database connection.
    mysqli_close($link);
    echo '<p>There are currently no TV Shows available.</p>';
}
?>
