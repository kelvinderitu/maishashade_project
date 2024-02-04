
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Materials</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4> Request Materials</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="post">
                            <?php
                            $con = mysqli_connect("localhost", "root", "", "nyabondobricks");
                            $brand_query = "SELECT * FROM requestsproduct";
                            $query_run = mysqli_query($con, $brand_query);
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($brand = mysqli_fetch_assoc($query_run)) {
                            ?>
                                   
                                    <input type="text" name="brandslist[]" value="<?= $brand['p_name']; ?>" /> <br />
                            <?php
                                }
                            } else {
                                echo "No Record found";
                            }
                            ?>
                            <div class="form-group mt-3">
                                <br><br>
                                <textarea  name="myTextarea" rows="4" cols="50"></textarea>
                                <button name="button" class="btn btn-primary">Request Materials</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
