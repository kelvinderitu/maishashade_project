<?php require_once('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<center><h2>NYABONDO BRICKS</h2>
		<h4>CUSTOMER SITE ANALYSIS REPORT</h4>
        <h5>
			Po Box 64-40109 Sondu, <br>
			Kisumu, Kenya<br>
			Phone: +254 057 7016805<br>
			Email: nyabondobricks@gmail.com</h5>
</center>


<section class="content">

  <div class="row">
    <div class="col-md-12">


      <div class="box box-info">
        
        <div class="box-body table-responsive">
          <table id="example1" class="table  table-hover table-striped">
			<thead>
			    <tr>
			        <th>#</th>
                    <th>CUSTOMER</th>
			        <th>SITE DETAILS </th>  
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
                $id=$_GET['id']; 
            	$statement = $pdo->prepare("SELECT * FROM tbl_bookings WHERE  photographer_status='Delivered' and repstats='Approved' and id='$id' and email='".$_SESSION['customer']['cust_email']."'");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
	                    <td><?php echo $i; ?></td>
	                    <td>
                            <b>Name:</b><br> <?php echo $row['full_name']; ?><br>
                            <b>Phone:</b><br> <?php echo $row['phone']; ?><br><br>
                           
                        </td>
                        <td>
                        <b>Location :</b><br> <?php echo $row['location']; ?><br>
                        <b>Registration :</b><br> <?php echo $row['reg']; ?><br>
                        <b>Land Size:</b><br> <?php echo $row['lndsize']; ?><br>
                        <b>Land Slope:</b><br> <?php echo $row['slope']; ?><br>
                        <b>Soil Depth (Feet):</b><br> <?php echo $row['depth']; ?><br><br>
                        <font color="red"><b>Recommendation:</b></font><br> <?php echo $row['recommandation']; ?><br>
                        </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div>
  </section>
      
</body>
</html>


