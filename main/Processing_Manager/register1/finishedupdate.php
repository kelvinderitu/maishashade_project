<?php
require_once('header1.php');

$CATEGID = $_GET['CATEGID'];

// Update the status of the request

$statement = $pdo->prepare("UPDATE requests_material SET prodstats=? WHERE CATEGID=?");
$statement->execute(array($_REQUEST['task'],$_REQUEST['CATEGID']));

// Get the request details
$stat = $pdo->prepare("SELECT * FROM requests_material WHERE CATEGID=?");
$stat->execute(array($CATEGID));
$request = $stat->fetch(PDO::FETCH_ASSOC);
if (!$request) {
    die('Request not found');
}

// Check if the product already exists in the tblproduct
$up = $pdo->prepare("SELECT * FROM tblproduct WHERE CATEGID=?");
$up->execute(array($CATEGID));
$product = $up->fetch(PDO::FETCH_ASSOC);

if ($product) {
    // Product exists, update the bags
    $PROQTY = $product['PROQTY'] + $request['bags'];
    $up = $pdo->prepare("UPDATE tblproduct SET PROQTY=? WHERE CATEGID=?");
    $up->execute(array($PROQTY, $CATEGID));
} else {
    // Product doesn't exist, insert a new row
	$insert = $pdo->prepare("INSERT INTO tblproduct ( CATEGID, PROQTY,supplier) VALUES ( ?, ?,?)");
	$insert->execute(array( $CATEGID, $request['bags'], $request['supplier']));
	
}

header('Location: finished.php');
