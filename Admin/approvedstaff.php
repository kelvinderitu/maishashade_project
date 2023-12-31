<?php
session_start();
error_reporting(0);
include('config.php');
require_once('header1.php');
if (strlen($_SESSION['login_username']) == 0) {
    header('location:index.php');
} else {
    // code for block student    
    if (isset($_GET['inid'])) {
        $id = $_GET['inid'];
        $status = 2;
        $sql = "update tbl_staff set status=:status  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:approvedstaff.php');
    }

    //code for active students
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $status = 2;
        $sql = "update tbl_staff set status=:status  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:approvedstaff.php');
    }
?>

<body>
    <!------MENU SECTION START-->

    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <center>
                        <h4>
                            <font color="black">ACTIVE STAFF ACCOUNTS</font>
                        </h4>
                    </center>
                </div>
                <div class="container">
                    <button id="printButton" onclick="printPage()">
                        <font color="black"><i class="fa fa-print"></i>&nbsp;Generate report</font>
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
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><font color="green">Full Name</font></th>
                                            <th><font color="green">Designation</font></th>
                                            <th><font color="green">Phone</font></th>
                                            <th><font color="green">Email</font></th>
                                            <th><font color="blue">status</font></th>
                                            <th><font color="blue">Action</font></th>
                                            <th><font color="blue">Edit</font></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sql = "SELECT * from tbl_staff where status='1'  ";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->full_name); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->role); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->phone); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->email); ?></td>
                                                    <td style="background-color:yellow;" class="center">
                                                        <?php if ($result->status == 1) {
                                                            echo htmlentities("Active");
                                                        } else {
                                                            echo htmlentities("Pending");
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="center">
                                                        <?php if ($result->status == 1) { ?>
                                                            <a href="approvedstaff.php?inid=<?php echo htmlentities($result->id); ?>">
                                                                <button class="btn btn-danger btn-sm"> Deactivate</button>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a href="approvedstaff.php?id=<?php echo htmlentities($result->id); ?>">
                                                                <button class="btn btn-primary btn-sm"> Approve</button>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <a href="staff_profile_update.php?id=<?php echo htmlentities($result->id); ?>">
                                                            <button class="btn btn-primary btn-sm"> Edit</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php $cnt = $cnt + 1;
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-warning">
                                <a href="dashboard.php">
                                    <font color="black"><i class="fa fa-arrow-left"></i>&nbsp;Back</font>
                                </a>
                            </button>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
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