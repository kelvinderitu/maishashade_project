<?php
session_start();
error_reporting(0);
include('config1.php');
require_once('header1.php');
if (strlen($_SESSION['login_username']) == 0) {
    header('location:index.php');
} else {

    // code for block student    
    if (isset($_GET['incust_id'])) {
        $cust_id = $_GET['incust_id'];
        $cust_status = 2;
        $sql = "update tbl_customer set cust_status=:cust_status  WHERE cust_id=:cust_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cust_id', $cust_id, PDO::PARAM_STR);
        $query->bindParam(':cust_status', $cust_status, PDO::PARAM_STR);
        $query->execute();
        header('location:approvedcustomer.php');
    }



    //code for active students
    if (isset($_GET['cust_id'])) {
        $cust_id = $_GET['cust_id'];
        $cust_status = 1;
        $sql = "update tbl_customer set cust_status=:cust_status  WHERE cust_id=:cust_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cust_id', $cust_id, PDO::PARAM_STR);
        $query->bindParam(':cust_status', $cust_status, PDO::PARAM_STR);
        $query->execute();
        header('location:approvedcustomer.php');
    }


?>

    <body>
        <!------MENU SECTION START-->

        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4>
                            <font color="black">
                                <center>APPROVED CUSTOMERS REGISTRATION</center>
                            </font>
                        </h4>

                    </div>
                    <div class="container">
                        <button id="printButton" onclick="printPage()">
                            <font color="black"><i class="fa fa-print"></i>&nbsp;GENERATE REPORT</font>
                        </button>
                        <style>
                            .button-container {
                                display: inline-block;
                                margin-right: 20px;
                                /* Adjust the margin as needed */
                            }

                            #printButton {
                                float: right;
                            }
                        </style>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">

                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>
                                                    <font color="green">Full Name</font>
                                                </th>
                                                <th>
                                                    <font color="green">Gender</font>
                                                </th>
                                                <th>
                                                    <font color="green">Phone</font>
                                                </th>
                                                <th>
                                                    <font color="green">Email</font>
                                                </th>
                                                <th>
                                                    <font color="blue">Status</font>
                                                </th>
                                                <th>
                                                    <font color="blue">Action</font>
                                                </th>
                                                

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sql = "SELECT * from tbl_customer where cust_status='1'";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {               ?>
                                                    <tr class="odd gradeX">
                                                        <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->cust_name . ' ' . $result->cust_lname); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->cust_cname); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->cust_phone); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->cust_email); ?></td>
                                                        <td style="background-color:yellow;" class="center"><?php if ($result->cust_status == 1) {
                                                                                                                echo htmlentities("Active");
                                                                                                            } else {


                                                                                                                echo htmlentities("Pending");
                                                                                                            }
                                                                                                            ?></td>
                                                        <td class="center">
                                                            <?php if ($result->cust_status == 1) { ?>
                                                                <a href="approvedcustomer.php?incust_id=<?php echo htmlentities($result->cust_id); ?>"> <button class="btn btn-danger btn-sm"> Deactivate</button>
                                                                <?php } else { ?>

                                                                    <a href="approvedcustomer.php?cust_id=<?php echo htmlentities($result->cust_id); ?>"><button class="btn btn-primary btn-sm"> Approve</button>
                                                                    <?php } ?>

                                                        </td>
                                                        
                                                    </tr>
                                            <?php $cnt = $cnt + 1;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <button class="btn btn-warning"><a href="dashboard.php">
                                        <font color="black"><i class="fa fa-arrow-left"></i>&nbsp;Back</font>
                                    </a></button>
                            </div>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                </div>



            </div>
            <div class="col-md-12">

            </div>
        </div>


    </body>

    </html>
<?php } ?>
<script>
    function printPage() {
        window.print();
    }
</script>