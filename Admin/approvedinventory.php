<?php
session_start();
error_reporting(0);
include('config.php');
if(strlen($_SESSION['login_username'])==0)
    {   
header('location:index.php');
}
else{ 

// code for block student    
if(isset($_GET['instaff_id']))
{
$staff_id=$_GET['instaff_id'];
$status=2;
$sql = "update staff set status=:status  WHERE staff_id=:staff_id";
$query = $dbh->prepare($sql);
$query -> bindParam(':staff_id',$staff_id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:approvedinventory.php');
}



//code for active students
if(isset($_GET['staff_id']))
{
$staff_id=$_GET['staff_id'];
$status=2;
$sql = "update staff set status=:status  WHERE staff_id=:staff_id";
$query = $dbh->prepare($sql);
$query -> bindParam(':staff_id',$staff_id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:approvedinventory.php');
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
               <center> <h4 > <font color="black">ACTIVE  INVENTORY ACCOUNT:</font></h4></center>
                  
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
                                            <th><font color="green">First Name</font></th>
                                            <th><font color="green">Last Name</font></th>
                                            <th><font color="green">Address</font></th>
                                            <th><font color="green">Gender</font></th>
                                            <th><font color="green">Phone</font></th>
                                            <th><font color="green">Email</font></th>                                                                                                                                                                                   
                                            <th><font color="blue">status</font></th>
                                            <th><font color="blue">Action</font></th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from staff where status='1' and role='inventory' ";
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
                                            <td class="center"><?php echo htmlentities($result->first_name);?></td>    
                                            <td class="center"><?php echo htmlentities($result->last_name);?></td>  
                                            <td class="center"><?php echo htmlentities($result->city);?></td>  
                                            <td class="center"><?php echo htmlentities($result->gender);?></td>     
                                            <td class="center"><?php echo htmlentities($result->phone_number);?></td>   
                                            <td class="center"><?php echo htmlentities($result->email);?></td>                                                               
                                            <td style="background-color:yellow;"class="center"><?php if($result->status==1)
                                            {
                                                echo htmlentities("Active");
                                            } else {


                                            echo htmlentities("Pending");
}
                                            ?></td>
                                            <td class="center">
<?php if($result->status==1)
 {?>
<a href="approvedinventory.php?instaff_id=<?php echo htmlentities($result->staff_id);?>"  >  <button class="btn btn-danger btn-sm"> Deactivate</button>
<?php } else {?>

                                            <a href="approvedinventory.php?staff_id=<?php echo htmlentities($result->staff_id);?>" ><button class="btn btn-success btn-sm"> Activate</button> 
                                            <?php } ?>
                                          
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
