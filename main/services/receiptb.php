<?php require_once('header.php'); ?>

<?php
$error_message = '';
if (isset($_POST['form1'])) {
    $valid = 1;
    if (empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if (empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if ($valid == 1) {

        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Getting Customer Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        $statement->execute(array($_POST['cust_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $cust_email = $row['cust_email'];
        }

        // Getting Admin Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }

        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=? AND payment_status='Completed'");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {

            if ($row['payment_method'] == 'PayPal') :
                $payment_details = '
Transaction Id: ' . $row['txnid'] . '<br>
        		';
            elseif ($row['payment_method'] == 'Stripe') :
                $payment_details = '
Transaction Id: ' . $row['txnid'] . '<br>
Card number: ' . $row['card_number'] . '<br>
Card CVV: ' . $row['card_cvv'] . '<br>
Card Month: ' . $row['card_month'] . '<br>
Card Year: ' . $row['card_year'] . '<br>
        		';
            elseif ($row['payment_method'] == 'Bank Deposit') :
                $payment_details = '
Transaction Details: <br>' . $row['bank_transaction_info'];
            endif;

            $order_detail .= '
Customer Name: ' . $row['customer_name'] . '<br>
Customer Email: ' . $row['customer_email'] . '<br>
Payment Method: ' . $row['payment_method'] . '<br>
Payment Date: ' . $row['payment_date'] . '<br>
Payment Details: <br>' . $payment_details . '<br>
Paid Amount: ' . $row['paid_amount'] . '<br>
Payment Status: ' . $row['payment_status'] . '<br>
Shipping Status: ' . $row['shipping_status'] . '<br>
Payment Id: ' . $row['payment_id'] . '<br>
            ';
        }

        $i = 0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item ' . $i . '</u></b><br>
Product Name: ' . $row['product_name'] . '<br>
Size: ' . $row['size'] . '<br>
Color: ' . $row['color'] . '<br>
Quantity: ' . $row['quantity'] . '<br>
Unit Price: ' . $row['unit_price'] . '<br>
            ';
        }

        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
        $statement->execute(array($subject_text, $message_text, $order_detail, $_POST['cust_id']));

        // sending email
        $to_customer = $cust_email;
        $message = '
<html><body>
<h3>Message: </h3>
' . $message_text . '
<h3>Order Details: </h3>
' . $order_detail . '
</body></html>
';
        $headers = 'From: ' . $admin_email . "\r\n" .
            'Reply-To: ' . $admin_email . "\r\n" .
            'X-Mailer: PHP/' . phpversion() . "\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Sending email to admin                  
        mail($to_customer, $subject_text, $message, $headers);

        $success_message = 'Your email to customer is sent successfully.';
    }
}
?>
<?php
if ($error_message != '') {
    echo "<script>alert('" . $error_message . "')</script>";
}
if ($success_message != '') {
    echo "<script>alert('" . $success_message . "')</script>";
}
?>

<section class="content-header">
    <div class="content-header-left">
        <center>
            <h4>
                <font color="red">MY BOOKING RECEIPT</font>
            </h4>
        </center>
    </div>
</section>


<section class="content">

    <div class="card">
        <div class="col-md-12">


            <div class="box box-info">

                <div class="box-body table-responsive table-bordered">
                    <table id="example1" class="table table-hover table-striped">
                        <thead>
                            <tr>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i = 0;
                            $id = $_GET['id'];
                            $statement = $pdo->prepare("SELECT * FROM tbl_bookings where id='$id' and cust_id='" . $_SESSION['customer']['cust_id'] . "'");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <center>
                                    <div class="card"><br>
                                     
                                        <center><img src ="../assets/uploads/log.png"></center><br>
                                        <b>CUSTOMER DETAILS</b><br>
                                        <b>Name:</b><br> <?php echo $row['cust_name'] . ' ' . $row['cust_lname']; ?><br>
                                        <b>Email:</b><?php echo $row['email']; ?><br>
                                        <b>Contact:</b><?php echo $row['phone']; ?><br>
                                    </div>
                                </center>
                                <hr>




                                <div class="container">
                                    <b>SERVICE: </b><?php echo $row['service']; ?>
                                    <br>

                                    <b>CHARGES :</b> Ksh <?php echo $row['charges']; ?><br>
                                    <b>FEE :</b> Ksh <?php echo $row['fee']; ?><br>
                                    <b>DURATION :</b> <?php echo $row['duration']; ?><br>
                                    <b>SERVICE PERIOD :</b>From <?php echo $row['sdate']; ?> To <?php echo $row['edate']; ?><br>
                                    <b> Booking Date :</b><?php echo $row['pdate']; ?><br>
                                    <hr>
                                    

                                    <b>AMOUNT PAID :</b> Ksh <?php echo $row['charges'] + $row['fee']; ?><br>
                                    <b>EQUITY BANK CODE :</b> <?php echo $row['transactioncode']; ?><br>
                                    <b>PAID ON :</b> <?php echo $row['bdate']; ?><br>
                                    <hr>

                                    <i> SERVED BY:</i>
                                    <br>
                                    <b> SUPERVISOR'S NAME:</b> <?php echo $row['supervisor']; ?><br>
                                    
                                    
                                    </tr>
                                <?php

                            }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>


</section>




<?php require_once('footer.php'); ?>
<script>
    function printPage() {
        window.print();
    }
</script>