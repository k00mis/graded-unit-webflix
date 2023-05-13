<?php 

// This function ensures that URLs go to the right place
function url_for($script_path) {
	// add the leading '/' if not present
	if($script_path[0] != '/') {
		$script_path = "/" . $script_path;
	}
	// WWW_ROOT is an absolute point that we can 
	// base all of our URLS off of
	return WWW_ROOT . $script_path;
}

// This function encodes reserved characters to ensure
// the URL query string (i.e. the part after the "?") works correctly
function u($string=""){
	return urlencode($string);
}

// This function encodes reserved characters to ensure
// the URL path (i.e. the part before "?" works correctly
function raw_u($string=""){
	return rawurlencode($string);
}	
	
// This function prevents cross-site scripting 
// by encoding special reserved HTML characters <, >, &, and "
// Use this whenever data comes from the user, database, cookies, etc.
// anywhere with dynamic data
function h($string=""){
	return htmlspecialchars($string);
}

function error_404() {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	// Can render my own custom 404 page here if I want to
	exit();
}

function error_500() {
	header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
	// Can render my own 500 page here if I want to
	exit();
}

// This function redirects the page to a different page
function redirect_to($location) {
	header("Location: " . $location);
	exit;
}

// Checks if a POST request was made, returns true or false
function is_post_request() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// Checks if a GET request was made, returns true or false
function is_get_request() {
	return $_SERVER['REQUEST_METHOD'] == 'GET';
}

?>