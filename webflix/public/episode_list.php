<?php
# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require('login_tools.php');
    load();
}

# Adds nav bar & bootstrap css
include('includes/logout.html');

# Open database connection.
require('connect_db.php');

// Get the episodes from the database
$id = $_GET['id']; // Get the ID of the TV show from the query string
$query = "SELECT * FROM `webflix_episodes` WHERE `id` = $id ORDER BY `season_number`, `episode_number`";
$result = mysqli_query($link, $query);
if (!$result) {
  die('Could not get episodes from the database: ' . mysqli_error($link));
}

// Group the episodes by season
$seasons = array();
while ($row = mysqli_fetch_assoc($result)) {
  $season_number = $row['season_number'];
  if (!isset($seasons[$season_number])) {
    $seasons[$season_number] = array();
  }
  $seasons[$season_number][] = $row;
}

// Display the episodes
echo '<head>
		<!-- Custom CSS -->
		<link rel="stylesheet" type="text/css" href="includes/cinema_style.css">
	</head>
	<div class="container">
	<h1>Episodes</h1>';
foreach ($seasons as $season_number => $episodes) {
  echo '<h2>Season ' . $season_number . '</h2>
		<div class="row">';
  foreach ($episodes as $episode) {
    echo '<div class="col-md-3 d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <div class="card text-center">
					<h5 class="card-title">' . $episode['episode_title'] . '</h5>
					<p class="card-text">Season ' . $episode['season_number'] . ', Episode ' . $episode['episode_number'] . '</p>
					<a href="watch_tvshow.php?episode_id=' . $episode['episode_id'] . '" class="btn btn-secondary">Watch Now</a>
				</div>
			</div>
		</div>';
  }
  echo '</div><hr>';
}

// Close the database connection
mysqli_close($link);

echo '</div></div>';

# Display footer section.
include('includes/footer.html');
?>
