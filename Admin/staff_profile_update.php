<?php
include('config.php');
require_once('header.php');

$error_message = '';
$success_message = '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=nyabondobricks", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

function getByID($table, $id, $pdo)
{
    $query = "SELECT * FROM $table WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['updatebtn'])) {
    $staff_id = $_GET['id'];
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;
        $update_filename = $filename;
    } else {
        $update_filename = $old_image;
    }

    $path = "uploads/";

    try {
        $update_staff_query = "UPDATE tbl_staff SET full_name=?, password=?, email=?, phone=?, role=?, photo=? WHERE id=?";
        $stmt = $pdo->prepare($update_staff_query);

        $stmt->execute([$full_name, $password, $email, $phone, $role, $update_filename, $staff_id]);

        if ($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("uploads/" . $old_image)) {
                unlink("uploads/" . $old_image);
            }
        }

        // Redirect to the appropriate page after successful update

    } catch (PDOException $e) {
        echo "Error updating staff details: " . $e->getMessage();
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $data = getByID("tbl_staff", $id, $pdo);

                if ($data) {
            ?>
                    <div class="card">

                        <div class="card-header">
                            <center>
                                <h3> Edit Staff Details</h3>
                            </center>

                        </div>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                                        <div class="col-md-12">
                                            <label class="mb-0">Name</label>
                                            <input type="text" required name="full_name" value="<?= $data['full_name']; ?>" placeholder="Enter category name" class="form-control mb-2">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="mb-0">Email</label>
                                            <input type="email" required name="email" value="<?= $data['email']; ?>" placeholder="Enter slug" class="form-control mb-2">
                                        </div>


                                        <div class="col-md-12">
                                            <label class="mb-0">Phone Number</label>
                                            <input type="text" required name="phone" value="<?= $data['phone']; ?>" placeholder="Enter Original Price" class="form-control mb-2">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="mb-0">Password</label>
                                            <input type="text" required name="password" value="<?= $data['password']; ?>" placeholder="Enter Selling Price" class="form-control mb-2">
                                        </div>

                                        <div class="col-md-12">
                                            <label class="mb-0">Upload photo</label>
                                            <input type="hidden" name="old_image" value="<?= $data['photo']; ?>">
                                            <input type="file" name="image" class="form-control mb-2">
                                            <label class="mb-0">current Image</label>
                                            <img src="../uploads/<?= $data['photo']; ?>" alt=" Product Image" height="50px" width="50px">
                                        </div><br><br><br>


                                        <div class="col-md-12">
                                            <label class="mb-0"> Select Role</label>
                                            <select name="role" required class="form-select mb-2">
                                                <option> <?= $data['role']; ?></option>
                                                <option value="inventory_manager">Inventory Manager</option>
                                                <option value="technician">Technician</option>
                                                <option value="finance">Finance</option>
                                                <option value="dispatch">Dispatch Manager</option>
                                                <option value="service manager">Service Manager</option>
                                                <option value="supervisor">Supervisor</option>
                                                <option value="driver">Driver</option>
                                                <option value="supplier">Supplier</option>
                                            </select>
                                        </div>


                                    </div>




                                </div>



                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" name="updatebtn">Update</button>
                                </div>

                                <div class="col-md-6">
                                    <a href="approvedstaff.php" class="btn btn-primary float-end">Back</a>

                                </div>


                        </div>
                        </form>


                    </div>
        </div>






<?php

                } else {
                    echo "staff not found for given id";
                }
            } else {
                echo "id missing from url";
            }

?>

    </div>
</div>
</div>

</html>

<?php require_once('footer.php'); ?>