<?php require_once('head1.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<script>
    function printPage(){
        window.print();
    }
</script> 
</head>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo '#' ?></th>
                                    <th><?php echo LANG_VALUE_48; ?></th>
                                    <th>Payment Details</th>
                                    <th>Event Date</th>
                                </tr>
                            </thead>
                            <?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_bookings where stu_id='".$_SESSION['customer']['cust_id']."'");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
                       <b>Cutomer Name :</b><?php echo $row['full_name']; ?><br>
                                       <b>Date :</b><?php echo $row['date']; ?><hr>
					<tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
	                    <td><?php echo $i; ?></td>
	                   
                        <td>
                           <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_services WHERE serviceid=?");
                           $statement1->execute(array($row['service']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo ''.$row1['servicename'];
                           }
                           ?>
                        </td>
                   
                        <td>
                           <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_services WHERE serviceid=?");
                           $statement1->execute(array($row['service']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo 'Ksh '.$row1['pricing'];
                           }
                           ?>
                        </td>
                        <td>
                            <?php echo $row['eventdate']; ?>
                        </td>
                       
                        <td>
                     
                        </td>
	                </tr>
            		<?php
            	
            }
            	?>
                                                             
                            </tbody>
                        </table>
                        <div class="pagination" style="overflow: hidden;">
                        <?php 
                            echo $pagination; 
                        ?>
                    </div>
        
  </div>
            </div>
        </div>
    </div>
</div>
</html>

<?php require_once('footer.php'); ?>