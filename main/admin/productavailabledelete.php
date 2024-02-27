<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_material WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
    

}

?>
<?php
	
	$statement = $pdo->prepare("DELETE FROM tbl_material WHERE id=?");
	$statement->execute(array($_REQUEST['id']));

	
	
    header('location: productavailable.php');
?>

