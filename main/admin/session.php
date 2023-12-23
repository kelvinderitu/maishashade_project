<?php
	session_start();
	include 'conn.php';

	if(!isset($_SESSION['user']['email']) || trim($_SESSION['user']['email']) == ''){
		header('location: index.php');
	}

	$sql = "SELECT * FROM tbl_staff WHERE email = '".$_SESSION['user']['email']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>