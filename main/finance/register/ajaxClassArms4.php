<?php
include 'dbcon.php';

    $cid = $_GET['cid'];//
    $val_X = mysqli_real_escape_string($conn,$cid);

        $queryss=mysqli_query($conn,"select * from positions where description='$val_X'");                        
        $countt = mysqli_num_rows($queryss);

        
        echo '
        <select  name="charges" class="form-control mb-3">';
        
        while ($row = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$row['id'].'" >'.$row['id'].'</option>';
        
        }
        echo '</select>';;
?>

