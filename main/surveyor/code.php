<?php

session_start();
$con =mysqli_connect("localhost","root","","nyabondobricks");
if(isset($_POST['button'])){
    $id =$_POST['id'];
    
    $material=$_POST['myTextarea'];

    $query ="UPDATE tbl_payment SET materials=$material WHERE id =$id";
    $query_run =mysqli_query($con, $query);

    if($query_run){
        $_SESSION['status'] = " updated";
        header("Location: orderallocations.php");

    }else{
        $_SESSION['status'] = "not updated";
        header("Location: orderallocations.php");
    }
}
?>
