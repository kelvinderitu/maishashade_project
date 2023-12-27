<?php
require_once('header.php');

// Check if the customer is logged in or not
if (!isset($_SESSION['customer'])) {
    header('location: ' . BASE_URL . 'logout.php');
    exit;
} else {
    // If customer is logged in, but admin makes him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'], 0));
    $total = $statement->rowCount();
    if ($total) {
        header('location: ' . BASE_URL . 'logout.php');
        exit;
    }
}

$error_message = '';
$success_message = '';

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['cust_password']) || empty($_POST['cust_re_password'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_138 . "<br>";
    }

    if (!empty($_POST['cust_password']) && !empty($_POST['cust_re_password'])) {
        if ($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139 . "<br>";
        }
    }

    if ($valid == 1) {
        // update data into the database
        $password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=? WHERE cust_id=?");

        try {
            $statement->execute(array($password, $_SESSION['customer']['cust_id']));
            $success_message = LANG_VALUE_141;
        } catch (PDOException $e) {
            $error_message = "Error updating password: " . $e->getMessage();
        }
    }
}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <button class="btn btn-info btn-sm"><a href="index.php"><font color="black"><i
                                    class="fa fa-arrow-left"></i> Back</font></a></button>
                    <h3 class="text-center">
                        <font color="red"><?php echo LANG_VALUE_99; ?></font>
                    </h3>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <?php
                                if ($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>"
                                        . $error_message . "</div>";
                                }
                                if ($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>"
                                        . $success_message . "</div>";
                                }
                                ?>
                                <div class="form-group">
                                    <label for=""><font color="black">Enter New Password *</font></label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label for=""><font color="black">Re-Enter New Password *</font></label>
                                    <input type="password" class="form-control" name="cust_re_password">
                                </div>
                                <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_5; ?>"
                                    name="form1">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
