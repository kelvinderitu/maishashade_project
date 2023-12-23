<?php
require_once('header1.php');

$varietyName = $_GET['varietyName'];

// Update the status of the request

$statement = $pdo->prepare("UPDATE requestsproduct SET status=? WHERE varietyName=?");
$statement->execute(array($_REQUEST['task'],$_REQUEST['varietyName']));

// Get the request details
$stat = $pdo->prepare("SELECT * FROM requestsproduct WHERE varietyName=?");
$stat->execute(array($varietyName));
$request = $stat->fetch(PDO::FETCH_ASSOC);
if (!$request) {
    die('Request not found');
}

// Check if the product already exists in the store
$up = $pdo->prepare("SELECT * FROM store WHERE varietyName=?");
$up->execute(array($varietyName));
$product = $up->fetch(PDO::FETCH_ASSOC);

if ($product) {
    // Product exists, update the quantity
    $qty = $product['qty'] + $request['quantity'];
    $up = $pdo->prepare("UPDATE store SET qty=? WHERE varietyName=?");
    $up->execute(array($qty, $varietyName));
} else {
    // Product doesn't exist, insert a new row
	$insert = $pdo->prepare("INSERT INTO store ( varietyName, qty,supplier) VALUES ( ?, ?,?)");
	$insert->execute(array( $varietyName, $request['quantity'], $request['supplier']));
	
}

header('Location: productsupplies.php');
