<?php 

require_once('../../../private/initialise.php');

// If no ID is set, do not show this page, get redirected instead
if(!isset($_GET['id'])) {
	redirect_to(url_for('/staff/pages/index.php'));
}

$menu_name = '';
$position = '';
$visible = '';

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
}
?>

<!-- Form below -->
<?php $page_title = 'Edit Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
	<a class="back-link" href="<?php echo
	url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>
	
	<div class="page edit">
		<h1>Edit Page</h1>
		
		<form action="<?php echo url_for('/staff/pages/edit.php?id=' .
		h(u($id))); ?>" method="post">
			<dl> <!-- stands for "data list"-->
				<dt>Menu Name</dt> <!-- stands for "data terms"-->
				<dd><input type="text" name="menu_name" value="<?php echo
				h($menu_name); ?>" /></dd> <!-- stands for "data definition"-->
			</dl>
			<dl>
				<dt>Position</dt>
				<dd>
					<select name="position">
						<option value="1"><?php if(position == "1") { echo " selected";
						} ?>1</option>
					</select>
				</dd>
			</dl>
			<dl>
				<dt>Visible</dt>
				<dd>
					<input type="hidden" name="visible" value="0" />
					<input type="checkbox" name="visible" value="1"<?php if($visible
					== "1") { echo " checked";} ?> />
				</dd>
			</dl>
			<div id="operations">
				<input type="submit" value="Create Subject" />
			</div>
		</form>
	</div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>