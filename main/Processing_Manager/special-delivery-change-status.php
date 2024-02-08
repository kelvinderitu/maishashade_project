<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE tbl_specialorders SET order_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));
    $statement = $pdo->prepare("UPDATE tbl_specialorders SET supervisor_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location: specialorders.php');
?>