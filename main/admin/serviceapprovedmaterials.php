<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("UPDATE tbl_requestedservicematerials SET status=? WHERE id=?");
$statement->execute(array($_REQUEST['task'], $_REQUEST['id']));

header("location:servicematerials.php");


?>