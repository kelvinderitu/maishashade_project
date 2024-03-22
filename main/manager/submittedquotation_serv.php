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

<center><div class="col-md-4 logo">
			<h3>Maisha car parking shades and Carports Limited</h3><br>
		     Kimathi House, Nairobi CBD<br>
			Nairobi, Kenya<br>
			Office Tel. +2547060712320<br>
			
			Email: info@maishashades.co.ke
			</div>
</center>


<section class="content">

  <div class="row">
    <div class="col-md-12">


      <div class="box box-success">
        
        <div class="box-body table-responsive">
          <table id="example1" class="table  table-hover table-striped">
			<thead>
			    <tr>
			        <th>#</th>
                    <th>CUSTOMER</th>
                    <th>SERVICE </th> 
                    <th>BOOKED ON </th> 
                    <th>TRAINING PERIOD </th> 
			        <th>REPORT </th>   
                    <th>TRAINING STATUS </th>  
                    <th>CERTIFICATE </th>  
                    <th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
                
               
            	$i=0;
                $id=$_GET['id']; 
            	$statement = $pdo->prepare("SELECT * FROM tbl_bookings WHERE  photographer_status='Completed' and id='$id'");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td>
                            <b>Name:</b><br> <?php echo $row['full_name']; ?><br>
                            <b>Phone:</b><br> <?php echo $row['phone']; ?><br><br>
                           
                        </td>
                        <td>
                       <?php echo $row['service']; ?>
                        </td>
                        <td>
                       <?php echo $row['bdate']; ?>
                        </td>
                        <td>
                       <b>Start Date :</b> <?php echo $row['sdate']; ?><br>
                       <b>End Date :</b> <?php echo $row['sdate']; ?><br>
                    </td>
                        <td>
                       <?php echo $row['recommandation']; ?>
                        </td>
                        <td>
                        <?php echo $row['photographer_status']; ?>
                        </td>
                        <td>
                        <?php echo $row['cert']; ?>
                        </td>
                        <td>
                        <?php
                                if($row['cert']=='Not Yet Issued'){
                                    ?>
                                    <a href="cert-change-status-serv.php?id=<?php echo $row['id']; ?>&task=Issued" class="btn btn-primary btn-md" >Issue Certificate</a>
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


