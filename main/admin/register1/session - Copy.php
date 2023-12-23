<?php
	session_start();
	include 'conn.php';

	if(!isset($_SESSION['CUSUNAME']) || trim($_SESSION['CUSUNAME'])){
		header('location: index.php');
	}

	$sql = "SELECT * FROM tblcustomer WHERE CUSUNAME = '".$_SESSION['CUSUNAME']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>