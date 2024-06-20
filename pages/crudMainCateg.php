<?php
        include "../assets/connection.php";
/*----------- Add Main Category ----------------- */
      if(isset($_POST['addMainCategory'])){
        $MainCategName = $_POST['MainCategName'];
        $MainCategNameProdVisibility = $_POST['MainCategNameProdVisibility'];
        $sql = "insert into main_categ (m_categ_name, m_categ_visibility)
        values ('$MainCategName', '$MainCategNameProdVisibility')";
        $sqlrun = mysqli_query($conn, $sql);
        if($sqlrun){
            ?>
          <script>
            AddMainCateg();
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

    /* ---------- Delete Main Category -----------*/
    if (isset($_POST['delete_btn'])) {
        $m_categ_ids = $_POST['m_categ_ids'];

        foreach ($m_categ_ids as $m_categ_id) {
            $m_categ_id = mysqli_real_escape_string($conn, $m_categ_id);
            $newCategoryName = "not selected";

            $oldCategoryName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT m_categ_name FROM main_categ WHERE m_categ_id = '$m_categ_id'"))['m_categ_name'];

            $update_query = "UPDATE sub_categ SET m_categ_name = '$newCategoryName' WHERE m_categ_name = '$oldCategoryName'";
            $update_run = mysqli_query($conn, $update_query);

            $updateP_query = "UPDATE products SET prodM_categ = '$newCategoryName' WHERE prodM_categ = '$oldCategoryName'";
            $updateP_run = mysqli_query($conn, $updateP_query);

            $delete_query = "DELETE FROM main_categ WHERE m_categ_id = '$m_categ_id'";
            $delete_run = mysqli_query($conn, $delete_query);
        }

        if ($delete_run) {
            echo "success";
        }
    }

   /*----------- Edit Main Category ----------------- */
   if (isset($_POST['editMainCat'])) {
    $m_categ_id = $_POST['m_categ_id'];
    $MainCategName = $_POST['MainCategName'];
    $MainCategNameProdVisibility = $_POST['MainCategNameProdVisibility'];

    // Get the old main_categ_name before updating
    $oldMCategoryName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT m_categ_name FROM main_categ WHERE m_categ_id = '$m_categ_id'"))['m_categ_name'];

    $sql = "UPDATE main_categ SET m_categ_name = '$MainCategName', m_categ_visibility = '$MainCategNameProdVisibility' WHERE m_categ_id = '$m_categ_id'";
    $sqlrun = mysqli_query($conn, $sql);

    if ($sqlrun) {
        // Call the function to update the sub_categ table
        ?>
        <script>
            EditMainCategory();
            updateSubCateg($oldMCategoryName, $MainCategName, $conn);
        </script>
        <?php
    } else {
        ?>
        <script>
            ErrorAlert();
        </script>
        <?php
    }
};