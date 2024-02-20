<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if (!isset($_SESSION['customer'])) {
    header('location: ' . BASE_URL . 'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'], 0));
    $total = $statement->rowCount();
    if ($total) {
        header('location: ' . BASE_URL . 'logout.php');
        exit;
    }
}
?>

<?php
if (isset($_POST['form1'])) {


    // update data into the database
    $statement = $pdo->prepare("UPDATE tbl_customer SET 
                            cust_country=?, 
                            cust_s_address=?

                            WHERE cust_id=?");
    $statement->execute(array(
        strip_tags($_POST['cust_country']),
        strip_tags($_POST['cust_s_address']),
        $_SESSION['customer']['cust_id']
    ));

    $success_message = 'Shipping Information Updated successfully';

    $_SESSION['customer']['cust_country'] = strip_tags($_POST['cust_country']);
    $_SESSION['customer']['cust_s_address'] = strip_tags($_POST['cust_s_address']);
    header("location:pay.php");
}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <?php
                    if ($error_message != '') {
                        echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $error_message . "</div>";
                    }
                    if ($success_message != '') {
                        echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $success_message . "</div>";
                    }
                    ?>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">

                        </div>
                        <div class="col-md-6">
                            <center>
                                <h3>
                                    <font color="black">Shipping Details</font>
                                    </h4>
                            </center>

                            <div class="form-group">
                                <label for="">
                                    <font color="black">County</font>
                                    </< /label>
                                    <select name="cust_country" class="form-control">
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                        ?>
                                            <option value="<?php echo $row['country_id']; ?>" <?php if ($row['country_id'] == $_SESSION['customer']['cust_country']) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row['country_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="">
                                    <font color="black">Provide Detailed Information Concerning Delivery Location</font>
                                    </< /label>
                                    <textarea name="cust_s_address" class="form-control" cols="30" rows="10" style="height:100px;"><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                            </div>
                            <div style="float: right;">
                                <input type="submit" class="btn btn-success" value="<?php echo LANG_VALUE_5; ?>" name="form1">
                            </div>
                            <div class="container">
                                <a href="cart.php" class="btn btn-default"><?php echo LANG_VALUE_21; ?></a>
                            </div>

                        </div>
                </div>



                </form>
            </div>
            <hr>

        </div>
    </div>
</div>
</div>


<?php require_once('footer.php'); ?>