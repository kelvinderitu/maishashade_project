<!-- This is main configuration File -->
<?php
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Getting all language variables into array as global variable
$i = 1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	define('LANG_VALUE_' . $i, $row['lang_value']);
	$i++;
}

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$meta_title_home = $row['meta_title_home'];
	$meta_keyword_home = $row['meta_keyword_home'];
	$meta_description_home = $row['meta_description_home'];
	$before_head = $row['before_head'];
	$after_body = $row['after_body'];
}

// Checking the order table and removing the pending transaction that are 24 hours+ old. Very important
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$ts1 = strtotime($row['payment_date']);
	$ts2 = strtotime($current_date_time);
	$diff = $ts2 - $ts1;
	$time = $diff / (3600);
	if ($time > 24) {

		// Return back the stock amount
		$statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));
		$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result1 as $row1) {
			$statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement2->execute(array($row1['product_id']));
			$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result2 as $row2) {
				$p_qty = $row2['p_qty'];
			}
			$final = $p_qty + $row1['quantity'];

			$statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
			$statement->execute(array($final, $row1['product_id']));
		}

		// Deleting data from table
		$statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));

		$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
		$statement1->execute(array($row['id']));
	}
}
?>
<?php
// Check if the customer is logged in or not
if (!isset($_SESSION['customer'])) {
	header('location: ' . BASE_URL . 'logout.php');
	exit;
} else {
	// If customer is logged in, but admin make him inactive, then force logout this user.
	$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
	$statement->execute(array($_SESSION['customer']['cust_id'], 0));
	$total = $statement->rowCount();
	if ($total) {
		header('location: ' . BASE_URL . 'logout.php');
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Meta Tags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/uploads/<?php echo $favicon; ?>">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="assets/css/jquery.bxslider.min.css">
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<link rel="stylesheet" href="assets/css/rating.css">
	<link rel="stylesheet" href="assets/css/spacing.css">
	<link rel="stylesheet" href="assets/css/bootstrap-touch-slider.css">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/tree-menu.css">
	<link rel="stylesheet" href="assets/css/select2.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/responsive.css">

	<?php

	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$about_meta_title = $row['about_meta_title'];
		$about_meta_keyword = $row['about_meta_keyword'];
		$about_meta_description = $row['about_meta_description'];
		$faq_meta_title = $row['faq_meta_title'];
		$faq_meta_keyword = $row['faq_meta_keyword'];
		$faq_meta_description = $row['faq_meta_description'];
		$blog_meta_title = $row['blog_meta_title'];
		$blog_meta_keyword = $row['blog_meta_keyword'];
		$blog_meta_description = $row['blog_meta_description'];
		$contact_meta_title = $row['contact_meta_title'];
		$contact_meta_keyword = $row['contact_meta_keyword'];
		$contact_meta_description = $row['contact_meta_description'];
		$pgallery_meta_title = $row['pgallery_meta_title'];
		$pgallery_meta_keyword = $row['pgallery_meta_keyword'];
		$pgallery_meta_description = $row['pgallery_meta_description'];
		$vgallery_meta_title = $row['vgallery_meta_title'];
		$vgallery_meta_keyword = $row['vgallery_meta_keyword'];
		$vgallery_meta_description = $row['vgallery_meta_description'];
	}

	$cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

	if ($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'product-category.php' || $cur_page == 'product.php') {
	?>
		<title><?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}

	if ($cur_page == 'about.php') {
	?>
		<title><?php echo $about_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $about_meta_keyword; ?>">
		<meta name="description" content="<?php echo $about_meta_description; ?>">
	<?php
	}
	if ($cur_page == 'faq.php') {
	?>
		<title><?php echo $faq_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $faq_meta_keyword; ?>">
		<meta name="description" content="<?php echo $faq_meta_description; ?>">
	<?php
	}
	if ($cur_page == 'contact.php') {
	?>
		<title><?php echo $contact_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $contact_meta_keyword; ?>">
		<meta name="description" content="<?php echo $contact_meta_description; ?>">
	<?php
	}
	if ($cur_page == 'product.php') {
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$og_photo = $row['p_featured_photo'];
			$og_title = $row['p_name'];
			$og_slug = 'product.php?id=' . $_REQUEST['id'];
			$og_description = substr(strip_tags($row['p_description']), 0, 200) . '...';
		}
	}

	if ($cur_page == 'dashboard.php') {
	?>
		<title>Dashboard - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	if ($cur_page == 'customer-profile-update.php') {
	?>
		<title>Update Profile - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	if ($cur_page == 'customer-billing-shipping-update.php') {
	?>
		<title>Update Billing and Shipping Info - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	if ($cur_page == 'customer-password-update.php') {
	?>
		<title>Update Password - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	if ($cur_page == 'customer-order.php') {
	?>
		<title>Orders - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	?>

	<?php if ($cur_page == 'blog-single.php') : ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL . $og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>

	<?php if ($cur_page == 'product.php') : ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL . $og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>


</head>

<body>

	<?php echo $after_body; ?>
	<!--
<div id="preloader">
	<div id="status"></div>
</div>-->


	<div class="header">
		<div class="container">

			<div class="col-md-4 logo">
				<center><br><img src="assets/uploads/log.png"></center><br>
				<center>Nairobi, Kenya<br>
				Office Tel. +254706071232<br>
				Email: info@maishashades.co.ke</center>
			

			<?php
			/* ===================== Pagination Code Starts ================== */
			$adjacents = 5;

			$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC");
			$statement->execute(array($_SESSION['customer']['cust_email']));
			$total_pages = $statement->rowCount();

			$targetpage = BASE_URL . 'customer-order.php';
			$limit = 10;
			$page = @$_GET['page'];
			if ($page)
				$start = ($page - 1) * $limit;
			else
				$start = 0;


			$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC LIMIT $start, $limit");
			$statement->execute(array($_SESSION['customer']['cust_email']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);


			if ($page == 0) $page = 1;
			$prev = $page - 1;
			$next = $page + 1;
			$lastpage = ceil($total_pages / $limit);
			$lpm1 = $lastpage - 1;
			$pagination = "";
			if ($lastpage > 1) {
				$pagination .= "<div class=\"pagination\">";
				if ($page > 1)
					$pagination .= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
				else
					$pagination .= "<span class=\"disabled\">&#171; previous</span>";
				if ($lastpage < 7 + ($adjacents * 2)) {
					for ($counter = 1; $counter <= $lastpage; $counter++) {
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
					}
				} elseif ($lastpage > 5 + ($adjacents * 2)) {
					if ($page < 1 + ($adjacents * 2)) {
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
							if ($counter == $page)
								$pagination .= "<span class=\"current\">$counter</span>";
							else
								$pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
						}
						$pagination .= "...";
						$pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
					} elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
						$pagination .= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination .= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination .= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
							if ($counter == $page)
								$pagination .= "<span class=\"current\">$counter</span>";
							else
								$pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
						}
						$pagination .= "...";
						$pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
					} else {
						$pagination .= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination .= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination .= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
							if ($counter == $page)
								$pagination .= "<span class=\"current\">$counter</span>";
							else
								$pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
						}
					}
				}
				if ($page < $counter - 1)
					$pagination .= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
				else
					$pagination .= "<span class=\"disabled\">next &#187;</span>";
				$pagination .= "</div>\n";
			}
			/* ===================== Pagination Code Ends ================== */
			?>

			<?php
			$tip = $page * 10 - 10;
			foreach ($result as $row) {
				$tip++;
			?>

			<?php
			}
			?>

			</tbody>
			</table>

		</div>

	</div>
	</div>