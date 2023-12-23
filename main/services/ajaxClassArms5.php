<?php
include 'dbcon.php';

    $cid = intval($_GET['cid']);//

        $queryss=mysqli_query($conn,"select * from tbl_country where country_id=".$cid."");                        
        $countt = mysqli_num_rows($queryss);

        
        echo '
        <select  name="fee" class="form-control mb-3">';
        
        while ($row = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$row['cost'].'" >'.$row['cost'].'</option>';
        
        }
        echo '</select>';;
?>

