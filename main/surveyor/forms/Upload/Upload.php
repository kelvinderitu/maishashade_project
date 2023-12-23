
<!DOCTYPE html>
<html>
<head>
<title>Success</title>
<link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div >
<div id="header">
<div id="logo">
</div>
</div>

<div id="content">
    
<?php
session_start();
include('conn.php');
include('configcontact.php');
$path = ($_SESSION['user'] == 'user') ? "./" : "../";
?>
<form action= "<?php echo $path ?>Upload/UploadProcess.php" method="post" enctype="multipart/form-data">
<table border="0" cellpadding="1"
cellspacing="1">
<tr>
<td><h2>ADD PHOTO</h2></td><br>
</tr>

<tr>
<td>
<input type="hidden" name="MAX_FILE_SIZE"value="16000000">
<input name="userfile" type="file" id="userfile"> <br><br>
     
<div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Select Client<span class="text-danger ml-2">*</span></label>
                         <?php
                        $qry= "SELECT * FROM tbl_customer where  cust_status='1'";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          echo ' <select required name="client" onchange="classArmDropdown(this.value)" class="form-control mb-1">';
                          echo'<option value="">--Select Client--</option>';
                          while ($rows = $result->fetch_assoc()){
                          echo'<option value="'.$rows['cust_name'].'" >'.$rows['cust_name'].'</option>';
                              }
                                  echo '</select>';
                              }
                            ?>  
                        </div></div>
</td><br><br>
<td><br><br><input name="upload"type="submit" class="box" id="upload" value=" Upload "></td>

</tr>
</table>
</form><hr>
<a href="../../index.php">Back</a>
    
</div>

<div class= "clear"></div>

<div id="footer">
</div>
</div>
</body>
</html>