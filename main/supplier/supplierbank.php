<?php require_once('header.php'); ?>

<?php
// Your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "nyabondobricks";

// Create connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the delete button is clicked
if (isset($_POST['delete_button'])) {
    // Get the ID of the row to be deleted
    $idToDelete = $_POST['row_id'];

    // SQL to delete a row with a specific ID
    $sql = "DELETE FROM tbl_supplierbank WHERE id = $idToDelete";

    if ($con->query($sql) === TRUE) {
        echo '<div class="alert alert-success">deleted successfully!</div>';
        echo '<script>
                setTimeout(function(){
                    document.getElementById("success-message").style.display = "none";
                }, 3000);
             </script>';
       
    } else {
        echo "Error deleting record: " . $con->error;
    }
}

// Fetch data from the table for display
$result = $con->query("SELECT * FROM your_table");
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
        <h3>Bank Details</h3>
    </div>

    <div class="content-header-right">
        <a href="addbank.php" class="btn btn-success btn-xs">Add Bank</a>
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
                                <th>Bank Name</th>
                                <th>Bank Account Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_supplierbank WHERE BankName != '' ORDER BY id DESC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr data-id="<?php echo $row['id']; ?>">
                                    <td><?php echo $i; ?></td>


                                    <td><?php echo $row['BankName']; ?></td>
                                    <td><?php echo $row['BankAccountNumber']; ?></td>
                                    <td>
                                        <a href="updatebank.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs">Update</a><br>
                                        <form method='post'>
                                            <input type='hidden' name='row_id' value=<?php echo $row['id']?>>
                                            <button type='submit' name='delete_button' style="background-color: red; color: white; border:0cap">Delete</button>
                                        </form>
                                        
                                    </td>
                                    
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
                <button type="button" class="btn btn-danger btn-ok" id="delete-btn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

