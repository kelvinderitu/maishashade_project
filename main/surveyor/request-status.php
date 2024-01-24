<?php require_once('header.php'); ?>


<?php
// Include your database connection file


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_toolbox'])) {
	$booking_id = $_POST['booking_id'];
	$toolbox_id = $_POST['toolbox_id'];

	// Perform the database update with the selected toolbox
	$update_statement = $pdo->prepare("UPDATE tbl_bookings SET toolbox_type = (SELECT toolbox_type FROM tbl_toolbox WHERE toolbox_id = ?) WHERE id = ?");
	$update_statement->execute([$toolbox_id, $booking_id]);

	// Insert your logic for additional actions here

	// Redirect after processing the form
	header('Location: myallocation.php');
    exit();
	// Make sure to exit after a header redirect
}

// Check if the booking ID is set in the URL
if (isset($_GET['id'])) {
	$booking_id = $_GET['id'];

	// Fetch toolbox list from tbl_toolbox
	$toolbox_sql = "SELECT * FROM tbl_toolbox";
	$toolbox_query = $pdo->prepare($toolbox_sql);
	$toolbox_query->execute();
	$toolbox_list = $toolbox_query->fetchAll(PDO::FETCH_ASSOC);
?>

	<!-- Display Toolbox List -->
	<h3>Toolbox List</h3>
	<form method="post" action="">
		<input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
		<label for="toolbox">Select Toolbox:</label>
		<select name="toolbox_id" id="toolbox" required>
			<?php
			foreach ($toolbox_list as $toolbox) {
				echo '<option value="' . $toolbox['toolbox_id'] . '">' . $toolbox['toolbox_type'] . '</option>';
			}
			?>
		</select>
		<br><br>
		<input type="submit" name="update_toolbox" value="Update Toolbox">
	</form>

<?php
} else {
	// Redirect to the home page or handle the case when the booking ID is not set
	echo "Error occurred";
}

// Include necessary files (footer, etc.)
require_once('footer.php');
?>

<?php
$statement = $pdo->prepare("UPDATE tbl_bookings SET technician_request=? WHERE id=?");
$statement->execute(array($_REQUEST['task'], $_REQUEST['id']));


?>