<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE tbl_specialorders SET shipping_status=?,order_status='Order Completed' WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location: completedspecialorders.php');
?>