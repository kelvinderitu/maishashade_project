<?php require_once('header.php'); ?>



<?php
	// Getting photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_toolbox WHERE toolbox_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		
	}

	


	// Delete from tbl_photo
	$statement = $pdo->prepare("DELETE FROM tbl_toolbox WHERE toolbox_id=?");
	$statement->execute(array($_REQUEST['id']));

	

	header('location: toolbox.php');
?>