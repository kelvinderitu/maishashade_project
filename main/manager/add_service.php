<?php
session_start();
error_reporting(0);
include('inc/config1.php');

if (strlen($_SESSION['user']['id']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['form1'])) {
        $servicename = $_POST['servicename'];
        $pricing = $_POST['pricing'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $status = 'Active'; // Enclosed in single quotes

        // Ensure you have a valid database connection here

        // Check if $dbh is a valid PDO database connection
        if (isset($dbh)) {
            $sql = "INSERT INTO tbl_services(servicename, pricing, description, duration, status) VALUES(:servicename, :pricing, :description, :duration, :status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':servicename', $servicename, PDO::PARAM_STR);
            $query->bindParam(':pricing', $pricing, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->bindParam(':duration', $duration, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $msg = "New Service added successfully";
            } else {
                $error = "Could Not Add data to the database";
            }
        }
    }
}
?>
<!-- The rest of your HTML and UI code -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Adding New Service </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->

            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h3 class="title"><font color="purple">ADD NEW SERVICE</font></h3>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                    <button class="btn btn-sm btn-info"><a href="manage_services.php"><font color="white">Back</font></a></button>
                                        <li class="active"></li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                    
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                          
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong></strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Error !!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-horizontal" method="post">



                                                <div class="form-group">
<label for="default" class="col-sm-2 control-label">Service Name</label>
<div class="col-sm-10">
<input type="text" name="servicename" class="form-control" id="servicename" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="shootdate" class="col-sm-2 control-label">Charges</label>
<div class="col-sm-10">
<input type="number" name="pricing" class="form-control" id="pricing" required>
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Description</label>
<div class="col-sm-10">
<textarea rows="10" cols="100" class="form-control" id="description" name="description"  maxlength="999" style="resize:none"></textarea>
</div>
</div>
<div class="form-group">
<label for="shootdate" class="col-sm-2 control-label">Duration</label>
<div class="col-sm-10">
<select name="duration" class="form-control">
    <option>Select Duration</option>
    <option value="One Week">One Week</option>
    <option value="Two Weeks">Two Weeks</option>
    <option value="Three Weeks">Three Weeks</option>
</select>
</div>
</div>
                                                <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" class="btn btn-success pull-left" name="form1">Add</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    </body>
</html>

