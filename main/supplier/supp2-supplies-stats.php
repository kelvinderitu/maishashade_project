<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE requestsproduct SET inventoryStatus=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location: tendarp.php');
?>