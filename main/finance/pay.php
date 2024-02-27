<?php
if (isset($_POST['send2'])) {

    include 'dbconnect.php';
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id = $_POST["id"];
    $payStatus = $_POST["payStatus"];
    $Ref = test_input($_POST['Ref']);
    $per = 'M1OPQRST6U8V2X3ABCDEFG45NYZ7W9HIJ0KL';
    $newS = substr(str_shuffle($per), 0, 8);

    $naming = "/^(?=.*[A-Z])(?=.*[0-9])/";

    if (!preg_match($naming, $Ref)) {
        $error = "Please Enter a valid MPESA ID";
        header("Refresh:0.05; url=bookin_pay_error.php");
    } else {
        //update query
        $qry = "update requestsproduct set payStatus='$payStatus',Ref='$Ref' where id='$id'";
        $result = mysqli_query($conn, $qry); //query executes

        if (!$result) {
            echo "ERROR" . mysqli_error();
        } else {
            echo '<div class="alert alert-success">payment made successfully!</div>';
        }
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>


<div class="col-md-4">

    <div class="row">


        <div class="col-md-12 form-group">
            <label for=""><?php echo LANG_VALUE_34; ?> *</label>
            <select name="payment_method" class="form-control select2" id="advFieldsStatus">
                <option value=""><?php echo "PROCEED WITH PAYMENT" ?></option>
                <option value="Bank Deposit">PAYMENT</option>


            </select><br>

            <br><br>

            <form action="payment/bank/init.php" method="post" id="bank_form">

                <div class="container"><b>Total Amount</b><br>
                    <input type="text" readonly name="amount" value="<?php echo $final_total; ?>">
                </div><br>
                <div class="container"><b>Shipping Cost</b><br>
                    <input type="text" readonly name="shipping_fee" value="<?php echo $shipping_cost; ?>">
                </div><br>



                <label for=""><?php echo "BANK " ?> *</label>
                <select name="Bank_List" class="form-control select2" id="advFieldsStatus">
                    <option value=""><?php echo "choose any bank" ?></option>

                    <?php
                    // Fetch data from tbl_bank
                    $statementBank = $pdo->prepare("SELECT * FROM tbl_bank");
                    $statementBank->execute();
                    $resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

                    // Display options based on the fetched data
                    foreach ($resultBank as $bank) {
                        $optionValue = $bank['BankName'] . ' - ' . $bank['BankAccountNumber'];
                        echo '<option value="' . $optionValue . '">' . $optionValue . '</option>';
                    }
                    ?>
                </select>



                <label for=""><?php echo "BANK NAME " ?> *</label>
                <select name="Bank" class="form-control select2" id="advFieldsStatus">
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

                <div class="col-md-12 form-group">
                    <label for="">Transaction Id <br><span style="font-size:12px;font-weight:normal;">(Input the Transaction Id Correctly)</span></label>
                    <textarea name="transaction_info" minlength="10" maxlength="10" required class="form-control" cols="30" rows="2"></textarea>
                </div>

                <div class="col-md-12 form-group">
                    <input type="submit" class="btn btn-primary" value="Submit" name="form3">
                </div>

            </form>

        </div>

    </div>


</div>


</div>




</div>
</div>
</div>
</div>


<?php require_once('footer.php'); ?>