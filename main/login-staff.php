<?php require_once('reg-head.php'); ?>
<!-- fetching row banner login -->
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>
<div class="card">
    <div class="card" style="padding-left:5%;background-color:white"><br>
        <center>
            <h4>
                <font color="black">Staff Login:</font>
            </h4>
        </center>
        <hr>
        <font color="black"><i class="fa fa-sign-in"></i>&nbsp;<a href="admin/index.php">
                <font color="black">Inventory Manager</font>
            </a><br>
            <br>
            <font color="black"> <i class="fa fa-sign-in"></i>&nbsp;<a href="dispatch/index.php">
                    <font color="black">Dispatch Manager</font>
                </a><br>
                <br>
                <font color="black"> <i class="fa fa-sign-in"></i>&nbsp;<a href="finance/index.php">
                        <font color="black">Finance</font>
                    </a></br>
                    <br>
                    <font color="black"> <i class="fa fa-sign-in"></i>&nbsp;<a href="manager/index.php">
                            <font color="black">Service Manager</font>
                        </a></br>
                        <br>
                        <font color="black"> <i class="fa fa-sign-in"></i>&nbsp;<a href="Processing_Manager/index.php">
                                <font color="black">Supervisor</font>
                            </a></br>
                            <br>
                            <font color="black"> <i class="fa fa-sign-in"></i>&nbsp;<a href="surveyor/index.php">
                                    <font color="black">Designer</font>
                                </a></br>
                                <br>
                                <font color="black"> <i class="fa fa-sign-in"></i>&nbsp;<a href="supplier/index.php">
                                        <font color="black">Supplier </font>
                                    </a></br>
                                    <br>
                                    <font color="black"><i class="fa fa-sign-in"></i>&nbsp;<a href="driver/index.php">
                                            <font color="black">Driver</font>
                                        </a></br><br>
                                        <hr><br>

    

<button class="btn btn-warning"><a href="index.php">
        <font color="black"><i class="fa fa-arrow-left"></i>&nbsp;Back</font>
    </a></button>