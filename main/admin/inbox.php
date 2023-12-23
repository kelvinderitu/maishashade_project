<?php
session_start();
error_reporting(0);
include('config1.php');
if(strlen($_SESSION['user'])=='0')
    {   
header('location:index.php');
}
else{ 

// code for block student    
if(isset($_GET['inid']))
{
$eventid=$_GET['inid'];
$Status=0;
$sql = "update events set status=:status  WHERE eventid=:eventid";
$query = $dbh->prepare($sql);
$query -> bindParam(':eventid',$eventid, PDO::PARAM_STR);
$query -> bindParam(':status',$Status, PDO::PARAM_STR);
$query -> execute();
header('location:manageevents.php');
}



//code for active students
if(isset($_GET['eventid']))
{
$eventid=$_GET['eventid'];
$Status=1;
$sql = "update events set status=:status  WHERE eventid=:eventid";
$query = $dbh->prepare($sql);
$query -> bindParam(':eventid',$eventid, PDO::PARAM_STR);
$query -> bindParam(':status',$Status, PDO::PARAM_STR);
$query -> execute();
header('location:manageevents.php');
}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kenya Clay Products</title>
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
                <h4 > <font color="green">Messages</font></h4>
                
    </div>
  
        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
   <button class="btn btn-sm btn-info"> <a href="send-message.php"><font color="white"><i class="fa fa-edit"></i>&nbsp;New</font></a></button>&nbsp;

                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><font color='green'>Message</font></th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from tbmessages where recepient='inventory' or sender='inventory manager'";
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
                                            <td class="center"><b>Message :</b><?php echo htmlentities($result->message);?><br>
                                            <b>Sender :</b><?php echo htmlentities($result->sender);?><br>
                                            <b>Date :</b><?php echo htmlentities($result->date);?><br>
                                        </td>
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-info"> <a href="index.php"><font color="white"><i class="fa fa-arrow-left"></i>&nbsp;Back</font></a></button>&nbsp;

                        </div>
                    </div>
                    <!--End Advanced Tables -->
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
