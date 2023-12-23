<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kenya Clay Products </title>

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
                    <h3 class="page-header">Supply Products</h3>
                    <a class="btn btn-info" href="pending_payments.php">Back</a>
                </div><br>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                      
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                
                                <?php
include 'dbconnect.php';
$id=$_GET['id'];
$qry= "SELECT * FROM tbl_tender_application where id='$id'
"; 
$result=mysqli_query($conn,$qry);
while($row=mysqli_fetch_array($result)){
    
?>                                    
                                    <form role="form" action="postsupply.php" method="post">
                                     
                                        
                                    <input class="form-control"  type="hidden" readonly name="status" value='Supplied' required>
                                        <div class="form-group">
                                            <label>SUPPLY NAME</label>
                                            <input class="form-control" readonly  name="subject" value='<?php echo $row['subject']; ?>' required>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>PRODUCT NAME</label>
                                            <input class="form-control" readonly  name="product_name" value='<?php echo $row['product_name']; ?>' required>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>QUANTITY (In Tonnes)</label>
                                            <input class="form-control" readonly  name="quantity" value='<?php echo $row['quantity']; ?>' required>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>PRICE PER UNIT</label>
                                            <input class="form-control"  type="number" readonly name="price" value='<?php echo $row['price']; ?>' required>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>TOTAL PRICE</label>
                                            <input class="form-control"  type="number" readonly name="total_amount" value='<?php echo $row['total_amount']; ?>' required>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>COMMENT</label>
                                            <textarea name="comment" class="form-control" cols="30" rows="10" style="width:100%;height: 200px;"></textarea>
                                            
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
    <script src="inc/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="inc/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="inc/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

<footer>
        <p>&copy; <?php echo date("Y"); ?>: Kenya Clay Products</p>
    </footer>
	
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