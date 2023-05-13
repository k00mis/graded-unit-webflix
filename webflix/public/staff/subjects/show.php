<?php require_once('../../../private/initialise.php'); ?>

<?php
// Get global ID variable and assign to local $id variable
// If global id is not set, turnary operator defaults $id to 1
$id = $_GET['id'] ?? '1'; // This turnary operator is new as of PHP 7
?>

<?php $page_title = 'Show Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
	<a class="back-link" href="<?php echo url_for('/staff/subjects/index.php');
	?>">&laquo; Back to List</a>

	<div class="subject show">
		Subject ID: <?php echo h($id); ?>
	</div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>