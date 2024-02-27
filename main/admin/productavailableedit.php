<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;





    $statement = $pdo->prepare("UPDATE tbl_material SET 
        							p_name=?, 
        							qty=?, 
        							supplier=?, 
								
        							specs=?
        						

        							WHERE id=?");
    $statement->execute(array(
        $_POST['p_name'],
        $_POST['qty'],
        $_POST['supplier'],

        $_POST['specs'],
        $_REQUEST['id'],


        
    ));
    $success_message = 'Product is updated successfully.';
}






?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_material WHERE id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Material</h1>
    </div>
    <div class="content-header-right">
        <a href="productavailable.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_material WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $p_name = $row['p_name'];
    $qty = $row['qty'];

    $supplier = $row['supplier'];
    $specs = $row['specs'];
}


?>


<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message) : ?>
                <div class="callout callout-danger">

                    <p>
                        <?php echo $error_message; ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($success_message) : ?>
                <div class="callout callout-success">

                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Material Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Quantity<br></label>
                            <div class="col-sm-4">
                                <input type="text" name="qty" class="form-control" value="<?php echo $qty; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Supplier<br></label>
                            <div class="col-sm-4">
                                <input type="text" name="supplier" class="form-control" value="<?php echo $supplier; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Descriptions<br></label>
                            <div class="col-sm-4">
                                <input type="text" name="specs" class="form-control" value="<?php echo $specs; ?>">
                            </div>
                        </div>




                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>


        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>