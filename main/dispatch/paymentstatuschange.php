<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE tbl_bookings SET payment_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));	

	header('location: approvedservicepayment.php');
?>