<?php include "../assets/connection.php" ?>
<form action = "main_category.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Edit Main Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class = "subModalInput">
        <input type="hidden" name="m_categ_id" value="<?php echo $row['m_categ_id'] ?>"/>
      <label>Category:</label>
      <input name="MainCategName" id="MainCategName" type="text" placeholder="Main Category Name" value="<?php echo $row['m_categ_name'];?>" required>
      <label>Visibility:</label>
      <select name="MainCategNameProdVisibility" id="MainCategNameProdVisibility" required>
          <?php
          $sql = mysqli_query($conn, "SELECT * FROM main_categ WHERE order_id = '$order_id'");
          $getStatus = mysqli_fetch_array($sql);
          
          // Iterate over the options to create the select dropdown
          $options = ["visible", "hidden"]; 
          
          foreach ($options as $option) {
              $selected = ($row['m_categ_visibility'] == $option) ? 'selected' : '';
              echo '<option value="' . $option . '" ' . $selected  . '>' . $option . '</option>';
          }
          ?>
      </select>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="editMainCat" class="btn btn-success" id="editMainCat">Edit Main Category</button>
      </div>
    </div>
  </div>
</form>

