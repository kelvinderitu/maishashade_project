<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE tbl_payment SET technician_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location:orderallocations.php');
?>