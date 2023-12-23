<?php
	session_start();
	include 'conn.php';

	if(!isset($_SESSION['customer']['cust_id']) || trim($_SESSION['customer']['cust_id']) == ''){
		header('location: index.php');
	}

	$sql = "SELECT * FROM tbl_customer WHERE cust_id = '".$_SESSION['customer']['cust_id']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>