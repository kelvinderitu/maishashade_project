<?php
session_start();
error_reporting(0);
include('config.php');


if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $status = 1;
    $sql = "INSERT INTO  tbl_staff(full_name,email,phone,role,password,status) VALUES(:full_name,:email,:phone,:role,:password,:status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':full_name', $full_name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query->bindParam(':role', $role, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Staff Added successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MAISHA CAR SHADES AND CAR PORTS LIMITED</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/AdminLTE.css">


    <link rel="stylesheet" href="inc/css/_all-skins.min.css">

    <!-- JS -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="js/bootstrap.datetime.js"></script>
    <script src="js/bootstrap.password.js"></script>
    <script src="js/scripts.js"></script>

    <!-- AdminLTE App -->
    <script src="js/app.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.datetimepicker.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
    <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="hold-transition skin-black sidebar-mini ">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->

        <!-- Header Navbar -->

        </header>

        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">

                <!-- ========== LEFT SIDEBAR ========== -->
                <aside class="main-sidebar">
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                        <div class="sidebar-brand-icon rotate-n-15">

                        </div>

                    </a>


                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">


                        <!-- Sidebar Menu -->
                        <ul class="sidebar-menu">
                            <li class="header">MENU</li>
                            <!-- Menu 0.1 -->
                            <li class="treeview">
                                <a href="dashboard.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span>

                                </a>
                                <br>
                            </li>
                            <div class="container">
                                <font color="white"><i class="fa fa-users" &nbsp;></i>&nbsp;USERS ACCOUNT</font>
                            </div>
                            <!-- Menu 1 -->
                            <li class="treeview">
                                <a href="#"><i class="fa fa-users"></i> <span>Pending Customers</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="pendingcustomer.php"><i class="fa fa-user"></i>Customer</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-users"></i> <span>Active Users</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="approvedcustomer.php"><i class="fa fa-user"></i>Customer</a></li>
                                    <li><a href="approvedstaff.php"><i class="fa fa-user"></i>Staff</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-users"></i> <span>Inactive Users</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="inactivecustomer.php"><i class="fa fa-user"></i>Customer</a></li>
                                    <li><a href="inactivestaff.php"><i class="fa fa-user"></i>Staff</a></li>
                                </ul>
                            </li>
                            <div class="container">
                                <font color="white"><i class="fa fa-plus"></i>&nbsp;ADD USERS</font>
                            </div>
                            <!-- Menu 2 -->
                            <li class="treeview">
                                <a href="#"><i class="fa fa-user"></i><span>Add</span>

                                </a>
                                <ul class="treeview-menu">
                                    <!--<li><a href="addcustomer.php"><i class="fa fa-user"></i>Customer</a></li>-->
                                    <li><a href="addstaff.php"><i class="fa fa-plus"></i>Staff</a></li>
                                </ul>
                            </li>
                            <!-- Menu 3 -->
                            <div class="container">
                                <font color="white"><i class="fa fa-book"></i>&nbsp;VIEW REPORTS</font>
                            </div>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-eye"></i><span>View</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="order.php"><i class="fa fa-shopping-cart"></i>Orders</a></li>
                                    <li><a href="payment.php"><i class="fa fa-briefcase"></i>Order Payments</a></li>
                                    <li><a href="servicespayment.php"><i class="fa fa-briefcase"></i>Services Payments</a></li>
                                    <li><a href="suppliespayment.php"><i class="fa fa-briefcase"></i>Supplies Payments</a></li>
                                    <li><a href="dispatch.php"><i class="fa fa-truck"></i>Dispatches</a></li>
                                    <li><a href="supplies.php"><i class="fa fa-book"></i>Supplies</a></li>
                                    <li><a href="services-requested.php"><i class="fa fa-book"></i>Services</a></li>
                                    <!-- <li><a href="../main/services/quot-rep.php"><i class="fa fa-book"></i>Site Quotation Report</a></li>-->
                                </ul>
                            </li>
                            <div class="container">
                                <font color="white"><i class="fa fa-envelope"></i>&nbsp;MESSAGES</font>
                            </div>
                            <!-- Menu 4 -->
                            <li class="treeview">
                            <li><a href="managemessages.php"><i class="fa fa-eye"></i>View</a></li>
                            <div class="container">
                                <font color="white"><i class="fa fa-envelope"></i>&nbsp;FEEDBACK REPORTS</font>
                            </div>
                            <li class="treeview">
                            <li><a href="managefeedbacks.php"><i class="fa fa-eye"></i>View</a></li>
                            </li>
                            <li><a href="admin-profile.php"><i class="fa fa-lock"></i>Change Password</a></li>
                            <li><a href="logout.php"><i class="fa fa-power-off"></i>Logout</a></li>

                        </ul>
                        <!-- /.sidebar-menu -->
                    </section>
                    <!-- /.sidebar -->
                </aside>

                <!-- /.left-sidebar -->

                <div class="main-page">

                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <br>
                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-12">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Back</a></li>

                                    <li class="active"></li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="container-fluid">

                        <div class="card">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <center>
                                                <h4><b>ADD NEW STAFF</b></h4>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong></strong><?php echo htmlentities($msg); ?>
                                            </div><?php } else if ($error) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Error !!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post">

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="full_name" class="form-control" id="full_name" required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Email </label>
                                                <div class="col-sm-8">
                                                    <input type="email" name="email" class="form-control" id="email" required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Role</label>
                                                <select name="role" required>
                                                    <option>Select Role</option>
                                                    <option value="inventory_manager">Inventory Manager</option>
                                                    <option value="technician">Technician</option>
                                                    <option value="finance">Finance</option>
                                                    <option value="dispatch">Dispatch Manager</option>
                                                    <option value="service manager">Service Manager</option>
                                                    <option value="supervisor">Supervisor</option>
                                                    <option value="driver">Driver</option>
                                                    <option value="supplier">Supplier</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="date" class="col-sm-2 control-label">Phone Number</label>
                                                <div class="col-sm-8">
                                                    <input type="tel" name="phone" class="form-control" minlength="10" maxlength="13" id="phone">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Password</label>
                                                <div class="col-sm-8">
                                                    <input type="password" name="password" class="form-control" id="password" minlength="5" required="required" autocomplete="off">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-8">
                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                                <button class="btn btn-warning">
                                                    <a href="dashboard.php">
                                                        <font color="black"><i class="fa fa-arrow-left"></i>&nbsp;Back</font>
                                                    </a>
                                                </button>
                                            </div>


                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
</body>

</html>
<?PHP ?>