<?php require_once('../../../private/initialise.php'); ?>

<?php
	$subjects = [
		['id' => '1', 'position' => '1', 'visible' => '1', 'menu-name' => 'Movies'],
		['id' => '2', 'position' => '2', 'visible' => '2', 'menu-name' => 'TV Shows'],
		['id' => '3', 'position' => '3', 'visible' => '3', 'menu-name' => 'Documentaries'],
	];
?>

<?php $page_title = 'Subjects'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>		
	
	<div id="content">
		<div class="subjects listing">
			<h1>Subjects</h1>
			
			<div class="actions">
				<a class="action" href="<?php echo url_for('/staff/subjects/new.php');
				?>">Create New Subject</a>
			</div>
			
			<table class="list">
				<tr>
					<th>ID</th>
					<th>Position</th>
					<th>Visible</th>
					<th>Name</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
				
				<?php foreach($subjects as $subject) { ?>
					<tr>
						<td><?php echo h($subject['id']); ?></td>
						<td><?php echo h($subject['position']); ?></td>
						<td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
						<td><?php echo h($subject['menu-name']); ?></td>
						<td><a class="action" href="<?php echo 
						url_for('/staff/subjects/show.php?id=' . h(u($subject['id'])));
						?>">View</a></td>
						<td><a class="action" href="<?php echo 
						url_for('/staff/subjects/edit.php?id=' . h(u($subject['id'])));
						?>">Edit</a></td>
						<td><a class="action" href="">Delete</a></td>
					</tr>
				<?php } ?> 
			</table>
		</div>
	</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>