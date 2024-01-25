<?php
require_once('header.php');
include("config.php");

$success_message = "";
$error_message = '';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nyabondobricks";
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if (empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Message can not be empty\n';
    }

    if ($valid == 1) {
        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Getting Customer Email Address
        $stmt = $mysqli->prepare("SELECT cust_email FROM tbl_customer WHERE cust_id=?");
        $stmt->bind_param("i", $_POST['cust_id']);
        $stmt->execute();
        $stmt->bind_result($cust_email);
        $stmt->fetch();
        $stmt->close();

        // Getting Admin Email Address
        $stmt = $mysqli->prepare("SELECT contact_email FROM tbl_settings WHERE id=1");
        $stmt->execute();
        $stmt->bind_result($admin_email);
        $stmt->fetch();
        $stmt->close();

        $order_detail = '';
        $stmt = $mysqli->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $stmt->bind_param("i", $_POST['payment_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {


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
            // Rest of your code...
        }

            
        

        $i = 0;
        $stmt = $mysqli->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $stmt->bind_param("i", $_POST['payment_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {

            $i++;
            $order_detail .= '
<br><b><u>Product Item ' . $i . '</u></b><br>
Product Name: ' . $row['product_name'] . '<br>
Size: ' . $row['size'] . '<br>
Color: ' . $row['color'] . '<br>
Quantity: ' . $row['quantity'] . '<br>
Unit Price: ' . $row['unit_price'] . '<br>
            ';
            // Rest of your code...
        }
           
        

        $stmt = $mysqli->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
        $stmt->bind_param("sssi", $subject_text, $message_text, $order_detail, $_POST['cust_id']);
        $stmt->execute();
        $stmt->close();

        // sending email
        $to_customer = $cust_email;
        $message = '<html><body><h3>Message: </h3>' . $message_text . '<h3>Order Details: </h3>' . $order_detail . '</body></html>';
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



<?php
$error_message = '';
if (isset($_POST['form1'])) {
    $valid = 1;
    // ... (your existing validation code)

    if ($valid == 1) {
        // ... (your existing code)

        // Update quantity (assuming $row['toolbox_name'] is available)
        $toolbox_name = $row['toolbox_name'];
        $updateToolbox = $pdo->prepare("UPDATE tbl_request_toolbox SET quantity = quantity - 1 WHERE toolbox_name = ?");
        $updateToolbox->execute(array($toolbox_name));

        // ... (your existing code)
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
        <h3>Requested Toolbox</h3>
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
                                <th>Name</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_bookings WHERE technician_request=''");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['technician']; ?></td>
                                    <td>
                                        <?php echo $row['technician_request']; ?><br><br>
                                        <?php
                                        if ($row['technician_request'] == '') {
                                        ?>
                                            <a href="request-status.php?id=<?php echo $row['id']; ?>&task=submitted" class="btn btn-success btn-xs" style="width:50%;margin-bottom:4px;">Approve</a>
                                        <?php
                                            // Update quantity when Approve button is clicked
                                            $toolbox_name = $row['toolbox_name'];
                                            $updateToolbox = $pdo->prepare("UPDATE tbl_request_toolbox SET quantity = quantity - 1 WHERE toolbox_name = ?");
                                            $updateToolbox->execute(array($toolbox_name));
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