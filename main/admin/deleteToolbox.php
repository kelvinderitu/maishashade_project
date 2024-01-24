<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nyabondobricks";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    
    $delete_query = "DELETE FROM tbl_toolbox WHERE id='$id'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        $response['status'] = 'success';
        $response['message'] = 'Record deleted successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error deleting record: ' . $conn->error;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$conn->close();

?>
