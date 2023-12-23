<?php require_once('header1.php'); ?>

<?php
$error_message = '';
if(isset($_POST['form1'])) {
    $valid = 1;
    if(empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if(empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if($valid == 1) {

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
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
        	
        	if($row['payment_method'] == 'PayPal'):
        		$payment_details = '
Transaction Id: '.$row['txnid'].'<br>
        		';
        	elseif($row['payment_method'] == 'Stripe'):
				$payment_details = '
Transaction Id: '.$row['txnid'].'<br>
Card number: '.$row['card_number'].'<br>
Card CVV: '.$row['card_cvv'].'<br>
Card Month: '.$row['card_month'].'<br>
Card Year: '.$row['card_year'].'<br>
        		';
        	elseif($row['payment_method'] == 'Bank Deposit'):
				$payment_details = '
Transaction Details: <br>'.$row['bank_transaction_info'];
        	endif;

            $order_detail .= '
Customer Name: '.$row['customer_name'].'<br>
Customer Email: '.$row['customer_email'].'<br>
Payment Method: '.$row['payment_method'].'<br>
Payment Date: '.$row['payment_date'].'<br>
Payment Details: <br>'.$payment_details.'<br>
Paid Amount: '.$row['paid_amount'].'<br>
Payment Status: '.$row['payment_status'].'<br>
Shipping Status: '.$row['shipping_status'].'<br>
Payment Id: '.$row['payment_id'].'<br>
            ';
        }

        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item '.$i.'</u></b><br>
Product Name: '.$row['product_name'].'<br>
Size: '.$row['size'].'<br>
Color: '.$row['color'].'<br>
Quantity: '.$row['quantity'].'<br>
Unit Price: '.$row['unit_price'].'<br>
            ';
        }

        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
        $statement->execute(array($subject_text,$message_text,$order_detail,$_POST['cust_id']));

        // sending email
        $to_customer = $cust_email;
        $message = '
<html><body>
<h3>Message: </h3>
'.$message_text.'
<h3>Order Details: </h3>
'.$order_detail.'
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
if($error_message != '') {
    echo "<script>alert('".$error_message."')</script>";
}
if($success_message != '') {
    echo "<script>alert('".$success_message."')</script>";
}
?>

<section class="content-header">
	<div class="content-header-left">
		<center><h4>FEEDBACK REPORTS</h4></center>
	</div>
</section>
<div class="container">
    <button id="printButton" onclick="printPage()"><font color="black">Print</font></button>
    <style>
        .button-container {
    display: inline-block;
    margin-right: 20px; /* Adjust the margin as needed */
}

#printButton {
    float: right;
}

    </style>
</div>
<div class="container">
<button><a href="dashboard.php"><font color="black">Back</font></a></button>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-body table-responsive table-bordered">
                    <!--<div class="container">
                        <button class="btn btn-sm btn-primary"><a href="sendmsg.php"><font color="white"><i
                                        class="fa fa-edit"></i>&nbsp;Compose New</font></a></button>
                    </div><br>-->
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Sender</th>
                            <th>Recipient</th>
                            <!--<th>Action</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;
                        $statement = $pdo->prepare("SELECT * FROM `tbmessages`");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['message']; ?></td>
                                <td><?php echo $row['date']; ?></td>

                                <?php
                                $statement1 = $pdo->prepare("SELECT * FROM tbl_staff WHERE id=?");
                                $statement1->execute(array($row['user_id']));
                                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                $sender = '';
                                foreach ($result1 as $row1) {
                                    $sender = $row1['role'];
                                }
                                ?>
                                 <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
                           $statement1->execute(array($row['user_id']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                            
                            $sender=$row1['cust_name'] .$row1['cust_lname'];
                           }
                           ?>

                                <td><?php echo $sender; ?></td>

                                <?php
                                $statement2 = $pdo->prepare("SELECT * FROM tbl_staff WHERE id=?");
                                $statement2->execute(array($row['recepient']));
                                $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                $recipient = '';
                                foreach ($result2 as $row2) {
                                    $recipient = $row2['role'];
                                }
                                ?>
                                <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
                           $statement1->execute(array($row['recepient']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                            
                            $recepient=$row1['cust_name'] .$row1['cust_lname'];
                           }
                           ?>

                                <td><?php echo $recipient; ?></td>

                                <!--<td>
                                    <?php
                                    if ($row['fname'] == '') {
                                        ?>
                                        <a href="reply.php?id=<?php echo $row['id']; ?>"
                                           class="btn btn-warning btn-exsm">Reply</a>
                                        <?php
                                    }
                                    ?>
                                </td>-->
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
function printPage() {
    window.print();
}
</script>