<?php
include("header.php");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nyabondobricks";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

function getAll($table)
{
   global $con;
   $query = "SELECT * FROM  $table";
     return $query_run = mysqli_query($con, $query);
}
function getByID($table, $id)
{
   global $con;
   $query = "SELECT * FROM  $table WHERE id='$id' ";
     return $query_run = mysqli_query($con, $query);
}
function redirect($url, $message)
{
  $_SESSION['message'] = $message;
  header('Location: '.$url);
  exit();
}
if (isset($_POST['update_product_btn'])) {
    $bank_id = $_POST['bank_id'];
 
    $bankname = $_POST['bankname'];
    $bankaccount = $_POST['bankaccount'];
 
   
    $update_product_query = "UPDATE tbl_supplierbank SET BankName='$bankname', BankAccountNumber='$bankaccount' WHERE id='$bank_id' ";

    $update_product_query_run  = mysqli_query($con, $update_product_query);

    if ($update_product_query_run) {
        
        redirect("supplierbank.php?id=$bank_id", "Bank updated successfully");
    } else {
        redirect("supplierbank.php?id=$bank_id", "Something went wrong");
    }
} 

?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $product = getByID("tbl_supplierbank", $id);

                if (mysqli_num_rows($product) > 0) {
                    $data = mysqli_fetch_array($product);
            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4> Edit Bank Details
                                
                            </h4>
                        </div>
                        <div class="card-body">
                            <form role ="form" action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    
                                    <input type="hidden" name="bank_id" value="<?= $data['id']; ?>">
                                    <div class="col-md-12">
                                        <label class="mb-0"> Bank Name</label>
                                        <input type="text" required name="bankname" value="<?= $data['BankName']; ?>" placeholder="Enter Bank name" class="form-control mb-2">
                                    </div><br>
                                    <div class="col-md-12">
                                        <label class="mb-0">Account Number</label>
                                        <input type="text" required name="bankaccount" value="<?= $data['BankAccountNumber']; ?>" placeholder="Enter Account Number" class="form-control mb-2">
                                    </div>


                                   

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success" name="update_product_btn">Update</button>
                                        <a href="supplierbank.php" class="btn btn-primary float-right">Back</a>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>






            <?php

                } else {


                    echo "product not found for given id";
                }
            } else {


                echo "id missing from url";
            }

            ?>

        </div>
    </div>
</div>
