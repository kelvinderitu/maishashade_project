<?php
include 'dbcon.php';

    $cid = intval($_GET['cid']);//

        $queryss=mysqli_query($conn,"select * from materials where matid=".$cid."");                        
        $countt = mysqli_num_rows($queryss);

        
        echo '
        <select  name="pricing" class="form-control mb-3">';
        
        while ($row = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$row['pricing'].'" >'.$row['pricing'].'</option>';
        
        }
        echo '</select>';;
?>

