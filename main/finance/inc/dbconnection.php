<?php
// Create connection
$con=mysqli_connect("localhost","root","","maishashades");

// Check connection
if (mysqli_connect_error())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>