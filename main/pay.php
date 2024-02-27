<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if (!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <?php if (!isset($_SESSION['customer'])) : ?>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                <?php else : ?>
                    <center>
                        <h3>Payment Section</h3>
                    </center>
                    <h4 class="special"><?php echo LANG_VALUE_26; ?></h4>
                    <div class="cart">
                        <table class="hidden table table-responsive table-hover table-bordered">
                            <tr>
                                <th><?php echo '#' ?></th>
                                <th>Product Details</th>
                                <th><?php echo LANG_VALUE_47; ?></th>
                                <th><?php echo LANG_VALUE_159; ?></th>
                                <th><?php echo LANG_VALUE_55; ?></th>
                                <th class="text-right"><?php echo LANG_VALUE_82; ?></th>
                            </tr>
                            <?php
                            $table_total_price = 0;

                            $i = 0;
                            foreach ($_SESSION['cart_p_id'] as $key => $value) {
                                $i++;
                                $arr_cart_p_id[$i] = $value;
                            }


                            $i = 0;
                            foreach ($_SESSION['cart_p_qty'] as $key => $value) {
                                $i++;
                                $arr_cart_p_qty[$i] = $value;
                            }

                            $i = 0;
                            foreach ($_SESSION['cart_p_current_price'] as $key => $value) {
                                $i++;
                                $arr_cart_p_current_price[$i] = $value;
                            }

                            $i = 0;
                            foreach ($_SESSION['cart_p_name'] as $key => $value) {
                                $i++;
                                $arr_cart_p_name[$i] = $value;
                            }

                            $i = 0;
                            foreach ($_SESSION['cart_p_featured_photo'] as $key => $value) {
                                $i++;
                                $arr_cart_p_featured_photo[$i] = $value;
                            }
                            ?>
                            <?php for ($i = 1; $i <= count($arr_cart_p_id); $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                                    </td>
                                    <td><?php echo $arr_cart_p_name[$i]; ?><br></td>
                                    <td>Ksh<?php echo $arr_cart_p_current_price[$i]; ?></td>
                                    <td><?php echo $arr_cart_p_qty[$i]; ?></td>
                                    <td class="text-right">
                                        <?php
                                        $row_total_price = $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i];
                                        $table_total_price = $table_total_price + $row_total_price;
                                        ?>
                                        Ksh<?php echo $row_total_price; ?>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                            <tr>
                                <th colspan="7" class="total-text"><?php echo LANG_VALUE_81; ?></th>
                                <th class="total-amount">Ksh<?php echo $table_total_price; ?></th>
                            </tr>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                            $statement->execute(array($_SESSION['customer']['cust_country']));
                            $total = $statement->rowCount();
                            if ($total) {
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    $shipping_cost = $row['amount'];
                                }
                            } else {
                                $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    $shipping_cost = $row['amount'];
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="7" class="total-text"><?php echo LANG_VALUE_84; ?></td>
                                <td class="total-amount">Ksh<?php echo $shipping_cost; ?></td>
                            </tr>
                            <tr>
                                <th colspan="7" class="total-text"><?php echo LANG_VALUE_82; ?></th>
                                <th class="total-amount">
                                    <?php
                                    $final_total = $table_total_price + $shipping_cost;
                                    ?>
                                    Ksh<?php echo $final_total; ?>
                                </th>
                            </tr>
                        </table>
                    </div>




                    <div class="container ">
                        <ul>
                            <a href="cart.php" class="btn btn-primary pull-right"><?php echo LANG_VALUE_21; ?></a>
                        </ul>
                    </div>



                    <?php
                    $checkout_access = 1;
                    if (
                        ($_SESSION['customer']['cust_phone'] == '') ||
                        ($_SESSION['customer']['cust_country'] == '') ||
                        ($_SESSION['customer']['cust_s_address'] == '')
                    ) {
                        $checkout_access = 0;
                    }
                    ?>
                    <?php if ($checkout_access == 0) : ?>
                        <div class="col-md-12">
                            <div style="color:red;font-size:22px;margin-bottom:50px;">
                                Please Update The Shipping Information First<a href="customer-billing-shipping-update.php" style="color:red;text-decoration:underline;"></a>.
                            </div>
                        </div>
                    <?php else : ?>
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
                                </div>

                                </form>

                            </div>

                        </div>


            </div>
        <?php endif; ?>

        </div>


    <?php endif; ?>

    </div>
</div>
</div>
</div>


<?php require_once('footer.php'); ?>