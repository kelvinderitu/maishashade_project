<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['login_username'];
  //Add USer
  if(isset($_POST['change_pwd']))
    {

            $password=$_POST['password'];//update password
            $query=" UPDATE admin SET password = ? WHERE user_id = ?";
            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('si', $password, $aid);
            $stmt->execute();
                if($stmt)
                {
                    $succ = "Password Changed";
                }
                else 
                {
                    $err = "Please Try Again Later";
                }
            }
?>
<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php');?>

<body id="page-top">
 <!--Start Navigation Bar-->
  <!--Navigation Bar-->

  <div id="wrapper">

    <!-- Sidebar -->
    <!--End Sidebar-->
    <div id="content-wrapper">

      <div class="container-fluid">
      <?php if(isset($succ)) {?>
                        <!--This code for injecting an alert-->
        <script>
                    setTimeout(function () 
                    { 
                        swal("Success!","<?php echo $succ;?>!","success");
                    },
                        100);
        </script>

        <?php } ?>
        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
        <script>
                    setTimeout(function () 
                    { 
                        swal("Failed!","<?php echo $err;?>!","Failed");
                    },
                        100);
        </script>

        <?php } ?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.php">Back</a>
          </li>
        </ol>
        <hr>
        <div class="card col-md-8">
        <!-- <img src="../vendor/img/services_banner.jpg" class="card-img-top" alt="..."> -->
        <div class="card-body">
        <div class="card">
        <center><h4> Change Password</h4></center>
            <div class="card-body">
               
                <form method ="post">                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Old Password</label>
                        <input type="password" name="" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" name="password" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm New Password</label>
                        <input type="password" class="form-control" name="" required>
                    </div>
                    <button type="submit" name="change_pwd" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
        </div>
        </div>
      </div>      
      <hr>
     

      <!-- Sticky Footer -->

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

 

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="vendor/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="vendor/js/demo/datatables-demo.js"></script>
  <script src="vendor/js/demo/chart-area-demo.js"></script>
 <!--INject Sweet alert js-->
 <script src="vendor/js/swal.js"></script>

</body>

</html>
