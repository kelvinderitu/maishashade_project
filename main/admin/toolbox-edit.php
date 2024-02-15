<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    

        	


        	$statement = $pdo->prepare("UPDATE tbl_toolbox SET 
        							toolbox_type=?, 
        							quantity=? 
        						

        							WHERE toolbox_id=?");
        	$statement->execute(array(
        							$_POST['p_name'],
        							
        							$_POST['p_qty'],
        							
        							
        							$_REQUEST['id']
        						));
        
		

	
    	$success_message = 'Product is updated successfully.';}
    

?>




<section class="content-header">
	<div class="content-header-left">
		<h1>Edit toolbox</h1>
	</div>
	<div class="content-header-right">
		<a href="toolbox.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_toolbox WHERE toolbox_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$p_name = $row['toolbox_type'];
	$p_qty = $row['quantity'];
	
}






?>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

				<div class="box box-info">
					<div class="box-body">
						
					
					
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Toolbox Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
							</div>
						</div>	
						
						
							
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Quantity <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="p_qty" class="form-control" value="<?php echo $p_qty; ?>">
							</div>
						</div>
						
						
						
						
						
						
						
					
					
					
						
						
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>