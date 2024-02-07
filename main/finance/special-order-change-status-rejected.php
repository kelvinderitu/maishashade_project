<?php require_once('header.php'); ?>

<?php
if( !isset($_REQUEST['id']) || !isset($_REQUEST['task']) ) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_specialorders WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	$statement = $pdo->prepare("UPDATE tbl_specialorders SET order_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));
    $statement = $pdo->prepare("UPDATE tbl_specialorders SET payment_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task2'],$_REQUEST['id']));


	header('location: pendingspecialorders.php');
?>