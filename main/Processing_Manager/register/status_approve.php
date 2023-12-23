<?php require_once('header.php'); ?>


<?php
	$statement = $pdo->prepare("UPDATE requests_material SET prodstats=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location: finished.php');
?>