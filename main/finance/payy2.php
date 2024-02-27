<?php require_once('header.php') ?>


<div id="wrapper">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h5 class="page-header">MAKE PAYMENT</h5>
                <?php
                if (isset($_POST['send2'])) {

                    include 'dbconnect.php';
                    function test_input($data)
                    {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }
                    $id = $_POST["id"];
                    $payStatus = $_POST["payStatus"];
                    $bankinfo = $_POST["Bank_List"];
                    $bankname = $_POST["Bank"];

                    $Ref = test_input($_POST['Ref']);
                    $per = 'M1OPQRST6U8V2X3ABCDEFG45NYZ7W9HIJ0KL';
                    $newS = substr(str_shuffle($per), 0, 8);

                    $naming = "/^(?=.*[A-Z])(?=.*[0-9])/";

                    if (!preg_match($naming, $Ref)) {
                        $error = "Please Enter a valid MPESA ID";
                        header("Refresh:0.05; url=bookin_pay_error.php");
                    } else {
                        //update query
                        $qry = "update requestsproduct set payStatus='$payStatus',bank='$bankname',bankinfo='$bankinfo',Ref='$Ref' where id='$id'";
                        $result = mysqli_query($conn, $qry); //query executes

                        if (!$result) {
                            echo "ERROR" . mysqli_error();
                        } else {
                            echo '<div class="alert alert-success">payment made successfully!</div>';
                        }
                    }
                }
                ?>
                <a class="btn btn-sm btn-warning" href="productpayment.php">Back</a>
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
                                include 'dbconnect.php';
                                $id = $_GET['id'];
                                $qry = "SELECT * FROM requestsproduct WHERE id='$id'";

                                $result = mysqli_query($conn, $qry);
                                while ($row = mysqli_fetch_array($result)) {

                                ?>
                                    <form role="form" action="#" method="post">
                                        <input class="form-control" type="text" name="payStatus" readonly value="Paid" required>


                                        <label>Total Amount</label>
                                        <input class="form-control" type="text" readonly value="<?php echo $row['charges'] * $row['quantity']; ?>" required>
                                        <br>
                                        <label for=""><?php echo "BANK " ?> *</label>
                                        <select name="Bank_List" class="form-control select2" id="advFieldsStatus">
                                            <option value=""><?php echo "choose any bank" ?></option>

                                            <?php
                                            // Fetch data from tbl_bank
                                            $statementBank = $pdo->prepare("SELECT * FROM tbl_supplierbank");
                                            $statementBank->execute();
                                            $resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

                                            // Display options based on the fetched data
                                            foreach ($resultBank as $bank) {
                                                $optionValue = $bank['BankName'] . ' - ' . $bank['BankAccountNumber'];
                                                echo '<option value="' . $optionValue . '">' . $optionValue . '</option>';
                                            }
                                            ?>
                                        </select><br>
                                        <label for=""><?php echo "BANK NAME " ?> *</label>
                                        <select name="Bank" class="form-control select2" id="advFieldsStatus">
                                            <option value=""><?php echo "SELECT" ?></option>

                                            <?php
                                            // Fetch data from tbl_bank
                                            $statementBank = $pdo->prepare("SELECT * FROM tbl_supplierbank");
                                            $statementBank->execute();
                                            $resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

                                            // Display options based on the fetched data
                                            foreach ($resultBank as $bank) {
                                                echo '<option value="' . $bank['BankName'] . '">' . $bank['BankName'] . '</option>';
                                            }
                                            ?>
                                        </select>

                                        <div class="form-group">
                                            <label>BANK CODE Number</label>
                                            <input type="text" minlength="10" maxlength="10" name="Ref" class="form-control" required>
                                        </div>



                                        <!-- id hidden grna input type ma "hidden" -->


                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">





                                        <button type="submit" name="send2" class="btn btn-success">Submit</button>
                                    </form>
                            </div>
                        <?php
                                }
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