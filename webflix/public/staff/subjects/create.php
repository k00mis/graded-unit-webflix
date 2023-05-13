<?php 

require_once('../../../private/initialise.php');

// if a POST request is made, display the parameters
if(is_post_request()){

	// Handle form values sent by new.php
	$menu_name = $_POST['menu_name'] ?? '';
	$position = $_POST['position'] ?? '';
	$visible = $_POST['visible'] ?? '';
	
	echo "Form parameters<br />";
	echo "Menu name: " . $menu_name . "<br />";
	echo "Position: " . $position . "<br />";
	echo "Visible: " . $visible . "<br />";
} else {
	// if no POST request is made, redirect back to the form
	redirect_to(url_for('/staff/subjects/new.php'));
}
?>