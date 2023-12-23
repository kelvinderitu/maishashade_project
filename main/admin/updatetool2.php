
<?php

include("db_conect.php");
include("db_conection.php");
include('config.php');

{ 

    error_reporting(E_ERROR);
    if(isset($_POST['return'])){
   
    $identity=$_POST['identity'];
    $id=$_POST['id'];
    $p_name=$_POST['p_name'];
    $quantity=$_POST['quantity'];
    $p_qty=$_POST['p_qty'];
 
//product_cat,quantity,unit_price,newPricing

        $getter=mysqli_query($dbcon,"select p_name from tbl_product where p_name='$p_name'");
        $bbc=mysqli_num_rows($getter);
        if($bbc>0){
          $linker=mysqli_query($dbcon,"update tbl_product set p_qty = p_qty + $p_qty where p_name='$p_name'");
          if($linker)
          $con=mysqli_query($dbcon,"update tbl_completed_baskets set status='Confirmed' where id='$identity'");
          if($con)
          {
            $notify='message';
            $show='material quantity updated successfully';    
            header("Refresh:2; url = completed_baskets.php");
          }
       else{
            $notify='message';
            $show='check quantity .';
          }
        
        }
    }
    
    
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>basket kenya</title>
    <link rel="shortcut icon" href="assets/img/logo.jpg" type="image/x-icon" />
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="asset/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="asset/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="asset/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    
    <script src="asset/js/custom-sweeralert.js"></script>



</head>
<body>
      <!------MENU SECTION START-->

<?php
if($notify=='message'){
  echo'<script>swal("","'.$show.'");</script>';
}
?>
<!-- MENU SECTION END-->
    <div class="content-wra">
    <div class="content-wrapper">
         <div class="container">
      
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1"">
<div class="panel panel-info">
<div class="panel-heading">
UPDATE STORE
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$id=intval($_GET['id']);
$sql = "SELECT *,tbl_completed_baskets.id as id from  tbl_completed_baskets  where tbl_completed_baskets.id=:id";
$query = $dbh -> prepare($sql);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                   

                <h style="background:orange">update store</h><br>
                <div class="form-group">
<label>ID     :</label>
                <input type="number"name="identity"value=<?php echo htmlentities($result->id);?>>
                </div>
                <div class="form-group">
<label>Material:</label>
                <input type="text"name="p_name"value=<?php echo htmlentities($result->product_name);?>>
                </div>
                <div class="form-group">
<label>quantity :</label>
                <input type="number"name="p_qty"value=<?php echo htmlentities($result->quantity);?>>
   
                </div>

<button type="submit" name="return" id="submit" class="btn btn-info">UPDATE </button>

 </div>

<?php }}?>
                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
    
<script>
$(document).ready(function(){

load_data();

function load_data(query)
{
$.ajax({
url:"updatematerial",
method:"POST",
data:{query:query},
success:function(data)
{
$('#result').html(data);
}
});
}
$('#search_text').keyup(function(){
var search = $(this).val();
if(search != '')
{
load_data(search);
}
else
{
load_data();
}
});
});
</script>
     <!-- CONTENT-WRAPPER SECTION END-->
 
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php  }?>
