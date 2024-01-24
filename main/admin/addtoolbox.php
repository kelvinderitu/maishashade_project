<?php
require_once('header.php');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nyabondobricks";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$msg = ""; // Define $msg variable
$error = "";



if (isset($_POST['addbtn'])) {
    $toolbox_type = $_POST['toolbox_type'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO  tbl_toolbox(toolbox_type,quantity) VALUES(:toolbox_type,:quantity)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':toolbox_type', $toolbox_type, PDO::PARAM_STR);
    $query->bindParam(':quantity', $quantity, PDO::PARAM_STR);

    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "toolbox Added successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>

?>

<div class="row breadcrumb-div">
    <div class="col-md-12">
        <ul class="breadcrumb">
            <li><a href="toolbox.php"><i class="fa fa-home"></i> Back</a></li>

            <li class="active"></li>
        </ul>
    </div>

</div>
<!-- /.row -->

<div class="container-fluid">

    <div class="card">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <center>
                            <h4><b>ADD NEW TOOLBOX</b></h4>
                        </center>
                    </div>
                </div>
                <div class="panel-body">
                    <?php if ($msg) { ?>
                        <div class="alert alert-success left-icon-alert" role="alert">
                            <strong></strong><?php echo htmlentities($msg); ?>
                        </div><?php } else if ($error) { ?>
                        <div class="alert alert-danger left-icon-alert" role="alert">
                            <strong>Error !!</strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php } ?>

                    <form class="form-horizontal" method="post">

                        <div class="form-group">
                            <label for="default" class="col-sm-2 control-label">toolname</label>
                            <div class="col-sm-8">
                                <input type="text" name="toolbox_type" class="form-control" required="required" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="default" class="col-sm-2 control-label">Quantity </label>
                            <div class="col-sm-8">
                                <input type="text" name="quantity" class="form-control" required="required" autocomplete="off">
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" name="addbtn" class="btn btn-primary">Submit</button>
                            </div>

                        </div>


                    </form>
                    <button class="btn btn-warning">
                        <a href="toolbox.php">
                            <font color="black"><i class="fa fa-arrow-left"></i>&nbsp;Back</font>
                        </a>
                    </button>

                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
    </div>
</div>

<!-- /.main-wrapper -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/pace/pace.min.js"></script>
<script src="js/lobipanel/lobipanel.min.js"></script>
<script src="js/iscroll/iscroll.js"></script>
<script src="js/prism/prism.js"></script>
<script src="js/select2/select2.min.js"></script>
<script src="js/main.js"></script>
<script>
    $(function($) {
        $(".js-states").select2();
        $(".js-states-limit").select2({
            maximumSelectionLength: 2
        });
        $(".js-states-hide").select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>
</body>

</html>
<?PHP ?>