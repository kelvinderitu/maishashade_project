<?php

$servername="localhost";
$uname="root";
$pass="";
$db="maishashades";

$conn=mysqli_connect($servername,$uname,$pass,$db);

if(!$conn){
    die("Connection Failed");
}

?>