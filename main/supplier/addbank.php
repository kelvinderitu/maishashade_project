<?php require_once('header.php'); ?>
<?php
if (isset($_POST['submit2'])) {

    $host = "localhost";
    $dbname = "maishashades";
    $username = "root";
    $password = "";

    // Create a connection to the database
    $conn = new mysqli($host, $username, $password, $dbname);


    $Bank_Name = $_POST["BankName"];
    $BankAccount = $_POST['BankNumber'];

    //update query
    $sql = "INSERT INTO tbl_supplierbank (BankName, BankAccountNumber) VALUES (?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("si", $Bank_Name, $BankAccount);

    // Execute the prepared statement
    if ($stmt->execute()) {
        header('Location: supplierbank.php'); // Move the header() here
        exit(); // Add exit() to stop script execution
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<div id="wrapper">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h5 class="page-header">Add Bank Details</h5>
                <h6>
                    <div class="col-md-12 form-group">


                    </div>
                </h6>



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




                                <form role="form" action="#" method="post">


                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <input class="form-control" type="text" name="BankName" required>
                                    </div>


                                    <div class="form-group">
                                        <label>Bank Account Number</label>
                                        <input class="form-control" type="text" name="BankNumber" required>
                                    </div>


                                    <!-- id hidden grna input type ma "hidden" -->



                                    <div class="clearfix">
                                        <button type="submit" class="btn btn-success float-left" name="submit2">Submit</button>
                                        <a class="btn btn-warning float-right" name="float-end-right" href="supplierbank.php">Back</a>
                                    </div>






                                </form>

                            </div>

                            <?php

                            ?>

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