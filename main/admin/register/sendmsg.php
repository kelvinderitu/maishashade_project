<?php
include('connection.php');
session_start();

$q1=mysqli_query($conn,'select * from tbl_staff where id="'.$_SESSION['user']['id'].'"');
$r1=mysqli_fetch_assoc($q1);

error_reporting(0);
include 'session.php';
include('configcontact.php');
if(isset($_POST['send']))
  {
    
$user_id=$_POST['user_id'];
$recepient=$_POST['recepient'];
$message=$_POST['message'];
$fname=$_POST['fname'];
$sql="INSERT INTO  tbmessages(user_id,recepient,message,fname) VALUES(:user_id,:recepient,:message,:fname)";
$query = $dbh->prepare($sql);
$query->bindParam(':user_id',$user_id,PDO::PARAM_STR);
$query->bindParam(':recepient',$recepient,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Message was sent successfully.";
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
        document.getElementById("txtHint").innerHTML = "";
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
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxClassArms2.php?cid="+str,true);
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
                <a href="inbox.php"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
            </li>
          
        </ol>

        <!-- Content Row -->
        <div class="row">
            <!-- Map Column -->
              <div class="col-lg-8 mb-4">
                  
                <center><h5><b>SEND MESSAGE :</b></h5></center>
                
                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                <form name="sentaddress"  method="post">
                <input type="hidden" class="form-control" id="user_id" name="user_id" readonly value="<?php echo $r1['id']; ?>">

                <input type="hidden" class="form-control" id="user_id" name="fname" readonly value="<?php echo $r1['cust_name']; ?>">

                        
                    
                 
                    <div class="col-lg-4 mb-4">
<div class="font-italic">Receiver<span style="color:red">*</span></div>

                              <select name="recepient" onchange="showLoanDetails(this.value)" class="form-control" required>
                              <option value="">Select Receiver</option>
                              <?php
                              $q1=mysqli_query($conn,"SELECT * from tbl_customer  where cust_status='1'  ");
                              $q2=mysqli_query($conn,"SELECT * from tbl_staff  where  role='supplier'  ");
                              while($r1=mysqli_fetch_assoc($q1))
                              {
                              echo "<option value='".$r1['cust_id']."'>".$r1['cust_name']."  ".$r1['cust_lname']." </option>";
                              }
                              while($r2=mysqli_fetch_assoc($q2))
                              {
                              echo "<option value='".$r2['id']."'>".$r2['full_name']."  ".$r2['role']." </option>";
                              }
                              ?>
                              </select>
                              </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Message :</label>
<textarea rows="5" cols="36" name="message" ></textarea>
                        </div>
                    </div>
                    <div id="success"></div>
                    <!-- For success/fail addresss -->
                    <button type="submit" name="send"  class="btn btn-primary">Send</button>
                </form>
            </div>

            <!-- Contact Details Column -->
                    <?php 
$pagetype=$_GET['type'];
$sql = "SELECT Address,recepientId,ContactNo from tblcontactusinfo";
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
                    <abbr title="message">P</abbr>: <?php   echo htmlentities($result->ContactNo); ?>
                </p>
                <p>
                    <abbr title="recepient">E</abbr>: <a href="mailto:name@example.com"><?php   echo htmlentities($result->recepientId); ?>
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
    <!-- Do not edit these files! In order to set the recepient address and subject line for the contact form go to the bin/contact_me.php file. -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

</body>

</html>
