<?php
require_once('header1.php');

$p_name = $_GET['p_name'];


// Update the status of the request

$statement = $pdo->prepare("UPDATE requests_material SET inventoryStatus=? WHERE p_name=?");
$statement->execute(array($_REQUEST['task'],$_REQUEST['p_name']));

// Get the request details
$stat = $pdo->prepare("SELECT * FROM requests_material WHERE p_name=?");
$stat->execute(array($p_name));
$request = $stat->fetch(PDO::FETCH_ASSOC);
if (!$request) {
    die('Request not found');
}

// Check if the product already exists in the store
$up = $pdo->prepare("SELECT * FROM tbl_product WHERE p_name=?");
$up->execute(array($p_name));
$product = $up->fetch(PDO::FETCH_ASSOC);

if ($product) {
    // Product exists, update the quantity
    $p_qty = $product['p_qty'] + $request['quantity'];
    $up = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_name=?");
    $up->execute(array($p_qty, $p_name));
} else {
    // Product doesn't exist, insert a new row
	$insert = $pdo->prepare("INSERT INTO tbl_product ( p_name, p_qty) VALUES ( ?,?)");
	$insert->execute(array( $p_name, $request['quantity']));
	
}

header('Location: finished.php');
