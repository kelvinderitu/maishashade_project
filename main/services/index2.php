<?php require_once('header.php');
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
    $cust_name = $_POST['cust_name'];
    $cust_email = $_POST['cust_email'];
    $cust_phone = $_POST['cust_phone'];
    $county = $_POST['county'];
    $detail_location = $_POST['location'];
    $carspaces = $_POST['carspaces'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $path = "uploads/";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO tbl_specialorders(customer_fullName,customer_email,customer_phone,county,detail_location,carspaces, description, image)
            VALUES ('$cust_name','$cust_email','$cust_phone','$county','$detail_location','$carspaces','$description', '$filename')";

    if (mysqli_query($con, $sql)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        header("Location: ../index.php");
        echo "added successfully";
    } else {

        
        echo "something went wrong";
    }

    mysqli_close($con);
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0"> Customer full Name</label>
                                <input type="text" required name="cust_name" placeholder="Enter Number of CarSpaces you May want" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0"> Customer email</label>
                                <input type="text" required name="cust_email" placeholder="Enter Your Email" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0"> Customer phone number</label>
                                <input type="text" required name="cust_phone" placeholder="Enter  Your Phone Number" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0"> County</label>
                                <input type="text" required name="county" placeholder="Enter Your County" class="form-control mb-2">
                            </div>
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