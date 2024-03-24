<?php
require_once('header.php');
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
    // Your form submission logi
    $id = $_POST["id"];
    $shippingfee = $_POST['shippingfee'];
    $productfee = $_POST['productfee'];
    $servicefee = $_POST['servicefee'];
    $financeupdatedate = $_POST['financeupdatedate'];
    
  
    

    // Update query using prepared statement
    $updateQry = "UPDATE tbl_specialorders SET  shipping_fee=?,productfee=?, servicefee=?,finance_update_date=?  WHERE id=?";
    $updateStatement = $pdo->prepare($updateQry);

    // Execute the prepared statement
    $updateResult = $updateStatement->execute([$shippingfee,$productfee,$servicefee,$financeupdatedate, $id]);

    if (!$updateResult) {
        echo "ERROR" . implode(" ", $updateStatement->errorInfo());
    } else {
        echo '<div class="alert alert-success">Payment details updated successfully!</div>';
        header("location: specialorder.php");

    }
    $statement = $pdo->prepare("UPDATE tbl_specialorders SET order_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));
}




?>


<div id="wrapper">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <CENTER>
                    <h5 class="page-header">UPDATING PAYMENT ON SPECIAL ORDERS </h5>
                </CENTER>
                <a class="btn btn-sm btn-warning" href="specialorder.php?dashboard">Back</a>
            </div><br>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">

                                <?php
                                $id = $_GET['id'];
                                $qry = "SELECT * FROM tbl_specialorders WHERE id=?";
                                $statement = $pdo->prepare($qry);
                                $statement->execute([$id]);
                                $row = $statement->fetch(PDO::FETCH_ASSOC);

                                ?>
                                <form role="form" action="" method="post">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <input class="form-control" type="text" readonly name="customer_fullName" value='<?php echo $row['customer_fullName']; ?>' required>
                                    </div>
                                    <div class="form-group">
                                        <label>County</label>
                                        <input class="form-control" type="text" readonly name="county" value='<?php echo $row['county']; ?>' required>
                                    </div>
                                    <div class="form-group">
                                        <label>Shipping fee</label>
                                        <input class="form-control" type="text" name="shippingfee" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Product Fee</label>
                                        <input class="form-control" type="text" name="productfee" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Service fee</label>
                                        <input class="form-control" type="text"  name="servicefee" required>
                                    </div>


                                    <div class="form-group">
                                        <label>Payment Date</label>
                                        <input class="form-control" type="date" name="financeupdatedate" required>
                                    </div>


                                    <!-- id hidden grna input type ma "hidden" -->
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
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