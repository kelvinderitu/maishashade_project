<?php



$PROID = $_GET['id'];
$product = new Product();
$singleproduct = $product->single_product($PROID);

?>


<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Increse Product Quantity</h3>
  </div>
  <!-- /.col-lg-12 -->
</div>
<form class="form-horizontal span6" action="controller.php?action=edit" method="POST" />

<div class="row">

  <div class="form-group">
    <div class="col-md-8">
      <label class="col-md-4 control-label" for="OWNERNAME">Product Name:</label>

      <div class="col-md-8">
        <input class="form-control input-sm" readonly id="OWNERNAME" name="OWNERNAME" placeholder="Owner Name" type="text" value="<?php echo $singleproduct->OWNERNAME; ?>">
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-8">
      <label class="col-md-4 control-label" for="CATEGORY">Category:</label>

      <div class="col-md-8">
        <select class="form-control input-sm" name="CATEGORY" readonly id="CATEGORY">
          <option value="None">Select Category</option>
          <?php
          //Statement

          $category = new Category();
          $singlecategory = $category->single_category($singleproduct->CATEGID);
          echo  '<option SELECTED  value=' . $singlecategory->CATEGID . ' >' . $singlecategory->CATEGORIES . '</option>';


          $mydb->setQuery("SELECT * FROM `tblcategory` where CATEGID <> '" . $singlecategory->CATEGID . "'");
          $cur = $mydb->loadResultList();
          foreach ($cur as $result) {
            echo  '<option  value=' . $result->CATEGID . ' >' . $result->CATEGORIES . '</option>';
          }
          ?>

        </select>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-8">
      <label class="col-md-4 control-label" for="PRODESC">Description:</label>

      <div class="col-md-8">
        <input id="PROID" name="PROID" readonly type="hidden" value="<?php echo $singleproduct->PROID; ?>">
        <textarea class="form-control input-sm" id="PRODESC" readonly name="PRODESC" cols="1" rows="3"><?php echo $singleproduct->PRODESC; ?>
                      </textarea>

      </div>
    </div>
  </div>
  <div class="col-lg-4 mb-4">

    <div><input type="hidden" readonly="true" name="sender" value="<?php echo $r1['email'];  ?>" class="form-control" required></div>
  </div>
  <div class="col-md-4">
  </div>
  <script>
    function loanamount() {
      var original = document.getElementById("amount").value;
      var day = document.getElementById("days").value;


      var total = (Number(original) + Number(day)) / 1;



      document.getElementById("totalpaid").value = total;


    }
  </script>


  <div class="col-md-4">
    <div class="font-italic">Available Quantity<span style="color:red">*</span></div>
    <div><input type="number" class="form-control" name="amount" id="amount" readonly value="<?php echo $singleproduct->PROQTY; ?>"></div>
  </div><br>
  <div class="col-md-4">
    <div class="font-italic">Add New Number<span style="color:red">*</span></div>

    <select onchange="loanamount()" name="new" id="days" class="form-control" required>
      <option value="">Select Number </option>
      <?php
      for ($i = 1; $i <= 1000; $i++) {
        echo "<option value='" . $i . "'>" . $i . "</option>";
      }
      ?>
    </select>
  </div><br>
  <div class="col-lg-4 mb-4">
    <div class="font-italic">New Quantity<span style="color:red">*</span></div>
    <div><input type="number" class="form-control" name="PROQTY" readonly="true" id="totalpaid"></div>
  </div>

  <div class="form-group">
    <div class="col-md-8">
      <div class="col-md-3">
        <input class="form-control input-sm" readonly id="ORIGINALPRICE" name="ORIGINALPRICE" placeholder="Original Price" type="hidden" value="<?php echo $singleproduct->ORIGINALPRICE; ?>">
      </div>
      <div class="col-md-3">
        <input class="form-control input-sm" readonly id="PROPRICE" name="PROPRICE" placeholder="Price" type="hidden" step="any" value="<?php echo $singleproduct->PROPRICE; ?>">
      </div>
    </div>
  </div>



  <div class="form-group">
    <div class="col-md-8">
      <label class="col-md-4 control-label" for="idno"></label>

      <div class="col-md-8">
        <button class="btn  btn-primary btn-sm" name="save" type="submit"><span class="fa fa-save fw-fa"></span> Update</button>
      </div>
    </div>
  </div>


</div>



<!--/.fluid-container-->
</form>