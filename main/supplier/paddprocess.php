

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
                  <center>  <h4 class="page-header"><a href="tendarp.php">Back</h4></center>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" action="#" method="post">

                                    <?php
include 'dbconnect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 

    // Sanitize and retrieve form data
    $charges = mysqli_real_escape_string($conn, $_POST['charges']);
    $id = $_POST['id'];

    // Retrieve the product price from the database
    $qry = "SELECT product_price FROM requestsproduct WHERE id='$id'";
    $result = mysqli_query($conn, $qry);

    // ...

// ..

if ($result) {
    $row = mysqli_fetch_array($result);
    $productPrice = $row['product_price'];

    // Check if the submitted price is not higher than the product price
    if ($charges <= $productPrice) {
        // Your database insert/update query here

        // For example, if you want to update the 'price' column in 'requestsproduct' table:
        $updateQuery = "UPDATE requestsproduct SET charges='$charges' WHERE id='$id'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            echo "Price updated successfully.";
            // Redirect back to the previous page or a success page
            header("Location: tendarp.php");
            exit();
        } else {
            echo "Error updating price: " . mysqli_error($conn);
            // You might want to redirect back to the form page or handle the error appropriately
        }
    } else {
        // If the submitted price is higher than the product price, display an error message
        echo "Error: Price cannot be higher than the product price.";
        // You might want to redirect back to the form page or handle the error appropriately
    }
} else {
    // Handle the case where the product is not found in the database
    echo "Error: Product not found.";
    // You might want to redirect back to the form page or handle the error appropriately
}

// ...

?>


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

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>


	
	<style>
	footer{
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
