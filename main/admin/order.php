<?php require_once('header.php'); ?>

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
		<h3>Orders</h3>
	</div>
</section>


<section class="content">

  <div class="row">
    <div class="col-md-12">


      <div class="box box-success">
        
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-hover table-striped">
			<thead>
			    <tr>
			        <th>#</th>
                    <th>Customer</th>
			        <th>Product Details</th>
                  <!--  <th>
                    	Payment Information
                    </th>
                    <th>Paid Amount</th>-->
                    <th>Order Status</th>
                    <th>Payment Status</th>
                    <th>Destiantion Details</th>
                    <th>Materials Needed</th>
                    <th>Designer Assigned</th>
                    <th>Shipping Status</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by id DESC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr class="<?php if($row['payment_status']=='Pending'){echo 'bg';}else{echo 'bg';} ?>">
	                    <td><?php echo $i; ?></td>
	                    <td>
                           
                            <b>Name:</b><br> <?php echo $row['customer_name']; ?><br>
                            <b>Email:</b><br> <?php echo $row['customer_email']; ?><br><br>
                           
                        </td>
                        <td>
                           <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                           $statement1->execute(array($row['payment_id']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo '<b>Product:</b> '.$row1['product_name'];
                                echo '<br>(<b>Size:</b> '.$row1['size'];
                                echo ', <b>Color:</b> '.$row1['color'].')';
                                echo '<br>(<b>Quantity:</b> '.$row1['quantity'];
                                echo ', <b>Unit Price:</b> '.$row1['unit_price'].')';
                                echo '<br><br>';
                           }
                           ?>
                        </td><!--
                        <td>
                        	<?php if($row['payment_method'] == 'PayPal'): ?>
                        		<b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                        		<b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                        		<b>Date:</b> <?php echo $row['payment_date']; ?><br>
                        		<b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                        	<?php elseif($row['payment_method'] == 'Stripe'): ?>
                        		<b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                        		<b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
								<b>Date:</b> <?php echo $row['payment_date']; ?><br>
                        		<b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                        		<b>Card Number:</b> <?php echo $row['card_number']; ?><br>
                        		<b>Card CVV:</b> <?php echo $row['card_cvv']; ?><br>
                        		<b>Expire Month:</b> <?php echo $row['card_month']; ?><br>
                        		<b>Expire Year:</b> <?php echo $row['card_year']; ?><br>
                        	<?php elseif($row['payment_method'] == 'M-Pesa Deposit'): ?>
                        		<b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                        		<b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
								<b>Date:</b> <?php echo $row['payment_date']; ?><br>
                        		<b>Transaction Information:</b> <br><?php echo $row['bank_transaction_info']; ?><br>
                        	<?php endif; ?>
                        </td>
                        <td>Ksh<?php echo $row['paid_amount']; ?></td>-->
                        <td>
                            <?php echo $row['order_status']; ?>
                            <br><br>
                            <!--<?php
                                if($row['order_status']=='Pending'){
                                    if($row['payment_status']=='Completed'){
                                    ?>
                                    <a href="order-change-status.php?id=<?php echo $row['id']; ?>&task=Approved" class="btn btn-success btn-xs" style="width:100%;margin-bottom:4px;">Approve</a>
                                    <?php
                                }}
                            ?>-->
                        </td>
                        <td>
                            <?php echo $row['payment_status']; ?><br>
                            <b>Amount Paid :</b>Ksh<?php echo $row['paid_amount']; ?>
                            <br><br>
                        </td>
                        <td>
                            <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
                           $statement1->execute(array($row['customer_id']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo '<br><b>Location Details:</b> '.$row1['cust_s_address'];
                                echo '<br><b>County:</b> '.$row1['cust_s_city'];
                                echo '<br><br>';
                           }
                           ?>
                        </td>
                        <td><?php echo $row['materials']; ?></td>
                        <td><?php echo $row['technician']; ?></td>
                        
                        <td>
                            <?php echo $row['shipping_status']; ?>
                            <br><br>
                            <?php
                            if($row['payment_status']=='Completed') {
                                if($row['shipping_status']=='Pending'){
                                    ?>
                                    <?php
                                }
                            }
                            ?>
                        </td>
	                   
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