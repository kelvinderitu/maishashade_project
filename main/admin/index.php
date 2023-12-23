<?php require_once('header.php'); ?>

<section class="container">
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

$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM messages where sender=''");
$statement->execute();
$message = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_active='1'");
$statement->execute();
$total_subscriber = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost");
$statement->execute();
$available_shipping = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Completed'));
$total_order_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE shipping_status=?");
$statement->execute(array('Completed'));
$total_shipping_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$total_order_pending = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbmessages ");
//$statement->execute(array('Pending'));
$tbmessages = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=? AND shipping_status=?");
$statement->execute(array('Completed','Pending'));
$total_order_complete_shipping_pending = $statement->rowCount();
?>

<section class="content">
<div class="row">
            <div class="col-lg-3 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3><?php echo $total_product; ?></h3>

                  <p>Products</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-cart"></i>
                </div>
                
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3><?php echo $total_order_pending; ?></h3>

                  <p>Pending Orders</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-clipboard"></i>
                </div>
                
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3><?php echo $total_order_completed; ?></h3>

                  <p>Completed Orders</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-checkbox-outline"></i>
                </div>
               
              </div>
            </div>

            <div class="col-lg-3 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3><?php echo $tbmessages; ?></h3>

                  <p>New Messages</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-chatbox"></i>
                </div>
               
              </div>
            </div>
		

		  </div>
		  
</section>

<?php require_once('footer.php'); ?>