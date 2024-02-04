<?php

include('conn.php');
include('header.php');



if (isset($_POST['add_product_btn'])) {
    $cust_name=$_POST['cust_name'];
    $cust_email=$_POST['cust_email'];
    $cust_phone=$_POST['cust_phone'];
    $county=$_POST['county'];
    $detail_location=$_POST['location'];
    $carspaces = $_POST['carspaces'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $path = "uploads";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO tbl_specialorders(customer_fullName,customer_email,customer_phone,county,detail_location,carspaces, description, image)
            VALUES ('$cust_name','$cust_email','$cust_phone','$county','$detail_location','$carspaces','$description', '$filename')";

    if (mysqli_query($con, $sql) && ($name != "" && $slug != "")) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        header("Location: SpecialOrderRequest.php");
        echo "added successfully";
    } else {
        header("Location: SpecialOrder.php");
        echo "something went wrong";
    }

    mysqli_close($con);
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <center>
                        <h4> Request For An Order</h4>
                    </center>
                </div>
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