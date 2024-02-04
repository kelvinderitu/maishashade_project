<?php require_once('header.php'); ?>

<?php
$error_message = '';
?>
<?php
if ($error_message != '') {
    echo "<script>alert('" . $error_message . "')</script>";
}
if ($success_message != '') {
    echo "<script>alert('" . $success_message . "')</script>";
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h3>Special Orders</h3>
    </div>
</section>


<section class="content">

    <div class="row">
        <div class="col-md-12">


            <div class="box box-info">

                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Details</th>
                                <th>Product Image</th>
                                <th>Location</th>
                                <th>Payment Details</th>
                                <th>Shipping fee</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_specialorders WHERE  payment='pending'");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr class="<?php if ($row['payment'] == 'pending') {
                                                echo 'bg-r';
                                            } else {
                                                echo 'bg-g';
                                            } ?>">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <b>Name:</b><br> <?php echo $row['customer_fullName']; ?><br>
                                        <b>Email:</b><br> <?php echo $row['customer_email']; ?><br><br>
                                    </td>

                                    
                                    <td> <?php echo $row['image']; ?>  </td>
                                    <td style="width:8px;"><img src="services/uploads/<?php echo $row['image']; ?>"></td>

                                    
                                    <td>
                                        <b>County: </b><?php echo $row['county']; ?><br>
                                        <b>Specific Location: </b><?php echo $row['detail_location']; ?><br>
                                        

                                        
                                    </td>
                                    <td>
                                        <?php echo $row['payment_status']; ?>
                                        <br><br>
                                        <?php
                                        if ($row['payment_status'] == 'Pending') {
                                            if ($row['transactioncode'] !== '') {
                                        ?>
                                                <a href="booking-change-status.php?id=<?php echo $row['id']; ?>&task=Approved" class="btn btn-warning btn-md">Approve</a>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </td>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>