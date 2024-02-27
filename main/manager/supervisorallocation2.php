<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> </title>

    <!-- Bootstrap Core CSS -->
    <link href="inc/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="inc/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="inc/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../icofont/icofont.min.css">

    <style>
        .form-group select {
            max-width: 100%;
        }
    </style>


</head>

<body>



    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">ASSIGN SUPERVISOR</h3>
                    <?php

                    include 'dbconnect.php';
                    if (isset($_POST['supervisorbtn'])) {
                        $id = $_POST["id"];
                        $customer_name = $_POST["customer_name"];
                        $supervisor = $_POST["supervisor"];
                        $order_status = $_POST["order_status"];
                        //update query
                        $qry = "update tbl_specialorders set id='$id', customer_fullName='$customer_name', supervisor='$supervisor',order_status='$order_status' where id='$id'";
                        $result = mysqli_query($conn, $qry); //query executes

                        if (!$result) {
                            echo "ERROR" . mysqli_error();
                        } else {
                        
                            echo '<div class="alert alert-success">Supervisor successfully assigned!</div>';
                        }
                    }


                    ?>
                    <a class="btn btn-info" href="pendingspecialorders.php">Back</a>
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
                                    $qry = "SELECT * FROM tbl_specialorders where id='$id'
";
                                    $result = mysqli_query($conn, $qry);
                                    while ($row = mysqli_fetch_array($result)) {

                                    ?>
                                        <form role="form" action="#" method="post">

                                            <input class="form-control" readonly name="order_status" type="hidden" value='Goods On Transit' required>
                                            <input class="form-control" readonly name="id" type="hidden" value='<?php echo $row['id']; ?>' required>
                                            <input class="form-control" type="hidden" readonly name="customer_name" value='<?php echo $row['customer_fullName']; ?>' required>


                                            <div class="form-group">
                                                <div class="font-italic">SUPERVISOR<span style="color:red">*</span></div>

                                                <select name="supervisor" onchange="showLoanDetails(this.value)" class="form-control" required>
                                                    <option value="">Select</option>
                                                    <?php
                                                    $q1 = mysqli_query($conn, "SELECT * from tbl_staff  where role='supervisor' and  status='1' ");
                                                    while ($r1 = mysqli_fetch_assoc($q1)) {
                                                        echo "<option value='" . $r1['full_name'] . "'>" . $r1['full_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <!-- id hidden grna input type ma "hidden" -->


                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">





                                            <button type="submit" class="btn btn-success" name="supervisorbtn">Submit</button>
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
    <script src="inc/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="inc/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="inc/vendor/metisMenu/metisMenu.min.js"></script>

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