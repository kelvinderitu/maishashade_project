<?php
	$conn = new mysqli('localhost', 'root', '', 'urban_studio');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>