<?php require_once('header.php'); ?>

<

<?php
	$statement = $pdo->prepare("UPDATE tbl_tender_application SET payment_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	header('location: mytenders.php');
?>