<?php
// Your existing PHP code for database connection and other functionalities
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nyabondobricks";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array(); // Initialize response array

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Update the record in the database
    $id = $_POST["id"];
    $name = $_POST["toolbox_type"];
    $quantity = $_POST["quantity"];

    $sql = "UPDATE tbl_toolbox SET toolbox_type='$name', quantity='$quantity' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Record updated successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error updating record: ' . $conn->error;
    }

    // Output the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); // Make sure to exit to prevent further output
} else {
    // Output a response indicating that the update request was not received
    $response['status'] = 'error';
    $response['message'] = 'Update request not received';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Close the database connection
$conn->close();
?>

<!-- Display an alert using PHP -->
<script>
    <?php if ($response['status'] === 'success'): ?>
        alert('<?php echo $response['message']; ?>');
    <?php else: ?>
        alert('Error: <?php echo $response['message']; ?>');
    <?php endif; ?>
</script>
