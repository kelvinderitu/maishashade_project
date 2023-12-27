<?php
if (isset($_POST['form1'])) {
    $staff_id = isset($_POST['id']) ? $_POST['id'] : '';
    $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    $new_image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
    $old_image = isset($_POST['old_image']) ? $_POST['old_image'] : '';

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;
        $update_filename = $new_image;
    } else {
        $update_filename = $old_image;
    }

    $path = "../uploads";
    $update_product_query = "UPDATE tbl_staff SET full_name='$full_name', email='$email', phone='$phone', photo='$update_filename' WHERE id='$staff_id' ";

    $update_product_query_run = mysqli_query($con, $update_product_query);

    if ($update_product_query_run) {
        if ($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("../uploads/" . $old_image)) {
                unlink("../uploads/" . $old_image);
            }
        }

        echo "Staff details updated successfully.";

        // Redirect to the appropriate page
        header("Location: approvedstaff.php");
        exit();
    } else {
        echo "Error updating staff details: " . mysqli_error($con);
    }
}
?>