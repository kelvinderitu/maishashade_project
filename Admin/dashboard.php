<?php
include('header.php');
include('functions.php');
include_once("includes/config.php");

?>
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-default" style="background-color:pink ; box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php

              $sql = "SELECT * FROM tbl_customer where cust_status='1'";
              $query = $mysqli->query($sql);

              echo "$query->num_rows";
              ?></h3>

          <p>Active Customers</p>
          <a href="approvedcustomer.php">
            <font color="black">View&nbsp;<i class="fa fa-eye"></i></font>
          </a>
        </div>
        <div class="icon">
          <i class="ion-android-contacts"></i>
        </div>

      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-primary" box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php

              $sql = "SELECT * FROM tbl_customer where cust_status='2'";
              $query = $mysqli->query($sql);

              echo "$query->num_rows";
              ?></h3>

          <p>Inactive Customers</p>
          <a href="inactivecustomer.php">
            <font color="black">View&nbsp;<i class="fa fa-eye"></i></font>
          </a>
        </div>
        <div class="icon">
          <i class="ion-android-contacts"></i>
        </div>

      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-danger" box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php

              $sql = "SELECT * FROM tbl_customer where cust_status='0'";
              $query = $mysqli->query($sql);

              echo "$query->num_rows";
              ?></h3>
          <p>Pending Customers</p>
          <a href="pendingcustomer.php">
            <font color="black">View&nbsp;<i class="fa fa-eye"></i></font>
          </a>
        </div>
        <div class="icon">
          <i class="ion-android-contacts"></i>
        </div>

      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-success" box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php

              $sql = "SELECT * FROM tbl_staff WHERE status ='1'";
              $query = $mysqli->query($sql);

              echo "$query->num_rows";
              ?></h3>

          <p>Active Staff</p>
          <a href="approvedstaff.php">
            <font color="black">View&nbsp;<i class="fa fa-eye"></i></font>
          </a>
        </div>
        <div class="icon">
          <i class="
ion-android-mail"></i>
        </div>

      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->


  <!-- 2nd row -->
  <div class="container">
    <h3>Reports</h3>
  </div>
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-default" style="background-color:cyan ; box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php

              $sql = "SELECT * FROM tbl_order";
              $query = $mysqli->query($sql);

              echo "$query->num_rows";
              ?></h3>

          <p>Order Record</p>
          <a href="order.php">
            <font color="black">View Details&nbsp;<i class="fa fa-eye"></i></font>
          </a>
        </div>
        <div class="icon">
          <i class="ion-ios-cart-outline"></i>
        </div>

      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-default" style="background-color:cyan ; box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php

              $sql = "SELECT * FROM tbl_payment";
              $query = $mysqli->query($sql);

              echo "$query->num_rows";
              ?></h3>

          <p>Order Payment Record</p>
          <a href="payment.php">
            <font color="black">View Details&nbsp;<i class="fa fa-eye"></i></font>
          </a>
        </div>
        <div class="icon">
          <i class="ion-ios-briefcase"></i>
        </div>

      </div>
    </div>


    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-default" style="background-color:cyan ; box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3><?php

              $sql = "SELECT * FROM tbl_tender_application";
              $query = $mysqli->query($sql);

              echo "$query->num_rows";
              ?></h3>

          <p>Supplies Payment Record</p>
          <a href="suppliespayment.php">
            <font color="black">View Details&nbsp;<i class="fa fa-eye"></i></font>
          </a>
        </div>
        <div class="icon">
          <i class="ion-ios-briefcase"></i>
        </div>

      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-default" style="background-color:cyan ; box-shadow: 1px 1px 1px 1px #888888;">
        <div class="inner">
          <h3>
            <?php
            $sql = "SELECT * FROM tbl_bookings";
            $query = $mysqli->query($sql);
            if (!$query) {
              echo "Error: " . $mysqli->error;
            } else {
              echo $query->num_rows;
            }
            ?>
          </h3>
          <p>Services Payment Record</p>
          <a href="servicespayment.php">
            <font color="black">View Details&nbsp;<i class="fa fa-eye"></i></font>
          </a>
        </div>
        <div class="icon">
          <i class="ion-ios-briefcase"></i>
        </div>
      </div>
    </div>

  </div>
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-default" style="background-color:cyan; box-shadow: 1px 1px 1px 1px #888888;">
      <div class="inner">
        <h3><?php

            $sql = "SELECT * FROM tbl_payment  ";
            $query = $mysqli->query($sql);

            echo "$query->num_rows";
            ?></h3>

        <p>dispatch Record</p>
        <a href="dispatch.php">
          <font color="black">View Details&nbsp;<i class="fa fa-eye"></i></font>
        </a>
      </div>
      <div class="icon">
        <i class="ion-ios-bus"></i>
      </div>

    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-default" style="background-color:cyan ; box-shadow: 1px 1px 1px 1px #888888;">
      <div class="inner">
        <h3><?php

            $sql = "SELECT * FROM requestsproduct  ";
            $query = $mysqli->query($sql);

            echo "$query->num_rows";
            ?></h3>

        <p>Supplies Record</p>
        <a href="supplies.php">
          <font color="black">View Details&nbsp;<i class="fa fa-eye"></i></font>
        </a>
      </div>
      <div class="icon">
        <i class="ion-ios-bus"></i>
      </div>

    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-default" style="background-color:cyan ; box-shadow: 1px 1px 1px 1px #888888;">
      <div class="inner">
        <h3><?php

            $sql = "SELECT * FROM tbl_bookings  ";
            $query = $mysqli->query($sql);

            echo "$query->num_rows";
            ?></h3>

        <p>services Record </p>
        <a href="services-requested.php">
          <font color="black">View Details&nbsp;<i class="fa fa-eye"></i></font>
        </a>
      </div>
      <div class="icon">
        <i class="ion-android-clipboard"></i>
      </div>

    </div>
  </div>
  </div>




</section>
<!-- /.content -->



<?php
include('footer.php');
?>