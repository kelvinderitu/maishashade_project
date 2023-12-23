<?php require_once('header.php'); ?>

<section class="content-header">
	<h1>Dashboard</h1>
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

$statement = $pdo->prepare("SELECT * FROM tbl_request_material where status='Pending'");
$statement->execute();
$pendingdeliveries = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_request_material WHERE payment_status='Pending'");
$statement->execute();
$driver = $statement->rowCount();

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

$statement = $pdo->prepare("SELECT * FROM tbl_request_material WHERE status=?");
$statement->execute(array('Approved'));
$completedstatus = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_request_material where payment_status='Approved'");
$statement->execute();
$messages = $statement->rowCount();
?>

<section class="content">
<div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3><?php echo $pendingdeliveries; ?></h3>

                  <p>Pending Orders</p>
                </div>
                <a href="pendingpayment.php">
                <div class="icon">
                  <i class="ionicons ion-android-cart"></i>
                </div>
</a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-maroon">
                <div class="inner">
                  <h3><?php echo $completedstatus; ?></h3>

                  <p>Approved Orders</p>
                </div>
                <a href="approvedorders.php">
                <div class="icon">
                  <i class="ionicons ion-clipboard"></i>
                </div>
</a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $driver; ?></h3>

                  <p>Pending payments</p>
                </div>
                <a href="pending_payments.php">
                <div class="icon">
                  <i class="ionicons ion-briefcase"></i>
                </div>
</a>
              </div>
            </div>

 <!-- ./col -->
 <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-orange">
                <div class="inner">
                  <h3><?php echo $messages; ?></h3>

                  <p>Approved payments</p>
                </div>
                <a href="approved_payments.php">
                <div class="icon">
                  <i class="ionicons ion-briefcase"></i>
                </div>
</a>
              </div>
            </div>
		

		  </div>
		  
</section>

<?php require_once('footer.php'); ?>