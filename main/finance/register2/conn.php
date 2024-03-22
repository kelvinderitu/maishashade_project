<?php
	$conn = new mysqli('localhost', 'root', '', 'maishashades');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>