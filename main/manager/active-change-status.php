<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE tbl_services SET status=? WHERE serviceid=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['serviceid']));

	header('location: manage_services.php');
?>