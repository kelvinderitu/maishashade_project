
<?php
session_start();
include_once '../connection.php';
$sql="SELECT * FROM upload";
$res=mysqli_query($con,$sql) or die(mysqli_error($con));
?>
<html>
<head>
<style type="text/css">
#viewdata table{
    border:1px solid #aaa;
}
#viewdata th{background:#aaa;}
#viewdata td{background:#efefef;}
#viewdata th,td{padding:10px;text-align:left;}
</style>
<ul> <h3>CLIENT PHOTOS</h3></ul><hr>
<table id="viewdata">
	<a href="/Urban-std/main/photographer/forms/Upload/Upload.php">Share Photos</div>
<tr><hr>
<th>Id</th>
<th>Client Name</th>
<th>File Name</th>
<th>Size</th>

<th colspan=2>Action</th>
</tr>
<?php
while($row=mysqli_fetch_assoc($res))
{
echo "<tr><td>";
echo $row['id'];
echo "</td><td>";
echo $row['client'];
echo "</td>
<td>";
echo $row['name'];
echo "</td><td>";
echo number_format(($row['size']/1024),2) . " Kb";
$path = ($_SESSION['user'] == 'user') ? "./" : "../";
echo "
<td><a href='".$path."/View/delete.php?data=".$row['id']."' class='del_doc'>delete</a></td>
<td><a href='".$path."/View/download.php?id=".$row['id']."'>download</a></td></tr>";
}
mysqli_close($con);
?>
</table>
<hr>
<a href="/Urban-std/main/photographer/index.php">Back</div>
<script>
	$(document).ready(function(){
		$('.del_doc').click(function(e){
			e.preventDefault();
			var loc = $(this).attr('href');
			$.ajax({
				url:loc,
				error:err=>{
					alert("An error occured");
					console.log(err)
				},
				success:function(resp){
					if(resp == 1){
						alert("File successfully deleted");
						getPage('<?php echo $path ?>View/View.php')
					}
				}
			})
		})
	})
</script>
