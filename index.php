<!doctype html>

<?php 
	require_once "config.php";
?>

<html>
<?php 
	include "head.php";
?>

<body>
	<?php
	include 'navigation.php';
	include 'main.php';
	include 'offer.php';
	include 'tickets.php';
	include 'schedule.php';
	include 'gallery.php';
	include 'footer.php';
	?>
</body>
</html>
<?php
	mysqli_close($link);
?>