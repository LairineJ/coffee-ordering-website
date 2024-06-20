<?php include "../assets/connection.php" ?>
<form action = "sub_category.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Edit Sub Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class = "subModalInput">
        <input type="hidden" name="s_categ_id" value="<?php echo $row['s_categ_id'] ?>"/>
      <label>Category:</label>
      <input name="SubCategName" id="SubCategName" type="text" placeholder="Sub Category Name" value="<?php echo $row['s_categ_name'];?>" required>
     <label>Type:</label>
     <select name="MainCateg" id="MainCateg" value="<?php echo $row['m_categ_name'];?>">
     <?php
    include "../assets/connection.php";
    $sql = mysqli_query($conn, "SELECT * FROM main_categ where m_categ_name != 'not selected'");
    while ($mCateg = mysqli_fetch_array($sql)) {
        $selected = ($mCateg['m_categ_name'] == $row['m_categ_name']) ? 'selected' : '';
        echo '<option ' . $selected  . '>' . $mCateg['m_categ_name'] . $mID. '</option>';
    }
    ?>
     </select>
      <label>Visibility:</label>
      <select name="SubCategNameProdVisibility" id="SubCategNameProdVisibility" required>
        <<?php
        // Iterate over the options to create the select dropdown
        $options = ["visible", "hidden"]; 
        
        foreach ($options as $option) {
            $selected = ($row['s_categ_visibility'] == $option) ? 'selected' : '';
            echo '<option value="' . $option . '" ' . $selected  . '>' . $option . '</option>';
        }
        ?>
        </select>
</div>
      <input type="hidden" name="subCategImgData" id="subCategImgData<?php echo $row['s_categ_id'] ?>" value="<?php echo base64_encode($row['s_categ_img']); ?>" required>
      <div class="admin-modal-img">
      <img id="imgPreview<?php echo $row['s_categ_id'] ?>" src="data:image/png;base64,<?php echo base64_encode($row['s_categ_img']); ?>" style="width: 100px; height: 100px;">
      <input type="file" name="subCategImg" id="SubCategImgUpload<?php echo $row['prod_id'] ?>">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="editSubCat" class="btn btn-success" id="editSubCat">Edit Sub Category</button>
      </div>
    </div>
  </div>
</form>

<script>
    $(document).ready(function() {
        // When the file input changes (new image selected)
        $('#SubCategImgUpload<?php echo $row['s_categ_id'] ?>').on('change', function() {
            var fileInput = this;
            var reader = new FileReader();

            reader.onload = function() {
                // Update the preview image with the selected image
                $('#imgPreview<?php echo $row['s_categ_id'] ?>').attr('src', reader.result);

                // Update the hidden input field with the new image data (base64 format)
                $('#subCategImgData<?php echo $row['s_categ_id'] ?>').val(reader.result.split(',')[1]); // Remove 'data:image/png;base64,' prefix
            };

            // Read the selected image as a data URL
            if (fileInput.files && fileInput.files[0]) {
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    });
</script>
