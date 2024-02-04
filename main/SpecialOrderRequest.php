<?php 
require_once('header.php');
 ?>

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
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <center>
                        <h3>
                            <font color="black">MY SPECIAL ORDER REQUEST</font>
                        </h3>
                    </center>
                   
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th><?php echo LANG_VALUE_48; ?></th>
                                    <th>Payment Details</th>
                                    </th>
                                    <th>Location Details</th>
                                    </th>
                                    <th>Order Status</th>
                                    <th>Shipping Status</th>
                                    <th>Driver Details</th>
                                    <th>Customer Comments/Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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


                                $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC LIMIT $start, $limit");
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
                                    <tr>
                                        <td><?php echo $tip; ?></td>
                                        <td>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                            $statement1->execute(array($row['payment_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                echo '<b>Product Name: </b>' . $row1['product_name'];
                                                echo '<br><b>Quantity: </b>' . $row1['quantity'];
                                                echo '<br><b>Unit Price: Ksh</b>' . $row1['unit_price'];
                                                echo '<br><br>';
                                            }
                                            ?>
                                        </td>
                                        <td><b>Date :</b><?php echo $row['payment_date']; ?><br>
                                            <b>Transaction id :</b><?php echo $row['bank_transaction_info']; ?><br>
                                            <b>Amount Paid :</b> <?php echo 'Ksh' . $row['paid_amount']; ?><br>
                                            <b>Shipping Fee :</b> <?php echo 'Ksh' . $row['shipping_fee']; ?><br>
                                            <b>Payment Status :</b><?php echo $row['payment_status']; ?><br>
                                            <b>Bank Name :</b><?php echo $row['Bank_Name']; ?><br>
                                           <!-- <b>Payment Method :</b><?php echo $row['payment_method']; ?><br>-->
                                        <td>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
                                            $statement1->execute(array($row['customer_email']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                echo '<b>Details: </b>' . $row1['cust_s_address'];
                                                echo '<br><br>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['order_status']; ?></td>
                                        <td><?php echo $row['shipping_status']; ?></td>
                                        <td>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_staff WHERE full_name=?");
                                            $statement1->execute(array($row['driver']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                echo '<b>Driver Name: </b>' . $row1['full_name'];
                                                echo '<br><b>Email: </b>' . $row1['email'];
                                                echo '<br><b>Phone Num: </b>' . $row1['phone'];
                                                echo '<br><br>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <b>Goods :</b><?php echo $row['cust_remark']; ?><br>
                                            <b>Comment :</b><?php echo $row['cust_comment']; ?>
                                            <br>

                                        </td>
                                        <td>
                                            <a href="SpecialOrderReceipt.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-md">Receipt</a> <br><br>
                                            <?php
                                            if ($row['cust_remark'] == '') {
                                                if ($row['shipping_status'] == 'Goods Delivered') {
                                            ?>
                                                    <a href="editform.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-md">Add Remark</a>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
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

<?php require_once('footer.php'); ?>