<?php
	session_start();
	include 'conn.php';

	if(!isset($_SESSION['user']['id']) || trim($_SESSION['user']['id']) == ''){
		header('location: index.php');
	}

	$sql = "SELECT * FROM tbl_staff WHERE id = '".$_SESSION['user']['id']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>