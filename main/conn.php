<?php
	$con = new mysqli('localhost', 'root', '', 'nyabondobricks');

	if ($con->connect_error) {
	    die("Connection failed: " . $con->connect_error);
	}
	
?>