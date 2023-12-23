<?php
include('connection.php');
session_start();

$q1=mysqli_query($conn,"select * from tbl_payment where id='id'");
$r1=mysqli_fetch_assoc($q1);

error_reporting(0);
include('config.php');
if(isset($_POST['submit']))
  {


$id=$_POST['id'];
$driver_allocated=$_POST['driver_allocated'];


$sql="UPDATE tbl_payment set driver_allocated='$driver_allocated' where id='$id' ";
$query = $dbh->prepare($sql);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->bindParam(':driver_allocated',$driver_allocated,PDO::PARAM_STR);


$query->execute();
$lastInsertid = $dbh->lastInsertid();
if($lastInsertid)
{
$msg="Allocation Has Been Made Successfully....";
}
else 
{
$msg="Allocation Successfull";
}


  }

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Basket Kenya</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/modern-business.css" rel="stylesheet">
    <style>
    .navbar-toggler {
        z-index: 1;
    }
    
    @media (max-width: 576px) {
        nav > .container {
            width: 100%;
        }
    }
    </style>
        <style>
    .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
    </style>


</head>

<body>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h5 class="mt-4 mb-3">ASSIGN DRIVER :</h5>

            <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>MESSAGE</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        <!-- Content Row -->
        <form name="donar" method="post">

<div class="card bg-default">
<div class="col-lg-8 mb-8">
<div class="font-italic">Customer<span style="color:red">*</span></div>

                              <select name="customer_name" onchange="showLoanDetails(this.value)" class="form-control" required>
                              <option value="">Select Customer</option>
                              <?php
                              $q1=mysqli_query($conn," select * from tbl_payment");
                              while($r1=mysqli_fetch_assoc($q1))
                              {
                              echo "<option value='".$r1['customer_name']."'>".$r1['customer_name']."</option>";
                              }
                              ?>
                              </select>
                              </div>

                              <div class="col-lg-4 mb-4">
                              <div class="font-italic">Driver<span style="color:red">*</span></div>

                              <select name="driver_allocated" onchange="showLoanDetails(this.value)" class="form-control" required>
                              <option value="">Select</option>
                              <?php
                              $q1=mysqli_query($conn,"SELECT * from tbl_staff  where role='driver' and  status='1' ");
                              while($r1=mysqli_fetch_assoc($q1))
                              {
                              echo "<option value='".$r1['full_name']."'>".$r1['full_name']."</option>";
                              }
                              ?>
                              </select>
                              </div>
                              <center>
                              <div class="form-group">
                                  <input type="submit" name="submit" value="Allocate Driver" class="btn btn-primary pull-right">
          </div></center>



</div>



        <!-- /.row -->
</form>   
   <br><center> 
<div class="col-md-">
<a class="btn btn-sm btn-secondary  btn-raised" href="../dispatch/index.php"> Back</a>
            </div>  </center>  <!-- /.row -->
</div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/tether/tether.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
