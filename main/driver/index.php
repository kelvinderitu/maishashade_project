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

$statement = $pdo->prepare("SELECT * FROM tbl_payment where shipping_status='Goods On transit,It will delivered to your destination within short period of time.Thank You' or shipping_status='Pending' and driver='".$_SESSION['user']['full_name']."'");
$statement->execute();
$pendingdeliveries = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_specialorders where shipping_status='Goods On transit,It will delivered to your destination within short period of time.Thank You' or shipping_status='Pending' and driver='".$_SESSION['user']['full_name']."'");
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

$statement = $pdo->prepare("SELECT * FROM tbl_bookings where shipping_status='Goods On transit,It will delivered to your destination within short period of time.Thank You' or shipping_status='Pending' and driver='".$_SESSION['user']['full_name']."'");
$statement->execute();
$completedstatus = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer_message");
$statement->execute();
$messages = $statement->rowCount();
?>

<section class="content">
<div class="row">
<div class="col-lg-6 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3><?php echo $pendingdeliveries; ?></h3>

                  <p>Pending order Deliveries</p>
                </div>
                <div class="container">
                <a href="myallocation.php"><font color="white"><i class="fa fa-eye"></i>&nbsp;View</font></a>
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
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3><?php echo $completedstatus; ?></h3>

                  <p>pending bookings Deliveries</p>
                </div>
                <div class="container">
                <a href="approvedpayment.php"><font color="white"><i class="fa fa-eye"></i>&nbsp;View</font></a>
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
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3><?php echo $driver; ?></h3>

                  <p>Pending Special Orders Deliveries</p>
                </div>
                <div class="container">
                <a href="alldeliveries.php"><font color="white"><i class="fa fa-eye"></i>&nbsp;View</font></a>
</div>
                <a href="alldeliveries.php">
                <div class="icon">
                  <i class="ionicons ion-clipboard"></i>
                </div>
               
              </div>
            </div>

            
 <!--
 <div class="col-lg-6 col-xs-12">
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3><?php echo $messages; ?></h3>

                  <p>Messages</p>
                </div>
                  <div class="container">
                <a href="alldeliveries.php"><font color="white"><i class="fa fa-eye"></i>&nbsp;View</font></a>
</div>
                <div class="icon">
                  <i class="ionicons ion-android-checkbox-outline"></i>
                </div>
               
              </div>
            </div>
		

		  </div>-->
		  
</section>

<?php require_once('footer.php'); ?>