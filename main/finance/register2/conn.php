<?php
	$conn = new mysqli('localhost', 'root', '', 'kenyaclay');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>