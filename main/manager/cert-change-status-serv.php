<?php require_once('header.php'); ?>

<

<?php
	$statement = $pdo->prepare("UPDATE tbl_bookings SET cert=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location:submittedquotation_serv.php');
?>