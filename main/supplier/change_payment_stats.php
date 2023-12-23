<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE tbl_request_material SET payment_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location: pending_payments.php');
?>