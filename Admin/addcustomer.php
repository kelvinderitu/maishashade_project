<?php
session_start();
error_reporting(0);
include('config.php');
if(strlen($_SESSION['login_username'])=="0")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['submit']))
{
$cust_name=$_POST['cust_name'];
$cust_email=$_POST['cust_email']; 
$cust_cname=$_POST['cust_cname']; 
$cust_address=$_POST['cust_address']; 
$cust_phone=$_POST['cust_phone']; 
$cust_password=$_POST['cust_password'];
$cust_status=1;
$sql="INSERT INTO  tbl_customer(cust_name,cust_email,cust_cname,cust_address,cust_phone,cust_password,cust_status) VALUES(:cust_name,:cust_email,:cust_cname,:cust_address,:cust_phone,:cust_password,:cust_status)";
$query = $dbh->prepare($sql);
$query->bindParam(':cust_name',$cust_name,PDO::PARAM_STR);
$query->bindParam(':cust_email',$cust_email,PDO::PARAM_STR);
$query->bindParam(':cust_cname',$cust_cname,PDO::PARAM_STR);
$query->bindParam(':cust_address',$cust_address,PDO::PARAM_STR);
$query->bindParam(':cust_phone',$cust_phone,PDO::PARAM_STR);
$query->bindParam(':cust_password',$cust_password,PDO::PARAM_STR);
$query->bindParam(':cust_status',$cust_status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Customer Added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kenya Clay Products  </title>
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
                                <br>
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-12">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Back</a></li>
                                
                                        <li class="active"></li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="card">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                   <center> <h4><b>New Customer :</b></h4></center>
                                                </div>
                                            </div>
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
<label for="default" class="col-sm-2 control-label">Customer Name</label>
<div class="col-sm-8">
<input type="text" name="cust_name" class="form-control" id="cust_name" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Email </label>
<div class="col-sm-8">
<input type="email" name="cust_email" class="form-control" id="cust_email" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Address</label>
<div class="col-sm-8">
<input type="text" name="cust_address" class="form-control" id="cust_address" required="required" autocomplete="off">
</div>
</div>



<div class="form-group">
<label for="default" class="col-sm-2 control-label">Gender</label>
<div class="col-sm-8">
<input type="radio" name="cust_cname" value="Male" required="required" checked="">Male <input type="radio" name="cust_cname" value="Female" required="required">Female <input type="radio" name="cust_cname" value="Other" required="required">Other
</div>
</div>

<div class="form-group">
                                <label for="date" class="col-sm-2 control-label">Phone Number</label>
                                                        <div class="col-sm-8">
                                                            <input type="tel"  name="cust_phone" class="form-control" minlength="10" id="cust_phone" >
                                                        </div>
                                                    </div>
                   
                                                    <div class="form-group">
<label for="default" class="col-sm-2 control-label">Password</label>
<div class="col-sm-8">
<input type="password" name="cust_password" class="form-control" id="cust_password"  required="required" autocomplete="off">
</div>
</div>

                
<input type="hidden"  name="role" class="form-control"  id="role" value="customer" >
                                                  
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-8">
                                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
<?PHP } ?>
