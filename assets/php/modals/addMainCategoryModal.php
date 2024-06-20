<?php include "../assets/connection.php" ?>
<form action = "main_category.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Add Main Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class = "subModalInput">
      <label>Category:</label>
      <input name="MainCategName" id="MainCategName" type="text" placeholder="Main Category Name" required>
      <label>Visibility:</label>
      <select name="MainCategNameProdVisibility" id="MainCategNameProdVisibility" required>
        <option value="visible">Visible</option>
        <option value="hidden">Hidden</option>
</select>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addMainCategory" class="btn btn-success" id="addMainCategory">Add Main Category</button>
      </div>
    </div>
  </div>
</form>


