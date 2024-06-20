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
  <title>Cafe Haraya | Order</title>
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
        <p class="font-weight-bold">ORDERS</p>
        <div class="d-flex justify-content-end align-items-center">
            <button class="delete_btn btn btn-danger d-flex align-items-center" name="delete_btn" style="padding: .7rem; height: 2.4rem; margin-right: .5rem;"><i class="fas fa-trash" style="margin-right: 5px;"></i>Delete</button>
        </div>
    </div>
    <div id="container">

    <table id="adminTable" class="table table-striped" style="width:100% table-layout: fixed;" >
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllCheckboxes" value="Check All" onClick='$(":checkbox").attr("checked",true);'></th>
                <th>Order ID</th>
                <th>Email</th>
                <th>Address</th>
                <th>Items Ordered</th>
                <th>Subtotal</th>
                <th>Shipping Fee</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Ordered Time</th>
                <th>Completed Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql="select * from orders";
            $result=mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr data-product-id="<?php echo $row['order_id']; ?>">
                    <td style="align-items: center; vertical-align: middle">   
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                    <td style="align-items: center; vertical-align: middle; width: 1px; white-space: nowrap;">
                        <div class='skeleton skeleton-text w-50'></div>
                    </td>
                </tr>
                <!-- Edit Product Modal -->
                <div class="modal fade" id="editOrderModal_<?php echo $row['order_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <?php include "../assets/php/modals/editOrderModal.php"; ?>
<?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Order ID</th>
                <th>Email</th>
                <th>Address</th>
                <th>Items Ordered</th>
                <th>Subtotal</th>
                <th>Shipping Fee</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Ordered Time</th>
                <th>Completed Time</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
        </div>
    <!-------------------------- End Main -------------------------->
    </main>
  </div>
  <?php include "crudOrder.php" ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function () {
        $(document).on('click', '.delete_btn', function () {
            DeleteOrder();
        });
    });

    //Fetch cutomer
    $(document).ready(function () {
        // DataTable initialization
        const grid = $('#adminTable');

        // Make AJAX call to fetch data and initialize DataTable
        $.ajax({
            url: 'order_display.php',
            method: 'GET',
            dataType: 'html',
            success: function (html) {
                grid.html(html);

                // Initialize DataTables here
                const dataTable = $('#adminTable').DataTable({
                    paging: true,
                    searching: true,
                });

                // Checkbox event handling
                $('#selectAllCheckboxes').on('change', function () {
                    const isChecked = $(this).prop('checked');
                    $('input[name="order_checkbox[]"]').prop('checked', isChecked);

                    // Trigger DataTables to redraw
                    dataTable.rows().invalidate().draw();
                });

                $('input[name="order_checkbox[]"]').on('change', function () {
                    // Check if all checkboxes are checked
                    const allChecked = $('input[name="order_checkbox[]"]:checked').length === $('input[name="order_checkbox[]"]').length;
                    $('#selectAllCheckboxes').prop('checked', allChecked);

                    // Trigger DataTables to redraw
                    dataTable.rows().invalidate().draw();

                    // Log whether a specific checkbox is checked or unchecked
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