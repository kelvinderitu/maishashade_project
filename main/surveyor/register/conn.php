<?php
	$conn = new mysqli('localhost', 'root', '', 'nyabondobricks');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>