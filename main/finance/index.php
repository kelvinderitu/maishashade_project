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

$statement = $pdo->prepare("SELECT * FROM tbl_payment where payment_status='Pending'");
$statement->execute();
$pendingpayment = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_status='1'");
$statement->execute();
$total_customers = $statement->rowCount();

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

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Completed'));
$completedpayment = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer_message");
$statement->execute();
$messages = $statement->rowCount();
?>

<section class="content">
  <div class="row">
    <div class="col-lg-3 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-secondary" box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php echo $pendingpayment; ?></h3>

          <p>Pending Order Payment</p>
        </div>
        <div class="icon">
          <i class="ionicons ion-android-cart"></i>
        </div>

      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-secondary" box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php echo $completedpayment; ?></h3>

          <p>Completed Order Payment</p>
        </div>
        <div class="icon">
          <i class="ionicons ion-clipboard"></i>
        </div>

      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-secondary" box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php echo $paymentrecord; ?></h3>

          <p>All Order Payment Records</p>
        </div>
        <div class="icon">
          <i class="ionicons ion-android-dollar"></i>
        </div>

      </div>
    </div>

    <!-- ./col 
            <div class="col-lg-6 col-xs-12">
              <div class="small-box bg-secondary"  style="background-color: ; box-shadow: 1px 1px 1px 1px #888888;">
                <div class="inner">
                  <h3>
                 Ksh:<?php
                      $sql1 = "SELECT SUM(paid_amount) AS total_paid FROM `tbl_payment` WHERE payment_status='Completed'";
                      $qsql1 = mysqli_query($con, $sql1);

                      $sql2 = "SELECT SUM(total) AS total_charges FROM `tbl_bookings` WHERE payment_status='Approved'";
                      $qsql2 = mysqli_query($con, $sql2);

                      $sql3 = "SELECT SUM(total_amount) AS total_pay FROM `tbl_tender_application` WHERE payment_status='Received'";
                      $qsql3 = mysqli_query($con, $sql3);

                      $row1 = mysqli_fetch_assoc($qsql1);
                      $row2 = mysqli_fetch_assoc($qsql2);
                      $row3 = mysqli_fetch_assoc($qsql3);

                      $total = ($row1['total_paid'] + $row2['total_charges']) - $row3['total_pay'];

                      echo $total;
                      ?>
              
                </h3>

                  <p>Total Income</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-checkbox-outline"></i>
                </div>
               
              </div>
            </div>
		
            -->
  </div>

</section>

<?php require_once('footer.php'); ?>