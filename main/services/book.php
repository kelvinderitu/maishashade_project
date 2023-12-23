<?php
session_start();

error_reporting(0);
include 'session.php';
include('configcontact.php');
$serviceid=$_GET['serviceid'];
$t1=mysqli_query($conn,'select * from tbl_services where serviceid="' .$serviceid .'"');
$m1=mysqli_fetch_assoc($t1);
error_reporting(0);
if(isset($_POST['send']))
  {
    function test_input($data)
	{
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
$cust_id=$_POST['cust_id'];
$cust_name=$_POST['cust_name'];
$cust_lname=$_POST['cust_lname'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$service=$_POST['service'];
$eventdate = $_POST['eventdate'];
$charges = $_POST['charges'];
$county = $_POST['county'];
$fee = $_POST['fee'];
$location = $_POST['location'];
$duration = $_POST['duration'];

    $sql="INSERT INTO  tbl_bookings(cust_id,cust_name,cust_lname,email,phone,service,charges,eventdate,county,fee,location,duration) VALUES(:cust_id,:cust_name,:cust_lname,:email,:phone,:service,:charges,:eventdate,:county,:fee,:location,:duration)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':cust_id',$cust_id,PDO::PARAM_STR);
    $query->bindParam(':cust_name',$cust_name,PDO::PARAM_STR);
    $query->bindParam(':cust_lname',$cust_lname,PDO::PARAM_STR);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
     $query->bindParam(':phone',$phone,PDO::PARAM_STR);
     $query->bindParam(':service',$service,PDO::PARAM_STR);
     $query->bindParam(':charges',$charges,PDO::PARAM_STR);
     $query->bindParam(':eventdate',$eventdate,PDO::PARAM_STR);
     $query->bindParam(':county',$county,PDO::PARAM_STR);
     $query->bindParam(':fee',$fee,PDO::PARAM_STR);
     $query->bindParam(':location',$location,PDO::PARAM_STR);
     $query->bindParam(':duration',$duration,PDO::PARAM_STR);
    $query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Booking was successfully made, We will get back to you.";
header('location:mybookings.php');
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
        xmlhttp.open("GET","ajaxClassArms3.php?cid="+str,true);
        xmlhttp.send();
    }
}
</script>

</head>

<body>


    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3"></h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="services.php"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
            </li>
          
        </ol>

        <!-- Content Row -->
        <div class="row">
            <!-- Map Column -->
              <div class="col-lg-8 mb-4">
                  
                <center><h5><b>BOOK FOR A SERVICE :</b></h5></center>
                
                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                <form name="sentaddress"  method="post">
                <input type="hidden" class="form-control" id="cust_id" name="cust_id" readonly value="<?php echo $user['cust_id']; ?>">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Full Name:</label>
                            <input type="text" class="form-control" id="cust_name"  name="cust_name" readonly value="<?php echo $user['cust_name']; ?>">
                            <input type="text" class="form-control" id="cust_lname" name="cust_lname" readonly value="<?php echo $user['cust_lname']; ?>">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Phone Number:</label>
                            <input type="tel" class="form-control" id="phone" name="phone" readonly value="<?php echo $user['cust_phone']; ?>">
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Email Address:</label>
                            <input type="email" class="form-control" id="email" name="email" readonly value="<?php echo $user['cust_email']; ?> ">
                        </div>
                        <label>Service Name :</label>
                        <div class="controls">
                        <input type="text" class="form-control" name="service" readonly value="<?php echo $m1['servicename']; ?>">  
                        </div>
                    </div>  
                    <div class="control-group form-group">   
                      <label>Duration :</label>
                        <div class="controls">
                        <input type="text" class="form-control" name="duration"  readonly value="<?php echo $m1['duration']; ?>">  
                        </div>
                    </div>    
                    <div class="control-group form-group">                
                    <label>Service Charges :</label>
                        <div class="controls">
                        <input type="number" class="form-control" name="charges" readonly value="<?php echo $m1['pricing']; ?>">  
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="form-control-label">Location<span class="text-danger ml-2">*</span></label>
                         <?php
                        $qry= "SELECT * FROM tbl_country";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          echo ' <select required name="county" onchange="classArmDropdown(this.value)" class="form-control mb-1">';
                          echo'<option value="">--Select County--</option>';
                          while ($rows = $result->fetch_assoc()){
                          echo'<option value="'.$rows['country_name'].'" >'.$rows['country_name'].'</option>';
                              }
                                  echo '</select>';
                              }
                            ?>  
                        </div>
                        <div class="control-group">
                        <label class="form-control-label">Other Charges<span class="text-danger ml-2">*</span></label>
                            <?php
                                echo"<div id='txtHint'></div>";
                            ?>
                        </div>
                    </div>
                    </div>
                    <div class="control-group form-group">                
                    <label>From :</label>
                        <div class="controls">
                        <input name="eventdate" type="date" min="<?php echo date('Y-m-d'); ?>" required> 
                        </div>
                    </div>
                    <div class="control-group form-group">                
                    <label>Location details :</label>
                        <div class="controls">
                        <textarea name="location" rows="5" cols="25" class="form-control" required> </textarea>
                        </div>
                    </div>
                 
                

                    <div id="success"></div>
                    <!-- For success/fail addresss -->
                    <button type="submit" name="send"  class="btn btn-primary">Submit</button>
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
