<?php require_once('header.php'); ?>

<section class="content-header">
	<h4>Dashboard</h4>
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

$statement = $pdo->prepare("SELECT * FROM tbl_bookings where technician_status='pending' and technician='".$_SESSION['user']['full_name']."'ORDER by id DESC");
$statement->execute();
$pendingdeliveries = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_bookings where technician='".$_SESSION['user']['full_name']."'ORDER by id DESC");
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

$statement = $pdo->prepare("SELECT * FROM tbl_bookings WHERE technician_status = 'Delivered' AND technician = :full_name ORDER BY id DESC");
$statement->execute(array(':full_name' => $_SESSION['user']['full_name']));
$completedstatus = $statement->rowCount();


$statement = $pdo->prepare("SELECT * FROM tbl_customer_message");
$statement->execute();
$messages = $statement->rowCount();
?>

<section class="content">
<div class="row">
<div class="col-lg-6 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"   box-shadow: 1px 1px 1px 1px #888888;>
                <div class="inner">
                  <h3><?php echo $pendingdeliveries; ?></h3>

                  <p>Pending Task</p>
                </div>
                <a href="myallocation.php">
                <div class="icon">
                  <i class="ionicons ion-clipboard"></i>
                </div>
</a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  box-shadow: 1px 1px 1px 1px #888888;>
                <div class="inner">
                  <h3><?php echo $completedstatus; ?></h3>

                  <p>Completed Task</p>
                </div>
                <a href="approvedpayment.php">
                <div class="icon">
                  <i class="ionicons ion-clipboard"></i>
                </div>
</a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  box-shadow: 1px 1px 1px 1px #888888;>
                <div class="inner">
                  <h3><?php echo $driver; ?></h3>

                  <p>All task</p>
                </div>
                <a href="alldeliveries.php">
                <div class="icon">
                  <i class="ionicons ion-clipboard"></i>
                </div>
               
              </div>
            </div>

 <!-- ./col -->
 <div class="col-lg-6 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  box-shadow: 1px 1px 1px 1px #888888;>
                <div class="inner">
                  <h3><?php echo $messages; ?></h3>

                  <p>Messages</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-checkbox-outline"></i>
                </div>
               
              </div>
            </div>
		

		  </div>
		  
</section>

<?php require_once('footer.php'); ?>