<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE tbl_bookings SET supervisor_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location: Request2.php');
?>