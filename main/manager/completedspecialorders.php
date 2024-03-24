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
$error_message = '';
$id = isset($_GET['id']) ? $_GET['id'] : null;
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
                                <th>Supervisor </th>
                                <th>Designer </th>
                                <th>order Status</th>
                                <th>Customer Remark</th>
                                <th>Shipping status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_specialorders WHERE payment_status!='Rejected' and paid_amount!='0' and supervisor!='' and Designer!=''");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr class="<?php echo $row['paymenttobemade'] == '0' ? 'bg-r' : 'bg-g'; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <b>Name:</b><br> <?php echo $row['customer_fullName']; ?><br>
                                        <b>Email:</b><br> <?php echo $row['customer_email']; ?><br><br>
                                    </td>

                                    <td><img src="../services/uploads/<?php echo $row['image']; ?>" style="width: 200px;"></td>


                                    <td>
                                        <b>County: </b><?php echo $row['county']; ?><br>
                                        <b>Specific Location: </b><?php echo $row['detail_location']; ?><br>
                                    </td>
                                    <td>
                                        <?php echo $row['paid_amount']; ?>



                                    </td>

                                    <td><?php echo $row['supervisor']; ?></td>
                                    <td><?php echo $row['Designer']; ?></td>
                                    <td><?php echo $row['order_status']; ?></td>

                                    <td><?php echo $row['cust_remark']; ?><br>
                                    <?php echo $row['cust_comment']; ?>
                                
                                </td>

                                    <td><?php echo $row['shipping_status']; ?></td>
                                       

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