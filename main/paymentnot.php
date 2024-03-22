<?php
$host = 'localhost';
$dbname = 'maishashades';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

// Fetch data from tbl_bank
$statementBank = $pdo->prepare("SELECT * FROM tbl_bank");
$statementBank->execute();
$resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    // Your form submission logi
    $id = $_POST["id"];
    $bank_list = $_POST["bank_list"];
    $bank = $_POST["Bank"];
    $payment_date = $_POST['payment_date'];
    $transaction_info = $_POST["transaction_info"];
    $amount=$_POST['amount'];
    if (empty($_POST['transaction_info'])) {
        header('location: SpecialOrderRequest.php');
    } else {

        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $payment_date = date('Y-m-d H:i:s');
        $payment_id = time();
        $transaction_info = test_input($_POST['transaction_info']);
        $per = 'M1OPQRST6U8V2X3ABCDEFG45NYZ7W9HIJ0KL';
        $newS = substr(str_shuffle($per), 0, 8);

        $naming = "/^(?=.*[A-Z])(?=.*[0-9])/";

        if (!preg_match($naming, $transaction_info)) {
            echo '<div class="alert alert-warning">Enter valid Transaction codes!</div>';
        } else {


            // Update query using prepared statement
            $updateQry = "UPDATE tbl_specialorders SET Bank_list=?, Bank_Name=?, payment_date=?,transaction_info=?,paid_amount=?WHERE id=?";
            $updateStatement = $pdo->prepare($updateQry);

            // Execute the prepared statement
            $updateResult = $updateStatement->execute([$bank_list, $bank, $payment_date, $transaction_info,$amount,$id]);

            if (!$updateResult) {
                echo "ERROR" . implode(" ", $updateStatement->errorInfo());
            } else {
                echo '<div class="alert alert-success">Payment made successfully!</div>';
            }
        }
    }
    $statement = $pdo->prepare("UPDATE tbl_specialorders SET order_status=? WHERE id=?");
    $statement->execute(array($_REQUEST['task'], $_REQUEST['id']));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../icofont/icofont.min.css">

</head>

<body>



    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="page-header">PAYMENT </h5>
                    <a class="btn btn-sm btn-warning" href="SpecialOrderRequest.php?dashboard">Back</a>
                </div><br>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <?php
                                    $id = $_GET['id'];
                                    $qry = "SELECT * FROM tbl_specialorders WHERE id=?";
                                    $statement = $pdo->prepare($qry);
                                    $statement->execute([$id]);
                                    $row = $statement->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                    <form role="form" action="" method="post">
                                        <div class="form-group">
                                            <label>Customer Name</label>
                                            <input class="form-control" type="text" readonly name="customer_fullName" value='<?php echo $row['customer_fullName']; ?>' required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Amount </label>
                                            <input class="form-control" type="text" readonly name="amount" value='<?php echo $row['paymenttobemade']; ?>' required>
                                        </div>



                                        <label for=""><?php echo "BANK " ?> *</label>
                                        <select name="bank_list" class="form-control select2" required>
                                            <option value=""><?php echo "choose any bank" ?></option>

                                            <?php
                                            // Display options based on the fetched data
                                            foreach ($resultBank as $bank) {
                                                $optionValue = $bank['BankName'] . ' - ' . $bank['BankAccountNumber'];
                                                echo '<option value="' . $optionValue . '">' . $optionValue . '</option>';
                                            }
                                            ?>
                                        </select><br>
                                        <label for=""><?php echo "BANK NAME " ?> *</label>
                                        <select name="Bank" class="form-control select2">
                                            <option value=""><?php echo "SELECT" ?></option>

                                            <?php
                                            // Fetch data from tbl_bank
                                            $statementBank = $pdo->prepare("SELECT * FROM tbl_bank");
                                            $statementBank->execute();
                                            $resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

                                            // Display options based on the fetched data
                                            foreach ($resultBank as $bank) {
                                                echo '<option value="' . $bank['BankName'] . '">' . $bank['BankName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="form-group">
                                            <label>Payment Date</label>
                                            <input class="form-control" type="date" name="payment_date" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Transaction Codes</label>
                                            <input class="form-control" type="text" maxlength="10" minlength="10" name="transaction_info" required>
                                        </div>


                                        <!-- id hidden grna input type ma "hidden" -->
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                    </form>

                                </div>
                                <?php

                                ?>

                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


</body>


<style>
    footer {
        background-color: #424558;
        bottom: 0;
        left: 0;
        right: 0;
        height: 35px;
        text-align: center;
        color: #CCC;
    }

    footer p {
        padding: 10.5px;
        margin: 0px;
        line-height: 100%;
    }
</style>

</html>