<?php

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

// Fetch data from tbl_bank
$statementBank = $pdo->prepare("SELECT * FROM tbl_bank");
$statementBank->execute();
$resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    // Your form submission logic
    $id = $_POST["id"];
    $orderid = $_POST["order_id"];
    $customer_id = $_POST["customer_id"];
    $customer_name = $_POST["customer_fullName"];
    $product = $_POST["product"];
    $quantity_requested = $_POST["quantity"]; // New input field for quantity
    $date = $_POST["date"];
    $technician_name = $_POST['technicianname'];
    $technician_phone = $_POST['technicianphone'];
    $technician_email = $_POST['technicianemail'];
    $availableQuantity = isset($_POST['available_quantity']) ? $_POST['available_quantity'] : 0;

    if ($quantity_requested > $availableQuantity) {
        echo '<div class="alert alert-danger">Quantity requested is greater than available quantity!</div>';
    } else {

        // Insert query using prepared statement
        $insertQry = "INSERT INTO tbl_requestedmaterials (orderid,customer_id, customer_name, date, Materials, quantity,technician_name,technician_phone,technician_email) VALUES (?, ?, ?, ?, ?,?,?,?,?)";
        $insertStatement = $pdo->prepare($insertQry);

        // Execute the prepared statement
        $insertResult = $insertStatement->execute([$orderid, $customer_id, $customer_name, $date, $product, $quantity_requested, $technician_name, $technician_phone, $technician_email]);

        if (!$insertResult) {
            echo "ERROR updating tbl_payment: " . implode(" ", $insertStatement->errorInfo());
        } else {
            // Reduce the quantity in tbl_toolbox
            $updateToolboxQry = "UPDATE tbl_material SET qty = qty - ? WHERE p_name = ?";
            $updateToolboxStatement = $pdo->prepare($updateToolboxQry);
            $updateToolboxResult = $updateToolboxStatement->execute([$quantity_requested, $product]);

            if (!$updateToolboxResult) {
                echo "ERROR updating tbl_toolbox: " . implode(" ", $updateToolboxStatement->errorInfo());
            } else {
                echo '<div class="alert alert-success">Material Successfully Requested!</div>';
            }
        }
        $statement = $pdo->prepare("UPDATE tbl_payment SET materials=? WHERE id=?");
        $statement->execute(array($_REQUEST['task'], $_REQUEST['id']));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../icofont/icofont.min.css">

</head>

<body>

    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <center>
                        <h5 class="page-header">Request Materials </h5>
                    </center>

                </div><br>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <?php
                                    $id = $_GET['id'];
                                    $qry = "SELECT * FROM tbl_payment WHERE id=?";
                                    $statement = $pdo->prepare($qry);
                                    $statement->execute([$id]);
                                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <form role="form" action="" method="post">
                                        <div class="form-group">
                                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                                            <label>Customer Name</label>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
                                            $statement1->execute(array($row['customer_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                            }
                                            ?>
                                            <input class="form-control" type="text" readonly name="customer_fullName" value='<?php echo $row1['cust_name'] . " " . $row1['cust_lname']; ?>' required>
                                        </div>
                                        </br>
                                        <div class="form-group">

                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_staff WHERE full_name=?");
                                            $statement1->execute(array($row['technician']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                            }
                                            ?>
                                            <label>Technician details</label>
                                            <input class="form-control" type="text" readonly name="technicianname" value='<?php echo $row1['full_name']; ?>' required>
                                            <input class="form-control" type="text" readonly name="technicianphone" value='<?php echo $row1['phone']; ?>' required>
                                            <input class="form-control" type="text" readonly name="technicianemail" value='<?php echo $row1['email']; ?>' required>
                                        </div><br>

                                        <label for=""><?php echo "AVAILABLE PRODUCTS " ?> *</label>
                                        <select name="product" id="productDropdown" class="form-control select2" onchange="updateQuantity()">
                                            <option value=""><?php echo "SELECT" ?></option>
                                            <?php
                                            // Fetch data from tbl_bank
                                            $statementBank = $pdo->prepare("SELECT * FROM  tbl_material");
                                            $statementBank->execute();
                                            $resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

                                            // Display options based on the fetched data
                                            foreach ($resultBank as $bank) {
                                                echo '<option value="' . $bank['p_name'] . '">' . $bank['p_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="form-group">
                                            <label for="">Available Product Quantity </label>
                                            <input class="form-control" type="text" readonly name="available quantity" id="quantityTextbox" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Insert Quantity* </label>
                                            <input class="form-control" type="text" name="quantity" required>
                                        </div>

                                        </br>
                                        <div class="form-group">
                                            <label for="">Date of Request* </label>
                                            <input class="form-control" type="date" name="date" required>
                                        </div>

                                        <!-- id hidden grna input type ma "hidden" -->
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                        <div class="btn btn-float-right"> <a class="btn  btn-warning" href="orderallocations.php?dashboard">Back</a></div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script>
        function updateQuantity() {
            var dropdown = document.getElementById("productDropdown");
            var quantityTextbox = document.getElementById("quantityTextbox");

            // Get the selected product from the dropdown
            var selectedProduct = dropdown.value;

            // Make an AJAX request to get the quantity
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update the quantity textbox with the response
                    quantityTextbox.value = xhr.responseText;
                }
            };

            // Send a GET request to a PHP script that fetches the quantity based on the selected product
            xhr.open("GET", "get_quantity.php?product=" + selectedProduct, true);
            xhr.send();
        }
    </script>
</body>

<style>
    footer {
        background-color: #424558;
        bottom: 0;
        left: 0;
        right: 0;
        height: 35px;
        text-align: center;
        color: #CCC;
    }

    footer p {
        padding: 10.5px;
        margin: 0px;
        line-height: 100%;
    }
</style>

</html>