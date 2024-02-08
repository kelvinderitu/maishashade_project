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
	<link rel="stylesheet" href="assets/css/owl.theme.success.min.css">
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
		<title>
			<?php echo $meta_title_home; ?>
		</title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}

	if ($cur_page == 'about.php') {
	?>
		<title>
			<?php echo $about_meta_title; ?>
		</title>
		<meta name="keywords" content="<?php echo $about_meta_keyword; ?>">
		<meta name="description" content="<?php echo $about_meta_description; ?>">
	<?php
	}
	if ($cur_page == 'faq.php') {
	?>
		<title>
			<?php echo $faq_meta_title; ?>
		</title>
		<meta name="keywords" content="<?php echo $faq_meta_keyword; ?>">
		<meta name="description" content="<?php echo $faq_meta_description; ?>">
	<?php
	}
	if ($cur_page == 'contact.php') {
	?>
		<title>
			<?php echo $contact_meta_title; ?>
		</title>
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
		<title>Dashboard -
			<?php echo $meta_title_home; ?>
		</title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	if ($cur_page == 'customer-profile-update.php') {
	?>
		<title>Update Profile -
			<?php echo $meta_title_home; ?>
		</title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	if ($cur_page == 'customer-billing-shipping-update.php') {
	?>
		<title>Update Billing and Shipping Info -
			<?php echo $meta_title_home; ?>
		</title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	if ($cur_page == 'customer-password-update.php') {
	?>
		<title>Update Password -
			<?php echo $meta_title_home; ?>
		</title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
	<?php
	}
	if ($cur_page == 'customer-order.php') {
	?>
		<title>Orders -
			<?php echo $meta_title_home; ?>
		</title>
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



	<?php echo $before_head; ?>

</head>

<body>

	<?php echo $after_body; ?>
	<!--
<div id="preloader">
	<div id="status"></div>
</div>-->




	<div class="nav top-fixed" style="background-color:gray">
		<div class="container">
			<div class="row">
				<div class="col-md-12 pl_0 pr_0">
					<center>
						<img src = "assets/uploads/log.png">
						
					</center>
					<div class="menu-container" style="background-color:gray">
						<div class="menu ">
							<ul>
								<li><a href="index.php">Home</a></li>

								<?php
								$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								foreach ($result as $row) {
								?>
									<li><a href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category">
											<?php echo $row['tcat_name']; ?>
										</a>
										<ul>
											<?php
											$statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
											$statement1->execute(array($row['tcat_id']));
											$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
											foreach ($result1 as $row1) {
											?>
												<li><a href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category">
														<?php echo $row1['mcat_name']; ?>
													</a>
													<ul>
														<?php
														$statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
														$statement2->execute(array($row1['mcat_id']));
														$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
														foreach ($result2 as $row2) {
														?>
															<li><a href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category">
																	<?php echo $row2['ecat_name']; ?>
																</a></li>
														<?php
														}
														?>
													</ul>
												</li>
											<?php
											}
											?>
										</ul>
									</li>
								<?php
								}
								?>

								<?php
								$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								foreach ($result as $row) {
									$about_title = $row['about_title'];
									$faq_title = $row['faq_title'];
									$blog_title = $row['blog_title'];
									$contact_title = $row['contact_title'];
									$pgallery_title = $row['pgallery_title'];
									$vgallery_title = $row['vgallery_title'];
								}
								?>
								<li><a href="services/index.php">Our Services</a></li>
								<li><a href="services/services2.php">SpecialOrders</a></li>
								
								<li><a href="about.php">
										<?php echo $about_title; ?>
									</a></li>
								<li><a href="faq.php">Help</a></li>

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="header">
			<div class="card" style="background-color:white">
				<div class="container">
					<div class="row inner">
						<div class="col-md-12 search-area">
							<form class="navbar-form navbar-left" role="search" action="search-result.php" method="get">
								<?php $csrf->echoInputField(); ?>
								<div class="form-group">
									<input type="text" class="form-control search-top" placeholder="<?php echo LANG_VALUE_2; ?>" name="search_text">
								</div>
								<button type="submit" class="btn btn-success">
									<?php echo LANG_VALUE_3; ?>
								</button>
							</form>
						</div>

						<div class="container">
							<ul>

								<?php
								if (isset($_SESSION['customer'])) {
								?>
									<center>
										<a href="customer-order.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-clipboard"></i>
													<h6>My Orders</h6>
												</font>
											</button></a>
										<a href="services/mybookings.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-list"></i>
													<h6>My Bookings</h6>
												</font>
											</button></a>
											<a href="SpecialOrderRequest.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-clipboard"></i>
													<h6>Special Orders</h6>
												</font>
											</button></a>
										<a href="register/inbox.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-envelope"></i>
													<h6>Feedback</h6>
												</font>
											</button></a>
										<a href="customer-profile-update.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-user"></i>
													<h6>Profile</h6>
												</font>
											</button></a>
										<a href="logout.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-power-off"></i>
													<h6> Logout</h6>
												</font>
											</button></a>
									</center>
								<?php
								} else {
								?>
									<center>
										<a href="login.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-users"></i>
													<font color="black">
														<h6>Customer </h6>
											</button></a></font>
										<a href="registration.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-user-plus"></i>
													<h6> Register</h6>
											</button></a></font>
										<a href="login-staff.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-users"></i>
													<h6>Staff </h6>
											</button></a></font>
										<a href="contactus.php"><button class="btn btn-sm btn-secondary">
												<font color="black"><i class="fa fa-send"></i>
													<h6>Contact Us</h6>
											</button></a></font>
									</center>
								<?php
								}
								?>
								<hr>

							</ul>
						</div>

					</div>
				</div>
			</div>
			