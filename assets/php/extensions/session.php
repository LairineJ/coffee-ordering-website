<?php
session_start();
include("../assets/connection.php");

// Handle login (USER)
if (isset($_POST['loginBtn'])) {
    $custEmail = $_POST['custEmail'];
    $custPass = $_POST['custPass'];

    $sql = "SELECT * FROM customer WHERE email = '$custEmail' AND password = '$custPass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['custEmail'] = $custEmail;
        ?>
        <script>loginCustomer();</script>
        <?php
    } else {
        ?>
        <script>ErrorLogin();</script>
        <?php
    }
}


// Handle login (ADMIN)
if (isset($_POST['adminLogin'])) {
    $adminUsername = $_POST['email'];
    $adminPass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$adminUsername' AND password = '$adminPass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        if($adminUsername == 'superAdmin'){
            $_SESSION['superAdmin'] = $adminUsername;
            ?>
                <script>loginAdmin();</script>
            <?php
        }
        else{
            $sql = "SELECT * FROM admin WHERE username = '$adminUsername' AND status = 'Active'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['admin'] = $adminUsername;
                 ?>
                    <script>loginAdmin();</script>
                <?php
            }
            else{
                $sql = "SELECT * FROM admin WHERE username = '$adminUsername' AND status = 'Locked'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) == 1) {
                    ?>
                        <script>lockedAdmin();</script>
                    <?php
                }
            }
        }
    } else {
        ?>
        <script>ErrLoginAdmin();</script>
        <?php
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    
    // Logout action
    session_destroy();

    $_SESSION['shippingFee'] = 0;
    echo json_encode(['success' => true, 'action' => 'logout']);
    exit;
}
?>