<?php include "../assets/connection.php";
session_start();
?>
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
    <form action="product.php" method="POST" enctype="multipart/form-data">
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="admin-modal-cmb">
      <div class="admin-modal-left">
        <input type="hidden" name="prod_id" value="<?php echo $row['prod_id'] ?>"/>
        <label>Name:</label>
        <input name="ProdName" id="ProdName" type="ProdName" value="<?php echo $row['prod_name'];?>" required>
        <label>Category:</label>
        <select name="MainCateg" id="MainCateg" onchange="my_fun2('<?php echo $row['prod_id']; ?>', this.value, '<?php echo $row['prod_categ']; ?>');">
<?php
    include "../assets/connection.php";
    $sql = mysqli_query($conn, "SELECT * FROM main_categ where m_categ_name != 'not selected'");
    while ($mCateg = mysqli_fetch_array($sql)) {
        $selected = ($mCateg['m_categ_name'] == $row['prodM_categ']) ? 'selected' : '';
        $valueS = $mCateg['m_categ_name'];
        $valScat = $row['prod_categ'];
        $pdID = $row['prod_id'];
        if ($selected) {
            $selectedValue = $valueS; // Set the selected value
        }
        echo '<option value="' . $valueS . '" ' . $selected  . '>' . $mCateg['m_categ_name'] . '</option>';
    }
?>
</select>
<label>Type:</label>
      <div id="type2">
      <select name="ProductCateg" class="productCateg" data-product-id="<?php echo $row['prod_id']; ?>">
      <?php include 'helper3.php'?>
      </select>
      </div>
      <label>Visibility:</label>
      <select name="ProdVisibility" id="ProdVisibility" value="<?php echo $row['prod_visibility'];?>" required>
        <?php
          $sql = mysqli_query($conn, "SELECT * FROM products WHERE prod_id = '$prod_id'");
          $getStatus = mysqli_fetch_array($sql);
          
          // Iterate over the options to create the select dropdown
          $options = ["visible", "hidden"]; 
          
          foreach ($options as $option) {
              $selected = ($row['prod_visibility'] == $option) ? 'selected' : '';
              echo '<option value="' . $option . '" ' . $selected  . '>' . $option . '</option>';
          }
          ?>
      </select>
      </div>
      <div class="admin-modal-right">
      <label>Price:</label>
      <input type="number" name="prodPrice" id="prodPrice" value="<?php echo $row['prod_price'];?>" placeholder="Price" required min="0" step="0.01" oninput="validity.valid||(value='');" pattern="\d+(\.\d{2})?">
      <label>Calories:</label>
      <input type="number" name="prodCalo" id="prodCalo" value="<?php echo $row['prod_calo'];?>" required min="0" onkeypress="return (event.charCode > 47 && event.charCode < 58)">
      <label>Quantity:</label>
      <input type="number" name="prodQuantity" id="prodQuantity" value="<?php echo $row['prod_quantity'];?>" required min="0" onkeypress="return (event.charCode > 47 && event.charCode < 58)">
      <label>Profit:</label>
      <input type="number" name="prodProfit" id="prodProfit" value="<?php echo $row['prod_profit'];?>" required min="0" onkeypress="return (event.charCode > 47 && event.charCode < 58)">
      <input type="hidden" name="prodImgData" id="prodImgData<?php echo $row['prod_id'] ?>" value="<?php echo base64_encode($row['prod_img']); ?>" required>
      </div>
      </div>
      <div class="admin-modal-bottom">
      <div class="admin-modal-img">
      <img id="imgPreview<?php echo $row['prod_id'] ?>" src="data:image/png;base64,<?php echo base64_encode($row['prod_img']); ?>" style="width: 100px; height: 100px;">
      <input type="file" name="prodImg" id="prodImgUpload<?php echo $row['prod_id'] ?>">
      </div>
      <div class="admin-modal-desc">
      <textarea name="prodDesc" id="prodDesc" required><?php echo $row['prod_desc'];?></textarea>
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="editProduct" class="btn btn-success" id="editProduct">Edit Product</button>
      </div>
      </form>
    </div>
  </div>


<script>
    $(document).ready(function() {
        // When the file input changes (new image selected)
        $('#prodImgUpload<?php echo $row['prod_id'] ?>').on('change', function() {
            var fileInput = this;
            var reader = new FileReader();

            reader.onload = function() {
                // Update the preview image with the selected image
                $('#imgPreview<?php echo $row['prod_id'] ?>').attr('src', reader.result);

                // Update the hidden input field with the new image data (base64 format)
                $('#prodImgData<?php echo $row['prod_id'] ?>').val(reader.result.split(',')[1]); // Remove 'data:image/png;base64,' prefix
            };

            // Read the selected image as a data URL
            if (fileInput.files && fileInput.files[0]) {
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    });
</script>
