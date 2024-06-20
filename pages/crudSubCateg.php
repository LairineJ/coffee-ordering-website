<?php
        include "../assets/connection.php";
/*----------- Add sub Category ----------------- */
      if(isset($_POST['addSubCategory'])){
        $SubCategName = $_POST['SubCategName'];
        $MainCateg = $_POST['MainCateg'];
        $SubCategNameProdVisibility = $_POST['SubCategNameProdVisibility'];
        $SubCategImg = addslashes(file_get_contents($_FILES['SubCategImg']['tmp_name']));
        $sql = "insert into sub_categ (s_categ_name, m_categ_name, s_categ_visibility, s_categ_img)
        values ('$SubCategName', '$MainCateg', '$SubCategNameProdVisibility', '$SubCategImg')";
        $sqlrun = mysqli_query($conn, $sql);
        if($sqlrun){
            ?>
          <script>
            AddSubCateg();
        </script>
          <?php
        }
        else {
          ?>
          <script>
              ErrorAlert();
          </script>
          <?php
      }
    };

    /* ---------- Delete subcateg -----------*/
    if (isset($_POST['delete_btn'])) {
      $s_categ_ids = $_POST['s_categ_ids'];

      foreach ($s_categ_ids as $s_categ_id) {
          $s_categ_id = mysqli_real_escape_string($conn, $s_categ_id);

          mysqli_query($conn, 'SET foreign_key_checks = 0');

          $update_products_query = "UPDATE products SET prod_categ = 'not selected' WHERE prod_categ = (SELECT s_categ_name FROM sub_categ WHERE s_categ_id = '$s_categ_id')";
          $update_products_run = mysqli_query($conn, $update_products_query);

          mysqli_query($conn, 'SET foreign_key_checks = 1');

          if (!$update_products_run) {
              echo "Error updating products: " . mysqli_error($conn);
              exit; 
          }

          $delete_query = "DELETE FROM sub_categ WHERE s_categ_id = '$s_categ_id'";
          $delete_run = mysqli_query($conn, $delete_query);

          if (!$delete_run) {
              echo "Error deleting sub category: " . mysqli_error($conn);
              exit;
          }
      }

      echo "success";
  }

   /*----------- Edit Product ----------------- */
   if (isset($_POST['editSubCat'])) {
    $s_categ_id = $_POST['s_categ_id'];
    $SubCategName = $_POST['SubCategName'];
    $MainCateg = $_POST['MainCateg'];
    $SubCategNameProdVisibility = $_POST['SubCategNameProdVisibility'];

    $oldSCategoryName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT s_categ_name FROM sub_categ WHERE s_categ_id = '$s_categ_id'"))['s_categ_name'];
    $oldMCategoryName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT m_categ_name FROM sub_categ WHERE s_categ_id = '$s_categ_id'"))['m_categ_name'];

     $sql = "update sub_categ set s_categ_name = '$SubCategName', m_categ_name = '$MainCateg', s_categ_visibility = '$SubCategNameProdVisibility' where s_categ_id = '$s_categ_id'";
        $sqlrun = mysqli_query($conn, $sql);
        if($sqlrun){
          // Call the function to update the sub_categ table
          updateSubCateg($oldSCategoryName, $SubCategName, $conn);
          updateMainCateg($oldMCategoryName, $MainCateg, $conn);
            ?>
          <script>
            EditSubCategory();
        </script>
          <?php
        }
        else {
          ?>
          <script>
              ErrorAlert();
          </script>
          <?php
      }

};
function updateSubCateg($oldSCategoryName, $newSCategoryName, $conn) {
  $sql = "UPDATE products SET prod_categ = '$newSCategoryName' WHERE prod_categ = '$oldSCategoryName'";
  $sqlrun = mysqli_query($conn, $sql);
};

function updateMainCateg($oldMCategoryName, $newMCategoryName, $conn) {
  $sql = "UPDATE products SET prodM_categ = '$newMCategoryName' WHERE prodM_categ = '$oldMCategoryName'";
  $sqlrun = mysqli_query($conn, $sql);
};
  ?>