<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Service Manager module</title>

    <!-- Bootstrap Core CSS -->
    <link href="inc/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="inc/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="inc/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../icofont/icofont.min.css">

</head>

<body>



    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                   <center> <h3 class="page-header">EDIT SERVICES</h3></center>
                    <a class="btn btn-default" href="manage_services.php">Back</a>
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
$serviceid=$_GET['serviceid'];
$qry= "SELECT * FROM tbl_services where serviceid='$serviceid'
"; 
$result=mysqli_query($conn,$qry);
while($row=mysqli_fetch_array($result)){
    
?>                                    
                                    <form role="form" action="serviceedit.php" method="post">
                                     
                                        
                                            <input class="form-control"  name="room_id" type="hidden" value='<?php echo $row['room_id']; ?>' >
                                         
                                        <div class="form-group">
                                            <label>Service Name</label>
                                            <input class="form-control"  name="servicename" value='<?php echo $row['servicename']; ?>' >
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>Charges</label>
                                            <input class="form-control" type="number"  name="pricing" value='<?php echo $row['pricing']; ?>' >
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input class="form-control" type="text"  name="description" value='<?php echo $row['description']; ?>' >
                                        </div>

                                        <div class="form-group">
                                            <label>Duration</label>
                                            <select name="duration" class="form-control">
    <option>Select Duration</option>
    <option value="One Week">One Week</option>
    <option value="Two Weeks">Two Weeks</option>
    <option value="Three weeks">Three Weeks</option>
</select>
                                        </div>

                                       
                                       
                       <!-- id hidden grna input type ma "hidden" -->
                      
                                          
    <input type="hidden" name="serviceid" value="<?php echo $row['serviceid'];?>">              
                                    
                                
                                        
                
                                    
                                    <button type="submit" class="btn btn-success">Update</button>
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
    <script src="inc/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="inc/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="inc/vendor/metisMenu/metisMenu.min.js"></script>

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