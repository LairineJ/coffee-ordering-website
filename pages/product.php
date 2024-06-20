<?php
session_start();
include '../assets/connection.php';

if(isset($_SESSION['superAdmin'])){
  $adminLvl = $_SESSION['superAdmin'];
}else{
  $adminLvl = $_SESSION['admin'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/images/icon/logo.png">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script  src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="../assets/js/alert/alert.js"></script>
  <title>Cafe Haraya | Product</title>
  <script>
  function my_fun(str) {
    if (window.XMLHttpRequest){
      xmlhttp = new XMLHttpRequest();
    }else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange= function(){
      if (this.readyState==4 && this.status==200) {
        document.getElementById('type').innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "helper.php?value="+str, true);
    xmlhttp.send();
  }
</script>

<script>
  function my_fun2(prodID, selectedValue, valScat) {
    console.log("my_fun2() called with prodID: " + prodID + ", selectedValue: " + selectedValue + ", and valScat: " + valScat);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var selectElements = document.getElementsByClassName('productCateg');
            for (var i = 0; i < selectElements.length; i++) {
                var selectElement = selectElements[i];
                if (selectElement.dataset.productId == prodID) {
                    selectElement.innerHTML = this.responseText;
                    break;
                }
            }
        }
    };

    // Append the anotherValue as a query parameter
    xmlhttp.open("GET", "helper2.php?pdID=" + prodID + "&selectedValue=" + selectedValue + "&valScat=" + valScat, true);
    xmlhttp.send();
}
</script>


  <title>Product</title>
</head>

<body id="body">
  <div class="grid-container">
    <!----------------- Sidebar --------------------->
    <?php include "../assets/php/extensions/sidebar.php" ?>
    <!-------------------- End Sidebar ---------------->

    <!---------------------- Main --------------------->
    <main class="main-container" id="main-container">
    <?php include "../assets/connection.php" ?>
    <div id="container">
    <script src="../assets/js/table.js"></script>
     <div class="main-title d-flex">
        <p class="font-weight-bold">PRODUCTS</p>
        <div class="d-flex justify-content-end align-items-center">
            <button class="delete_btn btn btn-danger d-flex align-items-center" style="padding: .7rem; height: 2.4rem; margin-right: .5rem;"><i class="fas fa-trash" style="margin-right: 5px;"></i>Delete</button>
            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#AddProductModal" style="padding: .7rem; height: 2.4rem;"><i class="fas fa-plus" style="margin-right: 5px;"></i>Add Product</button>
        </div>
    </div>
    <table id="adminTable" class="table table-striped" style="width:100%" >
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllCheckboxes" value="Check All" onClick='$(":checkbox").attr("checked",true);'></th>
                <th>Name</th>
                <th>Type</th>
                <th>Category</th>
                <th>Visibility</th>
                <th>Price</th>
                <th>Description</th>
                <th>Calories</th>
                <th>Quantity</th>
                <th>Profit</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql="select * from products";
            $result=mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr data-product-id="<?php echo $row['prod_id']; ?>">
                    <td style="align-items: center; vertical-align: middle">   
                        <input type="checkbox" name="product_checkbox[]" value="<?php echo $row['prod_id']; ?>">
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prod_name'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prodM_categ'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prod_categ'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prod_visibility'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prod_price'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prod_desc'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prod_calo'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prod_quantity'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['prod_profit'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo '<img src="data:image/png;base64,' .base64_encode($row['prod_img']) . '" style="width:60px; height: 60px;" />'; ?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <button name="edit_btn" style="background: transparent; border: none;"  class="edit_btn" data-bs-toggle="modal" data-bs-target="#EditProductModal_<?php echo $row['prod_id']?>"><span class="material-icons-outlined" style="font-size: 2rem; color: #ffc107; cursor: pointer;">edit</span></button>
                    </td>
                </tr>
                <!-- Edit Product Modal -->
                <div class="modal fade" id="EditProductModal_<?php echo $row['prod_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <?php include "../assets/php/modals/editProductModal.php"; ?>
            </div>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
                <th></th>
                <th>Name</th>
                <th>Type</th>
                <th>Category</th>
                <th>Visibility</th>
                <th>Price</th>
                <th>Description</th>
                <th>Calories</th>
                <th>Quantity</th>
                <th>Profit</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
        </div>
        

    <!-------------------------- Modals -------------------------->
    
    <div class="modal fade" id="AddProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <?php include '../assets/php/modals/addProductModal.php';?>
    </div>


    </main>
    <!-------------------------- End Main -------------------------->

  </div>

  <?php include "crudProd.php"?>

  <!---------------- Scripts ------------------>
  <!-------------- ApexCharts ----------------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>

  <!------------- Custom JS ---------------->
  <script src="../assets/js/dashboard.js"></script>
  <script src="../assets/js/productCrud.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgPreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(document).ready(function () {
        $(document).on('click', '.delete_btn', function () {
            deleteProd();
        });

         var headerCheckbox = document.getElementById('selectAllCheckboxes');

    // Find all checkboxes with the class 'user_checkbox'
    var checkboxes = document.querySelectorAll('input[name="product_checkbox[]"]');

    // Function to check or uncheck all checkboxes
    function toggleCheckboxes(checked) {
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = checked;
        });
    }

        // Attach a click event listener to the header checkbox
    headerCheckbox.addEventListener('click', function () {
        // Get the state of the header checkbox
        var isChecked = headerCheckbox.checked;

        // Set the state of all row checkboxes to match the header checkbox
        toggleCheckboxes(isChecked);
    });

    });             
</script>

</body>
</html>
