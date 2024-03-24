<?php require_once('header.php'); ?>


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
        <h3>Completed Deliveries</h3>
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
                                <th>Customer</th>
                                
                                <th>Driver Allocated</th>
                                <th>Customer Remark</th>
                                <th>Payment Status</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_specialorders where driver!='' ORDER by id DESC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr class="<?php if ($row['payment_status'] == 'pending') {
                                                echo 'bg-r';
                                            } else {
                                                echo 'bg-g';
                                            } ?>">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <b>Name:</b><br> <?php echo $row['customer_fullName'];?>
                                        <b>Email:</b><br> <?php echo $row['customer_email']; ?><br><br>
                                    </td>
                                    
                                    <td> <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_staff WHERE role='driver' AND full_name=?");
                                            $statement1->execute(array($row['driver']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                echo '<b>Driver name:</b> ' . $row1['full_name'];
                                                echo '<br><b>Email:</b> ' . $row1['email'];
                                                echo '<br><b>Phone Number:</b> ' . $row1['phone'];
                                                echo '<br><br>';
                                            }
                                            ?>
                                    </td>

                                    <td><?php echo $row['cust_remark']; ?><br>
                                    <?php echo $row['cust_comment']; ?><br>
                                        
                                    </td>
                                    <td>
                                        <?php echo $row['payment_status']; ?>
                                        <br><br>
                                        <?php
                                        if ($row['payment_status'] == 'pending') {
                                        ?>
                                            <a href="paymentspecialorder.php?id=<?php echo $row['id']; ?>&task=Approved" class="btn btn-success btn-xs" style="width:100%;margin-bottom:4px;">Mark Complete</a>
                                        <?php
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