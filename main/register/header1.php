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
if(!isset($_SESSION['customer'])) {
	header('location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>customer Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="inc/css/bootstrap.min.css">
	<link rel="stylesheet" href="inc/css/font-awesome.min.css">
	<link rel="stylesheet" href="inc/css/ionicons.min.css">
	<link rel="stylesheet" href="inc/css/datepicker3.css">
	<link rel="stylesheet" href="inc/css/all.css">
	<link rel="stylesheet" href="inc/css/select2.min.css">
	<link rel="stylesheet" href="inc/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="inc/css/jquery.fancybox.css">
	<link rel="stylesheet" href="inc/css/AdminLTE.min.css">
	<link rel="stylesheet" href="inc/css/_all-skins.min.css">
	<link rel="stylesheet" href="inc/css/on-off-switch.css"/>
	<link rel="stylesheet" href="inc/css/summernote.css">
	<link rel="stylesheet" href="style.css">

</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	

  		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>
<!-- Side Bar to Manage Shop Activities -->
  	