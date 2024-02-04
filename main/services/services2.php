<?php
session_start();
error_reporting(0);
include('inc/config1.php');
if (strlen($_SESSION['user']['id']) == 0) {
    header('location:index2.php');
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
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Maisha Shade Limited</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- DATATABLE STYLE  -->
        <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    </head>

    <body>
        <!------MENU SECTION START-->

        <!-- MENU SECTION END-->
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <center>
                            <h4> Request For An Order</h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="mb-0"> Customer full Name</label>
                                    <input type="text" required name="cust_name" placeholder="Enter Number of CarSpaces you May want" class="form-control mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0"> Customer email</label>
                                    <input type="text" required name="cust_email" placeholder="Enter Your Email" class="form-control mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0"> Customer phone number</label>
                                    <input type="text" required name="cust_phone" placeholder="Enter  Your Phone Number" class="form-control mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0"> County</label>
                                    <input type="text" required name="county" placeholder="Enter Your County" class="form-control mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label forclass="mb-0"> Specific Detailed Location</label>
                                    <textarea rows="3" columns="4" required name="location" placeholder="Enter  Specific Location Of the Installation Of the Material Requested" class="form-control mb-2"></textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="mb-0"> Number Of Carspaces</label>
                                    <input type="number" required name="carspaces" placeholder="Enter Number of CarSpaces " class="form-control mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label forclass="mb-0"> Description</label>
                                    <textarea rows="3" columns="4" required name="description" placeholder="Enter  Features of the shade i.e color" class="form-control mb-2"></textarea>
                                </div>



                                <div class="col-md-12">
                                    <label class="mb-0">Upload Image</label>
                                    <input type="file" required name="image" class="form-control mb-2"><br><br>
                                </div>
                                <br><br>






                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" name="add_product_btn">Save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
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