<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if(!isset($_SESSION['login_username'])) {
	header('location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
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

<body class="hold-transition fixed skin-blue sidebar-mini">
	<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>
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

<!-- Side Bar to Manage Shop Activities -->
  	