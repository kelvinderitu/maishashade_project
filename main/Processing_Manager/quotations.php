<?php
include('connection.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../icofont/icofont.min.css">

</head>

<body>



    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="page-header">BUILDING QUOTATION DETAILS</h5>
                    <a class="btn btn-sm btn-warning" href="beneficiary-list.php?dashboard">Back</a>
                </div><br>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                
                                <?php
include 'dbconnect.php';
$id=$_GET['id'];
$qry= "SELECT * FROM tbl_bookings WHERE id='$id'
"; 
$result=mysqli_query($conn,$qry);
while($row=mysqli_fetch_array($result)){
    
?>                                    
                                    <form role="form" action="edit.php" method="post">
                                     
                                        
                                        <div class="form-group">
                                            <label>Customer Name</label>
                                            <input class="form-control" type="text" readonly name="sponsor" value='<?php echo $row['full_name']; ?>' required>
                                        </div>
                                        <div class="form-group">
                                            <label>Customer Email</label>
                                            <input class="form-control" type="text" readonly name="sponsor" value='<?php echo $row['email']; ?>' required>
                                        </div>
                                        <div class="form-group">
                                            <label>Customer Phone</label>
                                            <input class="form-control" type="text" readonly name="sponsor" value='<?php echo $row['phone']; ?>' required>
                                        </div><hr>
                                        <div class="form-group">
                                            <label>Land Size (Square Metre)</label>
                                            <input class="form-control" type="text" required name="landsize" >
                                        </div>
                                        <input class="form-control" type="hidden" readonly name="photographer_status" value='Delivered' required>
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input class="form-control" type="text" readonly name="location" value='<?php echo $row['location']; ?>' required>
                                        </div>
                                        <div class="form-group">
                                            <label>Building Style</label>
                                            <input class="form-control" type="text"  name="style"  required>
                                        </div>
                                        <div class="form-group">
                                            <label>Number of Floors</label>
                                            <input class="form-control" type="number"  name="floors" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Permit Cost</label>
                                            <input class="form-control" type="number"  name="permit"  required>
                                        </div>
                                        <div class="form-group">
                                            <label>Materials Cost </label>
                                            <input class="form-control" type="number"  name="materialcost"  required>
                                        </div>
                                        <div class="form-group">
                                            <label>Labour Cost </label>
                                            <input class="form-control" type="number"  name="labourcost" required>
                                        </div>
                                     
                                        

                                       
                                       
                       <!-- id hidden grna input type ma "hidden" -->
                      
                                     
    <input type="hidden" name="id" value="<?php echo $row['id'];?>">              
                                    
                                
                                        
                
                                    
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    </form>
                                </div>
    <?php
}
?>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

	
	<style>
	footer{
   background-color: #424558;
    bottom: 0;
    left: 0;
    right: 0;
    height: 35px;
    text-align: center;
    color: #CCC;
}

footer p {
    padding: 10.5px;
    margin: 0px;
    line-height: 100%;
}
	</style>

</html>