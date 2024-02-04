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
                        <h3>Shipping Address </h3>
                    </center>
                    <div class="cart">


                        <?php
                        $table_total_price = 0;

                        $i = 0;
                        foreach ($_SESSION['cart_p_id'] as $key => $value) {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i = 0;
                        foreach ($_SESSION['cart_size_id'] as $key => $value) {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i = 0;
                        foreach ($_SESSION['cart_size_name'] as $key => $value) {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i = 0;
                        foreach ($_SESSION['cart_color_id'] as $key => $value) {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i = 0;
                        foreach ($_SESSION['cart_color_name'] as $key => $value) {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
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

                        <?php endfor; ?>

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

                    </div>



                    <div class="col-md-6">
                        <table class="table table-responsive table-bordered table-hover table-striped bill-address">

                            <tr>
                                <td>County To Deliver</td>
                                <td>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                    $statement->execute(array($_SESSION['customer']['cust_country']));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        echo $row['country_name'];
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Detailed Location Information</td>
                                <td>
                                    <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Customer Name</td>
                                <td><?php echo $_SESSION['customer']['cust_name']; ?> <?php echo $_SESSION['customer']['cust_lname']; ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td><?php echo $_SESSION['customer']['cust_phone']; ?></td>
                            </tr>
                        </table>
                        <div style="float: right;">
                            <a href="customer-billing-shipping-update.php" class="btn btn-primary">Update</a>
                        </div>
                        <div class="container">
                            <ul>
                                <a href="cart.php" class="btn btn-default"><?php echo LANG_VALUE_21; ?></a>
                            </ul>
                        </div>
                    </div>

            </div>
        </div><br>



        <div class="clear"></div>
        <div class="row">

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

                        <br>
                        <hr>
                        <!-- <form class="paypal" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php" method="post" id="paypal_form" target="_blank">
                                        <input type="hidden" name="cmd" value="_xclick" />
                                        <input type="hidden" name="no_note" value="1" />
                                        <input type="hidden" name="lc" value="UK" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />

                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_46; ?>" name="form1">
                                        </div>
                                    </form>
                        -->





                    </div>
                <?php endif; ?>

                </div>


            <?php endif; ?>

        </div>
    </div>
</div>
</div>


<?php require_once('footer.php'); ?>