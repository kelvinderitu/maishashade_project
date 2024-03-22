<?php
// get_quantity.php

$host = 'localhost';
$dbname = 'maishashades';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

if (isset($_GET['product'])) {
    $product = $_GET['product'];

    // Fetch the quantity from the database based on the selected product
    $statement = $pdo->prepare("SELECT qty FROM tbl_material WHERE p_name = ?");
    $statement->execute([$product]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Return the quantity as the response
    echo $result['qty'];
} else {
    echo 'Invalid request';
}
?>
