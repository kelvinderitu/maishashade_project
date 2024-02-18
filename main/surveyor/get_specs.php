<?php

$host = 'localhost';
$dbname = 'nyabondobricks';
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
    $selectedProduct = $_GET['product'];

    $statement = $pdo->prepare("SELECT p_name, specs FROM tbl_material WHERE p_name = ?");
    $statement->execute([$selectedProduct]);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        echo 'p_name: ' . $result['p_name'] . ', specs: ' . $result['specs'] . '<br>';
    }
} else {
    echo 'Invalid request';
}
?>
