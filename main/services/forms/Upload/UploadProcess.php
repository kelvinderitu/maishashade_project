<?php
    include '../connection.php';
    if(isset($_POST['upload'])&&$_FILES['userfile']['size']>0)
    {
        $fileName = $_FILES['userfile']['name'];
        $tmpName  = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];
        $fileType=mysqli_real_escape_string($con,
        stripslashes ($fileType));
        $fp      = fopen($tmpName, 'r');
        $client=$_POST['client'];
        $content = fread($fp, filesize($tmpName));
        $content = addslashes($content);
        fclose($fp);
        $fileName = addslashes($fileName);
        if($con){
        $query = "INSERT INTO upload (name,client, size, type, content ) ".
        "VALUES ('$fileName','$client',  '$fileSize', '$fileType', '$content')";
        mysqli_query($con,$query) or die('Error, query failed'); 
        mysqli_close($con);
        header('location:Success.php');
        }
        else { 
         header('location:../View/View.php');   
        }
    } 
?>
