<?php require_once('header.php'); ?>

<section class="content-header">
  <h4>Main Dashboard</h4>
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
  <div class="card">


    <div class="row">
      <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">

          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>
                      <font color="green">Sevice Name</font>
                    </th>
                    <th>
                      <font color="green">Pricing</font>
                    </th>
                    <th>
                      <font color="green">Description</font>
                    </th>
                    <th>
                      <font color="green">Duration</font>
                    </th>
                    <th>
                      <font color="green">Action</font>
                    </th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $serviceid = isset($_GET['serviceid']) ? $_GET['serviceid'] : null;
                  
                  $sql = "SELECT *FROM tbl_services  ";
                  $dbh = new PDO('mysql:host=localhost;dbname=maishashades', 'root', '');

                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) {               ?>
                      <tr class="odd gradeX">
                        <td class="center"><?php echo htmlentities($cnt); ?></td>
                        <td class="center"><?php echo htmlentities($result->servicename); ?></td>
                        <td class="center">Ksh&nbsp;<?php echo htmlentities($result->pricing); ?></td>
                        <td class="center"><?php echo htmlentities($result->description); ?></td>
                        <td class="center"><?php echo htmlentities($result->duration); ?></td>
                        <td class="center">
                          <a href="book.php?serviceid=<?php echo htmlentities($result->serviceid); ?>" class="btn btn-primary btn-md">Book Now</a>
                        </td>
                      </tr>
                  <?php $cnt = $cnt + 1;
                    }
                  } ?>
                </tbody>
              </table>
            </div>
            <button class="btn btn-sm btn-default"><a href="../index.php">
                <font color="black">Back</font>
              </a></button>

          </div>
        </div>
        <!--End Advanced Tables -->
      </div>
    </div>



  </div>
  <div class="col-md-12">

  </div>
  </div>

  <!-- CONTENT-WRAPPER SECTION END-->

  <!-- FOOTER SECTION END-->
  <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
  <!-- CORE JQUERY  -->
  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS  -->
  <script src="assets/js/bootstrap.js"></script>
  <!-- DATATABLE SCRIPTS  -->
  <script src="assets/js/dataTables/jquery.dataTables.js"></script>
  <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
  <!-- CUSTOM SCRIPTS  -->
  <script src="assets/js/custom.js"></script>



  >


  </div>

</section>

<?php require_once('footer.php'); ?>