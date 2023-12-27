<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MAISHA CAR PARKING SHADES AND CARPORTS</title>

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


    <br>
    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="page-header">Payment Section</h5>

                    <h5 class="page-header">EQUITY ACCOUNT NUMBER</h5>
                    <h5 class="page-header">0650181029646</h5>
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
                                    if (isset($_POST['submit2'])) {
                                        include 'dbconnect.php';
                                        function test_input($data)
                                        {
                                            $data = trim($data);
                                            $data = stripslashes($data);
                                            $data = htmlspecialchars($data);
                                            return $data;
                                        }
                                        $id = $_POST["id"];
                                        $total = $_POST["total"];
                                        $transactioncode = test_input($_POST['transactioncode']);
                                        $per = 'M1OPQRST6U8V2X3ABCDEFG45NYZ7W9HIJ0KL';
                                        $newS = substr(str_shuffle($per), 0, 8);

                                        $naming = "/^(?=.*[A-Z])(?=.*[0-9])/";

                                        if (!preg_match($naming, $transactioncode)) {
                                            $error = "Please Enter a valid EQUITY BANK ACCOUNT NUMBER";
                                            header("Refresh:0.05; url=../bookin_pay_error.php");
                                        } else {
                                            //update query
                                            $qry = "update tbl_bookings set transactioncode='$transactioncode',total='$total' where id='$id'";
                                            $result = mysqli_query($conn, $qry); //query executes

                                            if (!$result) {
                                                echo "ERROR" . mysqli_error();
                                            } else {

                                                echo '<div class="alert alert-success">Payment made successfully!</div>';
                                            }
                                        }
                                    }
                                    ?>

                                    <?php
                                    include 'dbconnect.php';
                                    $id = $_GET['id'];
                                    $qry = "SELECT * FROM tbl_bookings WHERE id='$id'";
                                    $result = mysqli_query($conn, $qry);
                                    while ($row = mysqli_fetch_array($result)) {

                                    ?>
                                        <form role="form" action="#" method="post">
                                            <div class="form-group">
                                                <label>Total Amount</label>
                                                <input class="form-control" type="text" readonly name="total" value="<?php echo $row['charges'] + $row['fee']; ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Transaction Code</label>
                                                <input class="form-control" type="text" minlength="10" maxlength="10" name="transactioncode" required>
                                            </div>


                                            <!-- id hidden grna input type ma "hidden" -->


                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                            <div class="clearfix">
                                                <button type="submit" class="btn btn-success float-left" name="submit2">Submit</button>
                                                <a class="btn btn-warning float-right" name="float-end-right" href="mybookings.php?dashboard">Back</a>
                                            </div>






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