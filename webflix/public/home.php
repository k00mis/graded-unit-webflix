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

# Retrieve movies from 'webflix_movies' database table.
$q = "SELECT * FROM webflix_movies";
$r = mysqli_query($link, $q);

if (mysqli_num_rows($r) > 0) {
    # Display movie section.
    echo '
    <head>
        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
    </head>
    <div class="container">
		<div class="jumbotron">
			<h3 class="display-4">Welcome back, '. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'].'!</h3>
			<p class="lead">A world of exiting content awaits!</p>
			<div class="row justify-content-center">
				<div class="col-md-auto">
					<a class="btn btn-dark btn-lg" href="movie_list.php" role="button">Browse Movies</a>
				</div>
				<div class="col-md-auto">
					<a class="btn btn-dark btn-lg" href="tvshows.php" role="button">Browse TV Shows</a>
				</div>
			</div>
			<br>
			<a href="logout.php"><p>Whoops, are you not '. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'].'?</p></a>
		</div>

        <h2 class="text-center mb-4">Movies</h2>
        <div id="movie-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">';

    $i = 0;
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        if ($i % 4 == 0) {
            if ($i == 0) {
                echo '<div class="carousel-item active"><div class="row">';
            } else {
                echo '</div></div><div class="carousel-item"><div class="row">';
            }
        }

        echo '
        <div class="col-md-3 d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <div class="card text-center">
                    <img src="' . $row['img'] . '" alt="Movie" class="img-thumbnail bg-secondary">
                    <h5 class="card-title">' . $row['movie_title'] . '</h5>
                    <a href="movie.php?id=' . $row['id'] . '" class="btn btn-secondary btn-block" role="button">
                        Watch Preview
                    </a>
                </div>
            </div>
        </div>
        ';

        $i++;
    }

    echo '</div></div>';
    echo '
            <a class="carousel-control-prev" href="#movie-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#movie-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>';

    # Retrieve TV shows from 'webflix_tvshows' database table.
    $q = "SELECT * FROM webflix_tvshows";
    $r = mysqli_query($link, $q);

    if (mysqli_num_rows($r) > 0) {
        # Display TV show section.
        echo '
        <div class="container mt-5">
            <h2 class="text-center mb-4">TV Shows</h2>
            <div id="tvshow-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">';

        $i = 0;
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            if ($i % 4 == 0) {
                if ($i == 0) {
                    echo '<div class="carousel-item active"><div class="row">';
                } else {
                    echo '</div></div>
					<div class="carousel-item">
						<div class="row">';
				}
			}
			echo '
				<div class="col-md-3 d-flex justify-content-center">
					<div class="card" style="width: 18rem;">
						<div class="card text-center">
							<img src="' . $row['img'] . '" alt="TV Show" class="img-thumbnail bg-secondary">
							<h5 class="card-title">' . $row['tvshow_title'] . '</h5>
							<a href="tvshow_info.php?id=' . $row['id'] . '" class="btn btn-secondary btn-block" role="button">
							Watch Preview
							</a>
						</div>
					</div>
				</div>
			';
        $i++;
		}

    echo '</div></div>';
    echo '
            <a class="carousel-control-prev" href="#tvshow-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#tvshow-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>';
} else {
    echo '<p>No TV shows found.</p>';
}

# Close database connection.
mysqli_close($link);

} else {
	echo '<p>No movies found.</p>';
}
# Display footer section.
include('includes/footer.html');
?>