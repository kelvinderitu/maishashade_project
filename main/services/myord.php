l<?php
session_start();
error_reporting(0);
include('inc/config1.php');
if(strlen($_SESSION['customer']['cust_id'])==0)
    {   
header('location:index.php');
}


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
         <center><h3> <font color="black">NYABONDO BRICKS</font></h3></center>
        <div class="row pad-botm">
            <div class="col-md-12">
                <center>
		<h4>CUSTOMER QUOTATION REPORT</h4>
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
                                            <th><font color="green">CUSTOMER DETAILS</font></th>
                                            <th><font color="green">SITE DETAILS</font></th>
                                            <th><font color="green">QUOTATIONS</font></th>
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
                                            <td class="center"> 
                                            <b>Name :</b>&nbsp;<?php echo htmlentities($result->full_name);?> <?php echo htmlentities($result->l_name);?><br>
                                            <b>Email :</b>&nbsp;<?php echo htmlentities($result->email);?><br>
                                        </td>
                                        <td>
                        <b>Location:</b><br> <?php echo htmlentities($result->location);?><br>
                        <b>Land Size:</b><br> <?php echo htmlentities($result->landsize);?> (Square Metres)<br>
                        <b>Building Style:</b><br> <?php echo htmlentities($result->style);?><br>
                        <b>No of Floors:</b><br> <?php echo htmlentities($result->floors);?><br>
                        </td>
                                 
                        <td>
                        <b>Permits Cost : </b>Ksh <?php echo htmlentities($result->permit);?><?php echo $row['permit']; ?><br>
                        <b>Material Cost:</b> Ksh <?php echo htmlentities($result->materialcost);?><br>
                        <b>Labour Cost:</b> Ksh <?php echo htmlentities($result->labourcost);?><br><br>
                        <b>ESTMATED TOTAL :</b> Ksh  <?php echo htmlentities($result->permit)+($result->materialcost)+($result->labourcost);?></b><br>
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
 
    
</body>

</html>
<?php  ?>
