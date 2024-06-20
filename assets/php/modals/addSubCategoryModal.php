<?php include "../assets/connection.php" ?>
<form action = "sub_category.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Add Sub Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class = "subModalInput">
      <label>Category:</label>
      <input name="SubCategName" id="SubCategName" type="text" placeholder="Sub Category Name" required>
     <label>Type:</label>
     <select name="MainCateg" id="MainCateg">
     <?php
    include "../assets/connection.php";
    $sql = mysqli_query($conn, "SELECT * FROM main_categ where m_categ_name != 'not selected'");
    while ($mCateg = mysqli_fetch_array($sql)) {
        echo '<option>' . $mCateg['m_categ_name'] . '</option>';
    }
    ?>
     </select>
      <label>Visibility:</label>
      <select name="SubCategNameProdVisibility" id="SubCategNameProdVisibility" required>
        <option value="visible">Visible</option>
        <option value="hidden">Hidden</option>
      </select>
</div>
      <div class="admin-modal-img">
      <img id="imgPreview" src="data:image/png;base64" style="width: 100px; height: 100px; margin-bottom: .5rem;">
      <input type="file" name="SubCategImg" id="SubCategImg" accept=".png, .jpg, .jpeg" placeholder="Image" required onchange="readURL(this);">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addSubCategory" class="btn btn-success" id="addSubCategory">Add Sub Category</button>
      </div>
    </div>
  </div>
</form>