<?php require_once('header.php'); ?>

<?php
// Your existing PHP code for database connection and other functionalities
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maishashades";

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
}

// Handle delete request
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

// Retrieve data in ascending order by id using MySQLi
$result = $conn->query("SELECT * FROM tbl_toolbox ORDER BY id ASC");

// Your other existing PHP code

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toolbox Management</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-success">
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Quantity </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td>
                                            <input type="text" id="toolbox_type_<?php echo $row['id']; ?>" value="<?php echo $row['id'] ? $row['toolbox_type'] : ''; ?> " class=form-control no-border>
                                        </td>

                                        <td>
                                            <input type="text" id="quantity_<?php echo $row['id']; ?>" value="<?php echo $row['quantity']; ?>" class=form-control no-border>
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-xs" onclick="editRecord(<?php echo $row['id']; ?>)">Update</button>
                                            <button class="btn btn-danger btn-xs" name = "delete" >Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        // Function to handle inline editing
        function editRecord(id) {
            // Get the values from the input fields
            var toolboxType = $('#toolbox_type_' + id).val();
            var quantity = $('#quantity_' + id).val();

            // Make an AJAX call to update the record
            $.ajax({
                type: 'POST',
                url: 'toolboxEdit.php',
                data: {
                    update: true,
                    id: id,
                    toolbox_type: toolboxType,
                    quantity: quantity
                },
                success: function(response) {
                    // Check the response status
                    if (response.status === 'success') {
                        // Record updated successfully, display an alert
                        alert(response.message);
                        location.reload(); // Reload the page to reflect the changes
                    } else {
                        // Error occurred, you can display an alert or handle it accordingly
                        console.error(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error: ' + textStatus, errorThrown);
                },
                dataType: 'json' // Expect JSON response
            });
        }

       
    </script>


</body>
<?php require_once('footer.php'); ?>
