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
    

    // Get all materials with the same name but different specs
    $statement = $pdo->prepare("SELECT id, specs, qty FROM tbl_material WHERE p_name = ?");
    $statement->execute([$selectedProduct]);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Prepare an array to store individual details
    $detailsArray = array();

    // Iterate through the results and add each set of details to the array
    foreach ($results as $result) {
        $detailsArray[] = array('id' => $result['id'], 'quantity' => $result['qty'], 'specs' => $result['specs']);
    }

    // Return the JSON-encoded array
    echo json_encode($detailsArray);
} else {
    echo 'Invalid request';
}
?>
