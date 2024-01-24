<?php require_once('head.php'); ?>

<?php
// Check if the customer is logged in or not
if (!isset($_SESSION['customer'])) {
    header('location: ' . BASE_URL . 'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'], 0));
    $total = $statement->rowCount();
    if ($total) {
        header('location: ' . BASE_URL . 'logout.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
</head>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">

                            <tbody>


                                <?php
                                /* ===================== Pagination Code Starts ================== */
                                $adjacents = 5;

                                $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC");
                                $statement->execute(array($_SESSION['customer']['cust_email']));
                                $total_pages = $statement->rowCount();

                                $targetpage = BASE_URL . 'customer-order.php';
                                $limit = 10;
                                $page = @$_GET['page'];
                                if ($page)
                                    $start = ($page - 1) * $limit;
                                else
                                    $start = 0;

                                $id = $_GET['id'];
                                $statement = $pdo->prepare("SELECT * FROM tbl_payment where id='$id' and customer_email=? ORDER BY id DESC LIMIT $start, $limit");
                                $statement->execute(array($_SESSION['customer']['cust_email']));
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);


                                if ($page == 0) $page = 1;
                                $prev = $page - 1;
                                $next = $page + 1;
                                $lastpage = ceil($total_pages / $limit);
                                $lpm1 = $lastpage - 1;
                                $pagination = "";
                                if ($lastpage > 1) {
                                    $pagination .= "<div class=\"pagination\">";
                                    if ($page > 1)
                                        $pagination .= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
                                    else
                                        $pagination .= "<span class=\"disabled\">&#171; previous</span>";
                                    if ($lastpage < 7 + ($adjacents * 2)) {
                                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                                            if ($counter == $page)
                                                $pagination .= "<span class=\"current\">$counter</span>";
                                            else
                                                $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                                        }
                                    } elseif ($lastpage > 5 + ($adjacents * 2)) {
                                        if ($page < 1 + ($adjacents * 2)) {
                                            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                                if ($counter == $page)
                                                    $pagination .= "<span class=\"current\">$counter</span>";
                                                else
                                                    $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                                            }
                                            $pagination .= "...";
                                            $pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                                            $pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
                                        } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                            $pagination .= "<a href=\"$targetpage?page=1\">1</a>";
                                            $pagination .= "<a href=\"$targetpage?page=2\">2</a>";
                                            $pagination .= "...";
                                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                                if ($counter == $page)
                                                    $pagination .= "<span class=\"current\">$counter</span>";
                                                else
                                                    $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                                            }
                                            $pagination .= "...";
                                            $pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                                            $pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
                                        } else {
                                            $pagination .= "<a href=\"$targetpage?page=1\">1</a>";
                                            $pagination .= "<a href=\"$targetpage?page=2\">2</a>";
                                            $pagination .= "...";
                                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                                if ($counter == $page)
                                                    $pagination .= "<span class=\"current\">$counter</span>";
                                                else
                                                    $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                                            }
                                        }
                                    }
                                    if ($page < $counter - 1)
                                        $pagination .= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
                                    else
                                        $pagination .= "<span class=\"disabled\">next &#187;</span>";
                                    $pagination .= "</div>\n";
                                }
                                /* ===================== Pagination Code Ends ================== */
                                ?>

                                <?php
                                $tip = $page * 10 - 10;
                                foreach ($result as $row) {
                                    $tip++;
                                ?>

                                    <div class="card ">
                                        <tr>
                                            <center>
                                                <b>CUSTOMER DETAILS.</b>
                                                <?php
                                                $statement1 = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
                                                $statement1->execute(array($row['customer_id']));
                                                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result1 as $row1) {
                                                    echo '<br><b>Full Name: </b>' . $row1['cust_name'] . ' ' . $row1['cust_lname'];
                                                    echo '<br><b>Phone: </b>' . $row1['cust_phone'];
                                                    echo '<br><b>Email: </b>' . $row1['cust_email'];
                                                }

                                                ?><br>




                                                <td><center>
                                                    <?php
                                                    $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                                    $statement1->execute(array($row['payment_id']));
                                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result1 as $row1) {
                                                        echo '<br><b>Product Name: </b>' . $row1['product_name'];
                                                        echo '<br><b>Quantity: </b>' . $row1['quantity'];
                                                        echo '<br><b>Price Per Quantity: </b>' . $row1['unit_price'];
                                                    }
                                                    ?><br>

                                                    <b>Date :</b><?php echo $row['payment_date']; ?><br>
                                                    <b>Transaction id :</b><?php echo $row['bank_transaction_info']; ?><br>
                                                    <b>Delivey Fee :</b><?php echo $row['shipping_fee']; ?><br>
                                                    <b>Amount Paid :</b> <?php echo 'Ksh' . $row['paid_amount']; ?><br>
                                                </td>
                                            </center>


                                        </tr>
                                    </div>

                                    <style>
                                        .button-container {
                                            display: inline-block;
                                            margin-right: 20px;
                                            /* Adjust the margin as needed */
                                        }

                                        #printButton {
                                            float: right;
                                        }
                                    </style>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>

                        <div class="pagination" style="overflow: hidden;">
                            <?php
                            echo $pagination;
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</html>
