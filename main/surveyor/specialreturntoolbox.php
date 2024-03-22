<?php
$host = 'localhost';
$dbname = 'maishashades';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

// Fetch data from tbl_bank
$statementBank = $pdo->prepare("SELECT * FROM tbl_toolbox");
$statementBank->execute();
$resultBank = $statementBank->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    $id = $_POST["id"];
    $tool = $_POST["tool"];

    // Update query for tbl_specialorders
    $updateSpecialOrderQry = "UPDATE tbl_specialorders SET toolbox_type=? WHERE id=?";
    $updateSpecialOrderStatement = $pdo->prepare($updateSpecialOrderQry);
    $updateSpecialOrderResult = $updateSpecialOrderStatement->execute([$tool, $id]);

    if (!$updateSpecialOrderResult) {
        echo "ERROR updating tbl_specialorders: " . implode(" ", $updateSpecialOrderStatement->errorInfo());
    } else {
        // Reduce the quantity in tbl_toolbox
        $updateToolboxQry = "UPDATE tbl_toolbox SET quantity = quantity + 1 WHERE toolbox_type = ?";
        $updateToolboxStatement = $pdo->prepare($updateToolboxQry);
        $updateToolboxResult = $updateToolboxStatement->execute([$tool]);

        if (!$updateToolboxResult) {
            echo "ERROR updating tbl_toolbox: " . implode(" ", $updateToolboxStatement->errorInfo());
        } else {
            echo '<div class="alert alert-success">Toolbox Successfully Requested!</div>';
        }
    }
    $statement = $pdo->prepare("UPDATE tbl_specialorders SET designer_return=? WHERE id=?");
    $statement->execute(array($_REQUEST['task'], $_REQUEST['id']));
    // Redirect to the original page
    header("location:completespecialorders.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../icofont/icofont.min.css">

</head>

<body>



    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <center>
                        <h5 class="page-header"> TOOLBOX </h5>
                    </center>

                </div><br>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <?php
                                    $id = $_GET['id'];
                                    $qry = "SELECT * FROM tbl_specialorders WHERE id=?";
                                    $statement = $pdo->prepare($qry);
                                    $statement->execute([$id]);
                                    $row = $statement->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                    <form role="form" action="" method="post">

                                        <center><br><input type="text" readonly name="tool" value="<?php echo $row['toolbox_type']; ?>"><br><br></center>

                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                        <button type="submit" name="submit" class="btn btn-success btn-sm">Return</button>
                                        <a class="btn btn-sm btn-warning float-right" href="specialorders.php">Back</a>
                                    </form>

                                </div>
                                <?php

                                ?>

                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


</body>


<style>
    footer {
        background-color: #424558;
        bottom: 0;
        left: 0;
        right: 0;
        height: 35px;
        text-align: center;
        color: #CCC;
    }

    footer p {
        padding: 10.5px;
        margin: 0px;
        line-height: 100%;
    }
</style>

</html>