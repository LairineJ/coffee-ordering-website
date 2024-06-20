<?php
session_start();
include '../assets/connection.php';

/*----------- Edit Location (LOGIN) ------------ */
   if(isset($_POST['locationBtn'])) {
    $custEmail = $_SESSION['custEmail'];
    $location = $_POST['locationInput'];

    $sql = "UPDATE customer SET address='$location' WHERE email = '$custEmail'";
    $sqlrun = mysqli_query($conn, $sql);
    if ($sqlrun) {
            ?>
            <script>Swal.fire({
    title: 'Successful!',
    text: 'Location Selected!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "index.php";
  });</script>
            <?php
        }
    }


/*----------- Edit Location (CHECKOUT) ------------ */
if(isset($_POST['checkoutBtn'])) {
    $custEmail = $_SESSION['custEmail'];
    $newLocation = $_POST['checkoutInput'];

    $sql = "UPDATE customer SET address='$newLocation' WHERE email = '$custEmail'";
    $sqlrun = mysqli_query($conn, $sql);
}
?>