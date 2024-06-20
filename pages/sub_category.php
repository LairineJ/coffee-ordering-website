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
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="../assets/js/alert/alert.js"></script>
  <title>Cafe Haraya | Sub Category</title>
</head>

<body id="body">
  <div class="grid-container">
    <!----------------- Sidebar --------------------->
    <?php include "../assets/php/extensions/sidebar.php" ?>
    <!-------------------- End Sidebar ---------------->

    <!---------------------- Main --------------------->
    <main class="main-container" id="main-container">
    <?php include "../assets/connection.php" ?>
    <div class="main-title d-flex">
        <p class="font-weight-bold">SUB-CATEGORY</p>
        <div class="d-flex justify-content-end align-items-center">
            <button class="delete_btn btn btn-danger d-flex align-items-center" style="padding: .7rem; height: 2.4rem; margin-right: .5rem;"><i class="fas fa-trash" style="margin-right: 5px;"></i>Delete</button>
            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal" style="padding: .7rem; height: 2.4rem;"><i class="fas fa-plus" style="margin-right: 5px;"></i>Add Sub-Category</button>
        </div>
    </div>
<div id="container">

<table id="adminTable" class="table table-striped" style="width:100% table-layout: fixed;" >
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllCheckboxes" value="Check All" onClick='$(":checkbox").attr("checked",true);'></th>
                <th>Type</th>
                <th>Category</th>
                <th>Visibility</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql="select * from sub_categ";
            $result=mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr data-product-id="<?php echo $row['s_categ_id']; ?>">
                    <td style="align-items: center; vertical-align: middle">   
                       <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;"><input type="hidden" name="initialMCateg" value="<?php echo $row['s_categ_name'];?>">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-img w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle; width: 1px; white-space: nowrap;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                </tr>
                <!-- Edit Product Modal -->
                <div class="modal fade" id="EditSubCategModal_<?php echo $row['s_categ_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <?php include "../assets/php/modals/editSubCategoryModal.php"; ?>
            </div>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
                <th></th>
                <th>Type</th>
                <th>Category</th>
                <th>Visibility</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
    <div class="modal fade" id="addSubCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <?php include '../assets/php/modals/addSubCategoryModal.php';?>
    </div>
        </div>
    <!-------------------------- End Main -------------------------->
    </main>
  </div>
  <?php include "crudSubCateg.php"?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    //Image Preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgPreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    //Delete Button
    $(document).ready(function () {
        $('.delete_btn').click(function () {
            deleteSubCateg();
        });
    });

    //Fetch Main Category
    $(document).ready(function () {
        const grid = $('#adminTable');

        $.ajax({
            url: 'scateg_display.php',
            method: 'GET',
            dataType: 'html',
            success: function (html) {
                grid.html(html);

                const dataTable = $('#adminTable').DataTable({
                    paging: true,
                    searching: true,
                });

                $('#selectAllCheckboxes').on('change', function () {
                    const isChecked = $(this).prop('checked');
                    $('input[name="sCateg_checkbox[]"]').prop('checked', isChecked);
                    dataTable.rows().invalidate().draw();
                });

                $('input[name="sCateg_checkbox[]"]').on('change', function () {
                    const allChecked = $('input[name="sCateg_checkbox[]"]:checked').length === $('input[name="sCateg_checkbox[]"]').length;
                    $('#selectAllCheckboxes').prop('checked', allChecked);
                    dataTable.rows().invalidate().draw();

                    const checkboxValue = $(this).val();
                    const isChecked = $(this).prop('checked');
                    console.log(`Checkbox ${checkboxValue} is ${isChecked ? 'checked' : 'unchecked'}`);
                });
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    });
  </script>
</body>
</html>