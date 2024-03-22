<?php require_once('header.php'); ?>

<section class="content-header">
	<h3>Dashboard</h3>
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

$statement = $pdo->prepare("SELECT * FROM tbl_services where status='Active'");
$statement->execute();
$pendingdeliveries = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE technician!='' and  supervisor !=''");
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

$statement = $pdo->prepare("SELECT * FROM tbl_bookings WHERE status=?");
$statement->execute(array('pending'));
$completedstatus = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_specialorders WHERE designer!='' and  supervisor !=''");
$statement->execute();
$messages = $statement->rowCount();
?>

<section class="content">
<div class="row">
<div class="col-lg-6 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  box-shadow: 1px 1px 1px 1px #888888;>
                <div class="inner">
                  <h3><?php echo $pendingdeliveries; ?></h3>

                  <p>Services</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-cart"></i>
                </div>
                
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"   box-shadow: 1px 1px 1px 1px #888888;>
                <div class="inner">
                  <h3><?php echo $completedstatus; ?></h3>

                  <p>Pending Bookings</p>
                </div>
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
                  <h3><?php echo $driver; ?></h3>

                  <p>Pending orders</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-dollar"></i>
                </div>
               
              </div>
            </div>

 <!-- ./col -->
 <div class="col-lg-6 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"   box-shadow: 1px 1px 1px 1px #888888;>
                <div class="inner">
                  <h3><?php echo $messages; ?></h3>

                  <p>Pending Special orders</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-checkbox-outline"></i>
                </div>
               
              </div>
            </div>
		

		  </div>
		  
</section>

<?php require_once('footer.php'); ?>