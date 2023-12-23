l<?php
session_start();
error_reporting(0);
include('inc/config1.php');


// code for block student    
if(isset($_GET['inserviceid']))
{
$serviceid=$_GET['inserviceid'];
$status=0;
$sql = "update dance_services set status=:status  WHERE serviceid=:serviceid";
$query = $dbh->prepare($sql);
$query -> bindParam(':serviceid',$serviceid, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:manage_dance_services.php');
}



//code for active students
if(isset($_GET['serviceid']))
{
$serviceid=$_GET['serviceid'];
$status=1;
$sql = "update dance_services set status=:status  WHERE serviceid=:serviceid";
$query = $dbh->prepare($sql);
$query -> bindParam(':serviceid',$serviceid, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
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
    <title></title>
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
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <center><h4 > <font color="red">TRAINING RECORDS</font></h4></center>
                  
    </div>
    <div class="container">
</div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
              
                        <div class="panel-body">  <a href="../dashboard.php"><button class="btn btn-danger btn-sm">Back</button></a><br><br>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><font color="green">Sevice Name</font></th>
                                            <th><font color="green">Customer Name</font></th>
                                            <th><font color="green">Date Booked</font></th>
                                            <th><font color="green">Payment Details</font></th>
                                            <th><font color="green">Booked On</font></th>   
                                            <th><font color="green">Location Details</font></th>  
                                            <th><font color="green">Trainer Assigned </font></th>  
                                            <th><font color="green">Report</font></th> 
                                        </tr>
                                    </thead>
                                    <tbody>

<?php   
$id=$_GET['id'];      
$sql = "SELECT * FROM `tbl_bookings` ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>                                     
                                            <td class="center"><?php echo htmlentities($result->service);?></td>
                                            <td class="center">
                                                <?php echo htmlentities($result->full_name);?>  <?php echo htmlentities($result->l_name);?><br>
                                            <td class="center"><?php echo htmlentities($result->eventdate);?></td>
                                            <td class="center">
                                                <b>Charges :</b>Ksh:&nbsp;<?php echo htmlentities($result->pricing);?><br>
                                                <b>Transaction Code :</b>&nbsp;<?php echo htmlentities($result->transactioncode);?> <br>
                                                <b>Paid On :</b>&nbsp;<?php echo htmlentities($result->pdate);?><br>
                                                <b>Payment Status :</b>&nbsp;<?php echo htmlentities($result->payment_status);?><br>
                                            </td>
                                            <td class="center"><?php echo htmlentities($result->bdate);?></td>
                                            <td class="center">
                                                <b>County Name :</b><?php echo htmlentities($result->country_name);?><br>
                                                <b>Location Details :</b><?php echo htmlentities($result->location);?>
                                        </td>
                                            <td class="center"><?php echo htmlentities($result->photographer);?></td>
                                          
                                            <td>
                                        <?php echo htmlentities($result->recommandation);?><br>
                                        
                        </td>
                                           </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
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
<?php  ?>
