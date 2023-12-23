<?php
session_start();
error_reporting(0);
include('config.php');
// code for block student    
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$inventoryStatus=Approved;
$sql = "update requests_material set inventoryStatus=:inventoryStatus  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':inventoryStatus',$inventoryStatus, PDO::PARAM_STR);
$query -> execute();
header('location:managerrequest.php');
}



//code for active students
if(isset($_GET['id']))
{
$id=$_GET['id'];
$inventoryStatus=Approved;
$sql = "update requests_material set inventoryStatus=:inventoryStatus  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':inventoryStatus',$inventoryStatus, PDO::PARAM_STR);
$query -> execute();
header('location:managerrequest.php');
}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mamba</title>
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
                <h4 > <font color="black">PRODUCTION MANAGER REQUEST(s) :</font></h4>
                  
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
                                            <th><font color="green">Variety Name</font></th>
                                            <th><font color="green">Requested Quantity (Kgs)</font></th>
                                            <th><font color="green">In Stock (Kgs)</font></th>
                                            <th><font color="green">Date</font></th>
                                            <th><font color="green">Status</font></th>
                                            <th><font color="green">Remark</font></th>
                                            <th><font color="green">Action</font></th>
                                        </tr>
                                    </thead>
                                    <tbody

<?php                                      $sql = "SELECT *FROM  `requests_material` r,`store` s where r.`varietyName`=s.`varietyName` ";
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
                                            <td class="center"><?php echo htmlentities($result->varietyName);?></td>
                                            <td class="center"><?php echo htmlentities($result->quantity);?></td>
                                            <td class="center"><?php echo htmlentities($result->qty);?></td>
                                            <td class="center"><?php echo htmlentities($result->date_created);?></td>
                                            <td class="center"><?php echo htmlentities($result->inventoryStatus);?></td>  
                                            <td class="center"><?php echo htmlentities($result->specs);?></td> 
                                            <td class="center">
                                            <?php
                                if($result->inventoryStatus=='Approved'){
                                    ?>
                                   <a href="release.php?varietyName=<?php echo $result->varietyName; ?>&task=Released" class="btn btn-warning btn-sm" >Release</a>
                                    <?php
                                }
                            ?>
                                         <?php
                                if($result->inventoryStatus=='Pending'){
                                    ?>
                                   <a href="releasepro.php?varietyName=<?php echo $result->varietyName; ?>&task=Approved" class="btn btn-success btn-sm" >Approve</a>
                                    <?php
                                }
                            ?>
                                     
                                     
                                           
                                        </td> 
                                 
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-primary"><a href="../index.php?dashboard"><font color="white">Back</font></a></button>
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
