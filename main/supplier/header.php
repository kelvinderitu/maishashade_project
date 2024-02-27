<?php
include("inc/config.php");
include("inc/dbconnect.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if (!isset($_SESSION['user'])) {
	header('Location: login.php');
	exit; // Add an exit statement to prevent further execution
} else {
	$query = mysqli_query($connect, 'SELECT * FROM tbl_staff WHERE id="' . $_SESSION['user']['id'] . '"');
	$myprofile = mysqli_fetch_assoc($query);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Supplier Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css"/>
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">
</head>

<body class="hold-transition fixed skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<a href="index.php" class="logo" style="background-color:#ADD8E6">
				<span class="logo-lg">Maisha Shades</span>
			</a>
			<nav class="navbar navbar-static-top" style="background-color:#ADD8E6">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Supplier Panel</span>
				<!-- Top Bar ... User Inforamtion .. Login/Log out Area -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Profile
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); ?>
		<!-- Side Bar to Manage Shop Activities -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<ul class="sidebar-menu">
					<li class="treeview <?php if ($cur_page == 'index.php') {echo 'active';} ?>">
						<a href="index.php">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'product.php') || ($cur_page == 'product-add.php') || ($cur_page == 'product-edit.php')) {echo 'active';} ?>">
						<a href="tendarp.php">
							<i class="fa fa-book"></i> <span>Product Tenders</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'order.php')) {echo 'active';} ?>">
						<a href="productpayment.php">
							<i class="fa fa-briefcase"></i> <span>Tender Payment</span>
						</a>
					</li>
					<!--<li class="treeview <?php if (($cur_page == 'order.php')) {echo 'active';} ?>">
						<a href="../services/services.php">
							<i class="fa fa-clipboard"></i> <span>Services</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'order.php')) {echo 'active';} ?>">
						<a href="../services/mybookings.php">
							<i class="fa fa-clipboard"></i> <span>My Booking(s)</span>
						</a>
					</li>-->
					<li class="treeview <?php if (($cur_page == 'order.php')) {echo 'active';} ?>">
						<a href="supplierbank.php">
							<i class="fa fa-envelope"></i> <span>Bank Details</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'order.php')) {echo 'active';} ?>">
						<a href="register/inbox.php">
							<i class="fa fa-envelope"></i> <span>Messages</span>
						</a>
					</li>
					
				</ul>
			</section>
		</aside>
		<div class="content-wrapper">
