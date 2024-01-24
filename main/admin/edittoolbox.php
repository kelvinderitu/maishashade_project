<?php
$error_message = '';
$success_message = '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=nyabondobricks", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

function getByID($table, $id, $pdo)
{
    $query = "SELECT * FROM $table WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['form1'])) {
    $toolbox_id = $_POST['id'];
    $toolbox_type = $_POST['toolbox_type'];
    $quantity = $_POST['quantity'];

    try {
        $update_toolbox_query = "UPDATE tbl_toolbox SET toolbox_type=?, quantity=? WHERE id=?";
        $stmt = $pdo->prepare($update_toolbox_query);

        $stmt->execute([$toolbox_type, $quantity, $toolbox_id]);

        // Redirect to the appropriate page after successful update

    } catch (PDOException $e) {
        echo "Error updating toolbox details: " . $e->getMessage();
    }
}
?>