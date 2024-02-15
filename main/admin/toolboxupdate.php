<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;



    $statement = $pdo->prepare("UPDATE tbl_toolbox SET 
        							toolbox_type=?, 
        							quantity=? 
        							

        							WHERE toolbox_id=?");
    $statement->execute(array(
        $_POST['toolboxtype'],
        $_POST['quantity'],

        $_REQUEST['id']
    ));
}





?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Product</h1>
    </div>
    <div class="content-header-right">
        <a href="product.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_toolbox WHERE toolbox_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $toolbox_type= $row['toolbox_type'];
    $quantity = $row['quantity'];}
  





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
                            <div class="col-sm-4">
                                
                        </div>
                        




                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Quantity <span>*</span></label>
                            <div class="col-sm-4"><input type="number" class="form-control" name="amount" id="pqty" readonly value="<?php echo $p_qty; ?>"></div>
                        </div><br>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">New Number <span>*</span></label>

                            <select class="col-sm-4" onchange="loanamount()" name="new" id="newnum" class="form-control" required>
                                <option value="">Select Number </option>
                                <?php
                                for ($i = 1; $i <= 1000; $i++) {
                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                }
                                ?>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">New Quantity <span>*</span></label>
                            <div class="col-sm-4"><input type="number" class="form-control" name="p_qty" readonly="true" id="totalpaid"></div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Select Size</label>
                        <div class="col-sm-4">
                            <select name="size[]" class="form-control select2" multiple="multiple">
                                <?php
                                $is_select = '';
                                $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    if (isset($size_id)) {
                                        if (in_array($row['size_id'], $size_id)) {
                                            $is_select = 'selected';
                                        } else {
                                            $is_select = '';
                                        }
                                    }
                                ?>
                                    <option value="<?php echo $row['size_id']; ?>" <?php echo $is_select; ?>><?php echo $row['size_name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Select Color</label>
                        <div class="col-sm-4">
                            <select name="color[]" class="form-control select2" multiple="multiple">
                                <?php
                                $is_select = '';
                                $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    if (isset($color_id)) {
                                        if (in_array($row['color_id'], $color_id)) {
                                            $is_select = 'selected';
                                        } else {
                                            $is_select = '';
                                        }
                                    }
                                ?>
                                    <option value="<?php echo $row['color_id']; ?>" <?php echo $is_select; ?>><?php echo $row['color_name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
                        <div class="col-sm-4" style="padding-top:4px;">
                            <img src="../assets/uploads/<?php echo $p_featured_photo; ?>" alt="" style="width:150px;">
                            <input type="hidden" name="current_photo" value="<?php echo $p_featured_photo; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Change Featured Photo </label>
                        <div class="col-sm-4" style="padding-top:4px;">
                            <input type="file" name="p_featured_photo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Other Photos</label>
                        <div class="col-sm-4" style="padding-top:4px;">
                            <table id="ProductTable" style="width:100%;">
                                <tbody>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                    $statement->execute(array($_REQUEST['id']));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="../assets/uploads/product_photos/<?php echo $row['photo']; ?>" alt="" style="width:150px;margin-bottom:5px;">
                                            </td>
                                            <td style="width:28px;">
                                                <a onclick="return confirmDelete();" href="product-other-photo-delete.php?id=<?php echo $row['pp_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" class="btn btn-danger btn-xs">X</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-2">
                            <input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-8">
                            <textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Short Description</label>
                        <div class="col-sm-8">
                            <textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_short_description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Features</label>
                        <div class="col-sm-8">
                            <textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"><?php echo $p_feature; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Conditions</label>
                        <div class="col-sm-8">
                            <textarea name="p_condition" class="form-control" cols="30" rows="10" id="editor4"><?php echo $p_condition; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Return Policy</label>
                        <div class="col-sm-8">
                            <textarea name="p_return_policy" class="form-control" cols="30" rows="10" id="editor5"><?php echo $p_return_policy; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Is Featured?</label>
                        <div class="col-sm-8">
                            <select name="p_is_featured" class="form-control" style="width:auto;">
                                <option value="0" <?php if ($p_is_featured == '0') {
                                                        echo 'selected';
                                                    } ?>>No</option>
                                <option value="1" <?php if ($p_is_featured == '1') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Is Active?</label>
                        <div class="col-sm-8">
                            <select name="p_is_active" class="form-control" style="width:auto;">
                                <option value="0" <?php if ($p_is_active == '0') {
                                                        echo 'selected';
                                                    } ?>>No</option>
                                <option value="1" <?php if ($p_is_active == '1') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                            </select>
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