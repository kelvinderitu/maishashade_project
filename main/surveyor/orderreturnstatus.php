<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE tbl_payment SET technician_return=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location: completeordersallocations.php');
?>