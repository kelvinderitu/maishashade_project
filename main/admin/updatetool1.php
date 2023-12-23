<?php
require_once('header.php');

// Check if 'p_name' is set in the GET parameters
if (!isset($_GET['toolbox_name'])) {
    die('Invalid request');
}

$toolbox_name = $_GET['toolbox_name'];

// Update the status of the request
$statement = $pdo->prepare("UPDATE tbl_request_toolbox SET status=? WHERE toolbox_name=?");
$statement->execute(array($_REQUEST['task'], $toolbox_name));

// Get the request details
$stat = $pdo->prepare("SELECT * FROM tbl_request_toolbox WHERE toolbox_name=?");
$stat->execute(array($toolbox_name));
$request = $stat->fetch(PDO::FETCH_ASSOC);

// Check if the request exists
if (!$request) {
    die('Request not found');
}

// Update the quantity of toolboxes in tbl_request_toolbox
$updateToolbox = $pdo->prepare("UPDATE tbl_request_toolbox SET quantity = quantity - 1 WHERE toolbox_name = ?");
$updateToolbox->execute(array($toolbox_name));

// Redirect to the instock.php page
header('Location: instock.php');

