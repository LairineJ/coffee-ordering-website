<?php include "../assets/connection.php" ?>
<form action = "product.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="admin-modal-cmb">
        <div class="admin-modal-left">
      <label>Name:</label>
      <input name="ProdName" id="ProdName" type="text" placeholder="Name" required>
      <?php $sql = mysqli_query($conn, "select * from main_categ"); ?>
      <label>Category:</label>
      <select name="MainCateg" id="MainCateg" onchange="my_fun(this.value);">
<?php
    include "../assets/connection.php";
    $sql = mysqli_query($conn, "SELECT * FROM main_categ where m_categ_name != 'not selected'");
    while ($mCateg = mysqli_fetch_array($sql)) {
        $selected = ($mCateg['m_categ_name'] == $row['prodM_categ']) ? 'selected' : '';
        $value = $mCateg['m_categ_name'];
        echo '<option value="' . $value . '" ' . $selected  . '>' . $mCateg['m_categ_name'] . '</option>';
    }
    ?>
</select>
<label>Type:</label>
      <div id="type">
        <select></select>
      </div>
      <label>Visibility:</label>
      <select name="ProdVisibility" id="ProdVisibility" required>
        <option value="visible">Visible</option>
        <option value="hidden">Hidden</option>
      </select>
      </div>
      <div class="admin-modal-right">
      <label>Price:</label>
      <input type="number" name="prodPrice" id="prodPrice" placeholder="Price" required min="0" step="0.01" oninput="validity.valid||(value='');" pattern="\d+(\.\d{2})?">
      <label>Calories:</label>
      <input type="number" name="prodCalo" id="prodCalo" placeholder="Calories" required min="0" onkeypress="return (event.charCode > 47 && event.charCode < 58)">
      <label>Quantity:</label>
      <input type="number" name="prodQuantity" id="prodQuantity" placeholder="Quantity" required min="0" onkeypress="return (event.charCode > 47 && event.charCode < 58)">
      <label>Profit:</label>
      <input type="number" name="prodProfit" id="prodProfit" placeholder="Profit" required min="0" onkeypress="return (event.charCode > 47 && event.charCode < 58)">
      </div>
      </div>
      <div class="admin-modal-bottom">
      <div class="admin-modal-img">
      <img id="imgPreview" src="data:image/png;base64" style="width: 100px; height: 100px; margin-bottom: .5rem;">
      <input type="file" name="prodImg" id="prodImg" accept=".png, .jpg, .jpeg" placeholder="Image" required onchange="readURL(this);">
      </div>
      <div class="admin-modal-desc">
      <textarea name="prodDesc" id="prodDesc" placeholder="Write something.." required></textarea>
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addProduct" class="btn btn-success" id="addProduct">Add Product</button>
      </div>
    </div>
  </div>
</form>