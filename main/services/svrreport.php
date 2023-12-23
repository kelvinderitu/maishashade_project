l<?php
session_start();
error_reporting(0);
include('inc/config1.php');



    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Nyabondo Bricks</title>
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
        
<center><h2>NYABONDO BRICKS</h2>
		<h4>CUSTOMER SITE ANALYSIS REPORT</h4>
        <h5>
			Po Box 64-40109 Sondu, <br>
			Kisumu, Kenya<br>
			Phone: +254 057 7016805<br>
			Email: nyabondobricks@gmail.com</h5>
</center>
                  
    </div>
    <div class="container">
</div>
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
                                            <th><font color="green">Sevice Name</font></th>
                                            <th><font color="green">Date Booked</font></th>
                                            <th><font color="green">Payment Details</font></th>
                                            <th><font color="green">Booked On</font></th>   
                                            <th><font color="green">Location Details</font></th>  
                                            <th><font color="green">Surveyor Allocated </font></th>  
                                            <th><font color="green">Engineer Allocated</font></th>  
                                            <th><font color="green">Customer Remark</font></th>  
                                            <th><font color="green">Service Status</font></th> 
                                            <th><font color="green">Quotation Report</font></th> 
                                            <th><font color="green">Action</font></th> 
                                        </tr>
                                    </thead>
                                    <tbody>

<?php   
$id=$_GET['id'];      
$sql = "SELECT * FROM tbl_bookings WHERE  photographer_status='Delivered' and repstats='Approved' and id='$id' and email='".$_SESSION['customer']['cust_email']."'";
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
                                            <td class="center"><?php echo htmlentities($result->servicename);?></td>
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
                                            <td class="center"><?php echo htmlentities($result->engineer);?></td>
                                            <td class="center"><?php echo htmlentities($result->cust_remark);?></td>
                                            <td class="center">
                                            <?php if($result->landsize!='0')
 {?>
<a href="custquotreport.php?id=<?php echo htmlentities($result->id);?>"  >  <button class="btn btn-success btn-sm"> View Report</button>
<?php } else {?>
  
    <?php } ?>

    <?php if($result->lndsize!='0')
 {?>
<a href="custquotreport_serv.php?id=<?php echo htmlentities($result->id);?>"  >  <button class="btn btn-success btn-sm"> View Report</button>
<?php } else {?>
  
    <?php } ?>
                                             </td>
                                            <td class="center">
                                                <?php echo htmlentities($result->photographer_status);?>
                                            </td>
                                            <td class="center">
<?php if($result->transactioncode=='')
 {?>
<a href="paynow.php?id=<?php echo htmlentities($result->id);?>"  >  <button class="btn btn-success btn-sm"> Pay Now</button>
<?php } else {?>
  
    <?php } ?><br><br>
    <?php if($result->transactioncode!=='')
 {?>
<a href="mybookings-receipt.php?id=<?php echo htmlentities($result->id);?>"  >  <button class="btn btn-info btn-sm"> Receipt</button>
<?php } else {?>
  
    <?php } ?><br><br>
    <?php if($result->cust_remark=='')   
    if($result->transactioncode!=='')
    if($result->photographer_status=='Delivered')
 {?>
<a href="addremark.php?id=<?php echo htmlentities($result->id);?>"  >  <button class="btn btn-warning btn-sm"> Add Remark</button>
<?php } else {?>
  
    <?php } ?>
                                          
                                            </td>
                                           </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-default"><a href="../index.php"><font color="black">Back</font></a></button>
                         
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
