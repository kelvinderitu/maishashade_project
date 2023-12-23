<?php
session_start();
error_reporting(0);
require_once('header1.php');
include('config.php');



if (strlen($_SESSION['login_username']) == 0) {
    header('location:index.php');
} else {

    // code for block student    
    if (isset($_GET['inid'])) {
        $id = $_GET['inid'];
        $status = 1;
        $sql = "update tblcontactusquery set status=:status  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:managemessages.php');
    }



    //code for active students
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $status = 1;
        $sql = "update tblcontactusquery set status=:status  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:managemessages.php');
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
                            <font color="black"><center> MESSAGES </center> </font>
                        </h4>
                        <div class="container">
                            <button id="printButton" onclick="printPage()">
                                <font color="black"><i class="fa fa-print"></i>&nbsp; Generate Report</a></font>
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
                        <button class="btn btn-warning">
                            <a href="dashboard.php">
                                <font color="black"><i class="fa fa-arrow-left"></i>&nbsp;Back</font>
                            </a>
                        </button>

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
                                                    <font color="black">Sender </font>
                                                </th>
                                                <th>
                                                    <font color="black">Email</font>
                                                </th>
                                                <th>
                                                    <font color="black">Phone</font>
                                                </th>
                                                <th>
                                                    <font color="black">Message</font>
                                                </th>
                                                <th>
                                                    <font color="black">Date</font>
                                                </th>
                                                <th>
                                                    <font color="black">Status</font>
                                                </th>
                                                <th>
                                                    <font color="black">Action</font>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sql = "SELECT * from tblcontactusquery  ";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {               ?>
                                                    <tr class="odd gradeX">
                                                        <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->name); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->email); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->phone); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->Message); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->PostingDate); ?></td>
                                                        <td class="center"><?php if ($result->status == 1) {
                                                                                echo htmlentities("Read");
                                                                            } else {


                                                                                echo htmlentities("Unread");
                                                                            }
                                                                            ?></td>
                                                        <td class="center">
                                                            <?php if ($result->status == 0) { ?>
                                                                <a href="managemessages.php?inid=<?php echo htmlentities($result->id); ?>"> <button class="btn btn-success btn-sm"> Mark As Raed</button>
                                                                <?php }  ?>

                                                        </td>
                                                    </tr>
                                            <?php $cnt = $cnt + 1;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

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