<?php
session_start();
error_reporting(0);
include 'session.php';
include('configcontact.php');
if(isset($_POST['send']))
  {
$cust_id=$_POST['cust_id'];
$cust_name=$_POST['cust_name'];
$cust_email=$_POST['cust_email'];
$cust_phone=$_POST['cust_phone'];
$product_name=$_POST['product_name'];
$quantity=$_POST['quantity'];
$description=$_POST['description'];
$sql="INSERT INTO  tbl_request(cust_id,cust_name,cust_email,cust_phone,product_name,quantity,description) VALUES(:cust_id,:cust_name,:cust_email,:cust_phone,:product_name,:quantity,:description)";
$query = $dbh->prepare($sql);
$query->bindParam(':cust_id',$cust_id,PDO::PARAM_STR);
$query->bindParam(':cust_name',$cust_name,PDO::PARAM_STR);
$query->bindParam(':cust_email',$cust_email,PDO::PARAM_STR);
$query->bindParam(':cust_phone',$cust_phone,PDO::PARAM_STR);
$query->bindParam(':product_name',$product_name,PDO::PARAM_STR);
$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Order was successfully made.Our team is working on your order and we will update you.Thank you.";
}
else 
{
$error="Something went wrong. Please try again";
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Temporary navbar container fix -->
    <style>
    .navbar-toggler {
        z-index: 1;
    }
    
    @media (max-width: 576px) {
        nav > .container {
            width: 100%;
        }
    }
    </style>
    <style>
    .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
    </style>
     <script>
    function classArmDropdown(str) {
    if (str == "") {
        document.getElementById("txtHin").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxClassArms3.php?cid="+str,true);
        xmlhttp.send();
    }
}
</script>

</head>

<body>

    <?php include('includes/header.php');?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3"></h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="myspecialorders.php"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
            </li>
          
        </ol>

        <!-- Content Row -->
        <div class="row">
            <!-- Map Column -->
              <div class="col-lg-8 mb-4">
                  
                <center><h5><b>MAKE SPECIAL ORDER :</b></h5></center>
                
                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                <form name="sentcust_address"  method="post">
                <input type="hidden" class="form-control" id="cust_id" name="cust_id" readonly value="<?php echo $user['cust_id']; ?>">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Full Name:</label>
                            <input type="text" class="form-control" id="cust_name" name="cust_name" readonly value="<?php echo $user['cust_name']; ?>">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Phone Number:</label>
                            <input type="tel" class="form-control" id="cust_phone" name="cust_phone" readonly value="<?php echo $user['cust_phone']; ?>">
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Email Address:</label>
                            <input type="text" class="form-control" id="cust_email" name="cust_email" readonly value="<?php echo $user['cust_email']; ?> ">
                        </div>
                    </div>
                
                  
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Product Name:</label>
                            <input type="text" class="form-control"  id="product_name" name="product_name"  value="">
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Product Quantity:</label>
                            <input type="number" class="form-control"  id="quantity" name="quantity"  value="">
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Product Detailed description:</label>
                            <textarea name="description" class="form-control" required rows="10" cols="5" ></textarea>
                        </div>
                    </div>
                    <div id="success"></div>
                    <!-- For success/fail cust_addresss -->
                    <button type="submit" name="send"  class="btn btn-primary">Submit</button>
                </form>
            </div>

            <!-- Contact Details Column -->
                    <?php 
$pagetype=$_GET['type'];
$sql = "SELECT cust_address,cust_emailId,ContactNo from tblcontactusinfo";
$query = $dbh -> prepare($sql);
$query->bindParam(':pagetype',$pagetype,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
            <div class="col-lg-4 mb-4">
                <h3>Contact Details</h3>
                <p>
                   <?php   echo htmlentities($result->cust_address); ?>
                    <br>
                </p>
                <p>
                    <abbr title="cust_email">P</abbr>: <?php   echo htmlentities($result->ContactNo); ?>
                </p>
                <p>
                    <abbr title="cust_email">E</abbr>: <a href="mailto:name@example.com"><?php   echo htmlentities($result->cust_emailId); ?>
                    </a>
                </p>
              <?php }} ?>
            </div>
        </div>
        <!-- /.row -->


    </div>
    <!-- /.container -->
<?php include('includes/footer.php');?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/tether/tether.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Contact form JavaScript -->
    <!-- Do not edit these files! In order to set the cust_email cust_address and subject line for the contact form go to the bin/contact_me.php file. -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

</body>

</html>
