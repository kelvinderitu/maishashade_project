<?php require_once('pass-head.php'); ?>

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

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['cust_password'])) {
        $valid = 0;
        $error_message ='New Password Cannot be Empty';
    }

    if($valid == 1) {

        // update data into the database
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=? WHERE cust_id=?");
        $statement->execute(array(
                    strip_tags($_POST['cust_password']),
                    $_SESSION['customer']['cust_id']
                ));  
       
        $success_message ='Password updated successfully';

        $_SESSION['customer']['cust_password'] = $_POST['cust_password'];
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
                    <h3>
                        Password Reset
                    </h3>
                    <?php
                    if($error_message != '') {
                        echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                    }
                    if($success_message != '') {
                        echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                    }
                    ?>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                                <input type="hidden" class="form-control" readonly value="<?php echo $_SESSION['customer']['cust_password']; ?>">
                         
                            <div class="col-md-6 form-group">
                                <label for="">Enter New Password</label>
                                <input type="text" class="form-control" name="cust_password" >
                            </div>
                        
                            
                        </div>
                        <input type="submit" class="btn btn-primary" value="Reset" name="form1">
                    </form>
                </div>   <hr>
                <button class="btn btn-sm btn-success"><a href="logout.php"><font color="black">Login</font></a></button>             
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>