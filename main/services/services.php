<?php
session_start();
error_reporting(0);
include('inc/config1.php');
if (strlen($_SESSION['user']['id']) == 0) {
    header('location:index.php');
} else {

    // code for block student    
    if (isset($_GET['inserviceid'])) {
        $serviceid = $_GET['inserviceid'];
        $status = 0;
        $sql = "update dance_services set status=:status  WHERE serviceid=:serviceid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':serviceid', $serviceid, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:manage_dance_services.php');
    }



    //code for active students
    if (isset($_GET['serviceid'])) {
        $serviceid = $_GET['serviceid'];
        $status = 1;
        $sql = "update dance_services set status=:status  WHERE serviceid=:serviceid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':serviceid', $serviceid, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:manage_dance_services.php');
    }


?>
    <!DOCTYPE html>
<html lang="en">

<head>

	<!-- Meta Tags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/uploads/<?php echo $favicon; ?>">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="assets/css/owl.theme.success.min.css">
	<link rel="stylesheet" href="assets/css/jquery.bxslider.min.css">
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<link rel="stylesheet" href="assets/css/rating.css">
	<link rel="stylesheet" href="assets/css/spacing.css">
	<link rel="stylesheet" href="assets/css/bootstrap-touch-slider.css">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/tree-menu.css">
	<link rel="stylesheet" href="assets/css/select2.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/responsive.css">

    </head>

    <body>
        <!------MENU SECTION START-->

        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <center>
                            <h4>
                                <font color="green"><b>OUR SERVICES</b></font>
                            </h4>
                        </center>

                    </div>
                    <!--<div class="container">
    <center><button class="btn  btn-primary"><a href="book.php"><font color="white"><i class="fa fa-book"></i>&nbsp;Book Now</font></a></button></center>
</div>-->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>
                                                    <font color="green">Sevice Name</font>
                                                </th>
                                                <th>
                                                    <font color="green">Pricing</font>
                                                </th>
                                                <th>
                                                    <font color="green">Description</font>
                                                </th>
                                                <th>
                                                    <font color="green">Duration</font>
                                                </th>
                                                <th>
                                                    <font color="green">Action</font>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $serviceid = $_GET['serviceid'];
                                            $sql = "SELECT *FROM tbl_services  ";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {               ?>
                                                    <tr class="odd gradeX">
                                                        <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->servicename); ?></td>
                                                        <td class="center">Ksh&nbsp;<?php echo htmlentities($result->pricing); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->description); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->duration); ?></td>
                                                        <td class="center">
                                                            <a href="booknow.php?serviceid=<?php echo htmlentities($result->serviceid); ?>" class="btn btn-primary btn-md">Book Now</a>
                                                        </td>
                                                    </tr>
                                            <?php $cnt = $cnt + 1;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-sm btn-default"><a href="../supplier/index.php">
                                        <font color="black">Back</font>
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

        <!-- CONTENT-WRAPPER SECTION END-->

        <!-- FOOTER SECTION END-->
        <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <!-- CORE JQUERY  -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS  -->
        <script src="assets/js/bootstrap.js"></script>
        <!-- DATATABLE SCRIPTS  -->
        <script src="assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <!-- CUSTOM SCRIPTS  -->
        <script src="assets/js/custom.js"></script>

    </body>

    </html>
<?php } ?>