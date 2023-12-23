<?php
session_start();
error_reporting(0);
include 'session.php';
include('configcontact.php');
if(isset($_POST['send']))
  {
    
    
    function test_input($data)
	{
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
$stu_id=$_POST['stu_id'];
$fullname=$_POST['fullname'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$address=$_POST['address'];
$eventname=$_POST['eventname'];
$charges=$_POST['charges'];
$position_id=$_POST['position_id'];
$groupname=$_POST['groupname'];
$category=$_POST['category'];
$transactioncode=test_input($_POST['transactioncode']);
$per='M1OPQRST6U8V2X3ABCDEFG45NYZ7W9HIJ0KL';
$newS=substr(str_shuffle($per),0,8);

$naming = "/^(?=.*[A-Z])(?=.*[0-9])/";

if (!preg_match($naming,$transactioncode)) {
    $error="Please Enter a valid MPESA ID";
  }
else{ 
$sql="INSERT INTO  candidates(stu_id,fullname,email,phone,address,eventname,charges,position_id,groupname,category,transactioncode) VALUES(:stu_id,:fullname,:email,:phone,:address,:eventname,:charges,:position_id,:groupname,:category,:transactioncode)";
$query = $dbh->prepare($sql);
$query->bindParam(':stu_id',$stu_id,PDO::PARAM_STR);
$query->bindParam(':fullname',$fullname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':phone',$phone,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':eventname',$eventname,PDO::PARAM_STR);
$query->bindParam(':charges',$charges,PDO::PARAM_STR);
$query->bindParam(':position_id',$position_id,PDO::PARAM_STR);
$query->bindParam(':groupname',$groupname,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':transactioncode',$transactioncode,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Registration was successfully,Please wait for approval process";
}
else 
{
$error="Something went wrong. Please try again";
}
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
                <a href="../index.php"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
            </li>
          
        </ol>

        <!-- Content Row -->
        <div class="row">
            <!-- Map Column -->
              <div class="col-lg-8 mb-4">
                  
                <center><h5><b>REGISTER GROUP :</b></h5></center>
                
                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                <form name="sentaddress"  method="post">
                <input type="hidden" class="form-control" id="stu_id" name="stu_id" readonly value="<?php echo $user['id']; ?>">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Group Representative:</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" readonly value="<?php echo $user['fullname']; ?>">
                            <p class="help-block"></p>
                        </div>
                    </div>
                            <input type="hidden" class="form-control" id="phone" name="phone" readonly value="<?php echo $user['phone']; ?>">
                            <input type="hidden" class="form-control" id="email" name="email" readonly value="<?php echo $user['email']; ?> ">
                        
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Group Name:</label>
                            <input type="groupname" class="form-control" id="groupname" name="groupname" >
                        </div>
                    </div>
                            <input type="hidden" class="form-control" id="category" name="category" readonly value="group">
                       
                  
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Select Event<span class="text-danger ml-2">*</span></label>
                         <?php
                        $qry= "SELECT * FROM events where status='1'";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          echo ' <select required name="eventname" onchange="classArmDropdown(this.value)" class="form-control mb-1">';
                          echo'<option value="">--Select Event--</option>';
                          while ($rows = $result->fetch_assoc()){
                          echo'<option value="'.$rows['eventname'].'" >'.$rows['eventname'].'</option>';
                              }
                                  echo '</select>';
                              }
                            ?>  
                        </div>
                            </div>
                        <div class="col-xl-6">
                        <label class="form-control-label">Charges<span class="text-danger ml-2">*</span></label>
                            <?php
                                echo"<div id='txtHin'></div>";
                            ?>
                        </div>
                    </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Compete In <span class="text-danger ml-2">*</span></label>
                         <?php
                        $qry= "SELECT * FROM positions";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          echo ' <select required name="position_id"  class="form-control mb-1">';
                          echo'<option value="">--Select Category--</option>';
                          while ($rows = $result->fetch_assoc()){
                          echo'<option value="'.$rows['id'].'" >'.$rows['description'].'</option>';
                              }
                                  echo '</select>';
                              }
                            ?>  
                        </div>
                            </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>M-Pesa Code:</label>
                            <input type="text" class="form-control" minlength="10" maxlength="10" id="transactioncode" name="transactioncode"  value="">
                        </div>
                    </div>
                    <div id="success"></div>
                    <!-- For success/fail addresss -->
                    <button type="submit" name="send"  class="btn btn-primary">Register</button>
                </form>
            </div>

            <!-- Contact Details Column -->
                    <?php 
$pagetype=$_GET['type'];
$sql = "SELECT Address,emailId,ContactNo from tblcontactusinfo";
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
                   <?php   echo htmlentities($result->Address); ?>
                    <br>
                </p>
                <p>
                    <abbr title="Phone">P</abbr>: <?php   echo htmlentities($result->ContactNo); ?>
                </p>
                <p>
                    <abbr title="email">E</abbr>: <a href="mailto:name@example.com"><?php   echo htmlentities($result->emailId); ?>
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
    <!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

</body>

</html>
