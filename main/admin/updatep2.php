<?php
require_once('header1.php');

$p_name = $_GET['p_name'];

// Update the status of the request

$statement = $pdo->prepare("UPDATE requestsproduct SET status=? WHERE p_name=?");
$statement->execute(array($_REQUEST['task'],$_REQUEST['p_name']));

// Get the request details
$stat = $pdo->prepare("SELECT * FROM requestsproduct WHERE p_name=?");
$stat->execute(array($p_name));
$request = $stat->fetch(PDO::FETCH_ASSOC);
if (!$request) {
    die('Request not found');
}

// Check if the product already exists in the store
$up = $pdo->prepare("SELECT * FROM tbl_material WHERE p_name=?");
$up->execute(array($p_name));
$product = $up->fetch(PDO::FETCH_ASSOC);

if ($product) {
    // Product exists, update the quantity
    $p_qty = $product['qty'] + $request['quantity'];
    $up = $pdo->prepare("UPDATE tbl_material SET qty=? WHERE p_name=?");
    $up->execute(array($p_qty, $p_name));
} else {
    // Product doesn't exist, insert a new row
	$insert = $pdo->prepare("INSERT INTO tbl_material ( p_name, qty,supplier) VALUES ( ?, ?,?)");
	$insert->execute(array( $p_name, $request['quantity'], $request['supplier']));
	
}

header('Location: productsupplies.php');
