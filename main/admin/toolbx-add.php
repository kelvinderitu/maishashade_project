<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    
		//Saving data into the main table tbl_product
		$statement = $pdo->prepare("INSERT INTO tbl_toolbox(
										toolbox_type,
										Quantity
										
									) VALUES (?,?)");
		$statement->execute(array(
										$_POST['toolboxtype'],
										$_POST['quantity']
										
									));

		

	
    	$success_message = 'Toolbox is added successfully.';
    }

?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Toolbox</h1>
	</div>
	<div class="content-header-right">
		<a href="toolbox.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


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
							
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Toolbox Type <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="toolboxtype" class="form-control">
							</div>
						</div>	
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Quantity <br><span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="quantity" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Add Toolbox</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>