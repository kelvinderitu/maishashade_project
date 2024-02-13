<?php
require_once('header.php');
$con = new mysqli('localhost', 'root', '', 'nyabondobricks');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>

<section class="content-header">
    <center>
        <h1> Request For An Order</h1>
    </center>
</section>

<?php
ini_set('error_reporting', E_ALL);

// Setting up the time zone
date_default_timezone_set('America/Los_Angeles');

// Host Name
$dbhost = 'localhost';

// Database Name
$dbname = 'nyabondobricks';

// Database Username
$dbuser = 'root';

// Database Password
$dbpass = '';



try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error :" . $exception->getMessage();
}
$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
$statement->execute();
$total_top_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
$statement->execute();
$total_mid_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_end_category");
$statement->execute();
$total_end_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_services where status='Active'");
$statement->execute();
$pendingpayment = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_status='1'");
$statement->execute();
$total_customers = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_active='1'");
$statement->execute();
$total_subscriber = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost");
$statement->execute();
$available_shipping = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Completed'));
$total_order_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment");
$statement->execute();
$paymentrecord = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Completed'));
$completedpayment = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer_message");
$statement->execute();
$messages = $statement->rowCount();

if (isset($_POST['add_product_btn'])) {

    $county = $_POST['county'];
    $detail_location = $_POST['location'];
    $carspaces = $_POST['carspaces'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $path = "uploads/";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    // Assuming $_SESSION['customer']['cust_lname'] is the correct key
    $full_name = $_SESSION['customer']['technician'] . ' ' . $_SESSION['customer']['cust_lname'];

    $statement = $pdo->prepare("INSERT INTO tbl_specialorders( 
        customer_id,
        customer_fullName,
        customer_email,
        customer_phone,
        county,
        detail_location,
        carspaces,
        description, 
        image
    ) VALUES (?,?,?,?,?,?,?,?,?)");
    $statement->execute(array(
        $_SESSION['customer']['cust_id'],
        $full_name,
        $_SESSION['customer']['cust_email'],
        $_SESSION['customer']['cust_phone'],
        $county,
        $detail_location,
        $carspaces,
        $description,
        $filename
    ));

    move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
    header("Location: ../index.php");
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <label for=""> COUNTY OF DELIVERY*</label>
                            <select name="county" class="form-control select2">
                                <option value=""><?php echo "SELECT YOUR COUNTY" ?></option>

                                <?php
                                // Fetch data from tbl_bank
                                $statementBank = $pdo->prepare("SELECT * FROM tbl_country");
                                $statementBank->execute();
                                $resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

                                // Display options based on the fetched data
                                foreach ($resultBank as $bank) {
                                    echo '<option value="' . $bank['country_name'] . '">' . $bank['country_name'] . '</option>';
                                }
                                ?>
                            </select>


                            <div class="col-md-12">
                                <label forclass="mb-0"> Specific Detailed Location</label>
                                <textarea rows="3" columns="4" required name="location" placeholder="Enter  Specific Location Of the Installation Of the Material Requested" class="form-control mb-2"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="mb-0"> Number Of Carspaces</label>
                                <input type="number" required name="carspaces" placeholder="Enter Number of CarSpaces " class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label forclass="mb-0"> Description</label>
                                <textarea rows="3" columns="4" required name="description" placeholder="Enter  Features of the shade i.e color" class="form-control mb-2"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" required name="image" class="form-control mb-2"><br><br>
                            </div>
                            <br><br>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_product_btn">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>