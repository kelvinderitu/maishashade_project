<?php require_once('header2.php'); ?>

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
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=? AND payment_status='Pending'");
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
		<h3>My Pending Task</h3>
	</div>
</section>


<section class="content">

  <div class="row">
    <div class="col-md-12">


      <div class="box box-info">
        
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-hover table-striped">
			<thead>
			    <tr>
			        <th>#</th>
                    <th>Customer</th>
			        <th>Service </th>  
                    <th>Booked On </th> 
                    <th>Service Period </th> 
                    <th>Supervisor</th>                
                    <th>Location Details</th>
                    <th>Completion Status</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_bookings WHERE  supervisor_status='pending' and supervisor='".$_SESSION['user']['full_name']."'");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
	                    <td><?php echo $i; ?></td>
                        <td>
    <b>Name:</b><br> <?php echo $row['cust_name'] . ' ' . $row['cust_lname']; ?><br>
    <b>Email:</b><br> <?php echo $row['email']; ?><br><br>
</td>

                        <td>
                           <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_services WHERE servicename=?");
                           $statement1->execute(array($row['service']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo '<b>Name:</b> '.$row1['servicename'];
                                echo '<br>';
                           }
                           ?>
                           <b>Duration :</b> <?php echo ($row['duration']); ?><br>
                        </td>
                        <td>
                        <?php echo ($row['bdate']); ?><br>
                        </td>
                        <td>
                       <b>Start Date :</b> <?php echo ($row['sdate']); ?><br>
                       <b>End Date :</b><?php echo ($row['edate']); ?><br>
                        </td>
                        <td>
                        <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_staff WHERE full_name=?");
                           $statement1->execute(array($row['supervisor']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo '<b>Name:</b> '.$row1['full_name'];
                                echo '<br><b>Phone:</b> '.$row1['phone'];
                                echo '<br><br>';
                           }
                           ?>
                    </td>
                        <td>                          
                        <b>County :</b><?php echo $row['county']; ?><br>
                        <b>Location Details :</b><?php echo $row['location']; ?>
                        </td>
                        <td>
                            <?php echo $row['supervisor_status']; ?>
                            <br><br>
                            <!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
    // Check if the button is clicked
    if (isset($_POST['complete'])) {
        // Perform some action when the "Complete" button is clicked
        echo "";
    }
    ?>

    <!--<form method="post">
        Your content here
        
        The "Complete" button 
        <input type="submit" name="complete" value="Complete">
    </form>-->
</body>
</html>

                            <!--<?php
                            if($row['lndsize']=='0') {
                                    ?>
                                    <a href="quotations.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-md" >Add Report</a>
                                    <?php
                            }
                            ?>-->
                           <?php
                            if($row['supervisor_status']=='Pending') {
                                    ?>
                                    <a href="delivery-change-status.php?id=<?php echo $row['id']; ?>&task=Complete" class="btn btn-success btn-xs" style="width:100%;margin-bottom:4px;">Service Complete</a>
                                    <?php
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


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>