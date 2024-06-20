<?php
include '../assets/connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

        /*----------- Add Product ----------------- */
        if(isset($_POST['addProduct'])){
            $prodName = $_POST['ProdName'];
            $prodMcateg = $_POST['MainCateg'];
            $prodScateg = $_POST['ProductCateg'];
            $prodVisibility = $_POST['ProdVisibility'];
            $prodPrice = $_POST['prodPrice'];
            $prodDesc = $_POST['prodDesc'];
            $prodCalo = $_POST['prodCalo'];
            $prodQuantity = $_POST['prodQuantity'];
            $prodProfit = $_POST['prodProfit'];
            $prodImg = addslashes(file_get_contents($_FILES['prodImg']['tmp_name']));

            if (strpos($prodPrice, '.') === false) {
                $prodPrice .= '.00'; 
                $sql = "insert into products (prod_name, prodM_categ, prod_categ, prod_visibility, prod_price, prod_desc, prod_calo, prod_quantity, prod_img, prod_profit)
                    values ('$prodName', '$prodMcateg', '$prodScateg', '$prodVisibility', '$prodPrice', '$prodDesc', '$prodCalo', '$prodQuantity', '$prodImg', '$prodProfit')";
                    $sqlrun = mysqli_query($conn, $sql);
                    if($sqlrun){
                        ?>
                    <script>
                        AddProd();
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
            }else{
                $sql = "insert into products (prod_name, prodM_categ, prod_categ, prod_visibility, prod_price, prod_desc, prod_calo, prod_quantity, prod_img, prod_profit)
            values ('$prodName', '$prodMcateg', '$prodScateg', '$prodVisibility', '$prodPrice', '$prodDesc', '$prodCalo', '$prodQuantity', '$prodImg', '$prodProfit')";
            $sqlrun = mysqli_query($conn, $sql);
            if($sqlrun){
                ?>
              <script>
                AddProd();
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
            }
        };

        /* ---------- Delete product -----------*/
        if (isset($_POST['delete_ids'])) {
            $delete_ids = $_POST['delete_ids'];

            foreach ($delete_ids as $product_id) {
    $product_id = mysqli_real_escape_string($conn, $product_id);

    $delete_query = "DELETE FROM products WHERE prod_id = '$product_id'";
    $delete_run = mysqli_query($conn, $delete_query);

    // Check if deletion is successful
    if ($delete_run) {
        echo 'Success';
    } else {
        echo 'Error';
    }
}
        }

         /*----------- Edit Product ----------------- */
         if (isset($_POST['editProduct'])) {
          $product_id = $_POST['prod_id'];
          $prodName = $_POST['ProdName'];
          $prodMcateg = $_POST['MainCateg'];
          $prodScateg = $_POST['ProductCateg'];
          $prodVisibility = $_POST['ProdVisibility'];
          $prodPrice = $_POST['prodPrice'];
          $prodDesc = $_POST['prodDesc'];
          $prodCalo = $_POST['prodCalo'];
          $prodQuantity = $_POST['prodQuantity'];
          $prodProfit = $_POST['prodProfit'];

          // Check if a new file is uploaded
          if (isset($_FILES['prodImg']['tmp_name']) && !empty($_FILES['prodImg']['tmp_name'])) {
            $prodImg = addslashes(file_get_contents($_FILES['prodImg']['tmp_name']));
            $qqq = "update products set prod_name = '$prodName', prodM_categ = '$prodMcateg', prod_categ = '$prodScateg', prod_visibility = '$prodVisibility', prod_price = '$prodPrice', prod_desc = '$prodDesc', prod_calo = '$prodCalo', prod_img = '$prodImg', prod_quantity = '$prodQuantity', prod_profit = '$prodProfit' where prod_id = '$product_id'";
       } else {
           // Retain the existing image data in the database
           $qqq = "update products set prod_name = '$prodName', prodM_categ = '$prodMcateg', prod_categ = '$prodScateg', prod_visibility = '$prodVisibility', prod_price = '$prodPrice', prod_desc = '$prodDesc', prod_calo = '$prodCalo', prod_quantity = '$prodQuantity', prod_profit = '$prodProfit' where prod_id = '$product_id'";
       }

       $sqlrun = mysqli_query($conn, $qqq);
       if ($sqlrun) {
           ?>
           <script>
               EditProd();
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
?>