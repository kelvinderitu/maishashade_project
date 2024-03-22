<?php
	$con = new mysqli('localhost', 'root', '', 'maishashades');

	if ($con->connect_error) {
	    die("Connection failed: " . $con->connect_error);
	}
	
?>