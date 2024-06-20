<?php
session_start();
include '../assets/connection.php';

/**** INSERT ORDER ****/
if (isset($_POST['checkout'])) {
    $custEmail = $_SESSION['custEmail'];
    $address = $_POST['locationSearch'];
    $cartData = json_encode($_SESSION['cart']);
    $subtotal = $_SESSION['subtotal'];
    $shippingFee = $_SESSION['shippingFee'];
    $totalPrice = $_SESSION['totalPrice'];
    $status = 'Pending';

    if (strpos($subtotal, '.') === false) {
        $subtotal .= '.00'; 
        $sql = "INSERT INTO orders(email, address, cart_data, subtotal, shippingFee, totalPrice, status) VALUES ('$custEmail', '$address', '$cartData', '$subtotal', '$shippingFee', '$totalPrice', '$status')";
        $sqlrun = mysqli_query($conn, $sql);

        $sql2 = "INSERT INTO history(email, address, cart_data, subtotal, shippingFee, totalPrice, status) VALUES ('$custEmail', '$address', '$cartData', '$subtotal', '$shippingFee', '$totalPrice', '$status')";
        $sqlrun2 = mysqli_query($conn, $sql2);

        echo '<script>console.log("Debugging Order: SQL query =", ' . json_encode($sql) . ');</script>';
        echo '<script>console.log("Debugging History: SQL query =", ' . json_encode($sql2) . ');</script>';
        echo '<script>console.log("Debugging: SQL query =", ' . json_encode($response) . ');</script>';
        
        if ($sqlrun) {
            ?>
            <script>
            var shippingFee = 0.00;
            document.cookie = "shippingFee=" + shippingFee.toFixed(2);
            </script>
            
            <?php
            $_SESSION['cart'] = [];
            $sqlDelete = "DELETE FROM cart WHERE email = '$custEmail'";
            $conn->query($sqlDelete);
        
            unset($_SESSION['subtotal']);
            unset($_SESSION['totalPrice']);

            ?>
            <script>
                console.log("Order inserted successfully.");
                AddOrder();
            </script>
            <?php
        } else {
            ?>
            <script>
                console.error("Error inserting:", <?php echo json_encode(mysqli_error($conn)); ?>);
                ErrOrder();
            </script>
            <?php
        }
    }
    else{
        $sql = "INSERT INTO orders(email, address, cart_data, subtotal, shippingFee, totalPrice, status) VALUES ('$custEmail', '$address', '$cartData', '$subtotal', '$shippingFee', '$totalPrice', '$status')";
        $sqlrun = mysqli_query($conn, $sql);

        $sql2 = "INSERT INTO history(email, address, cart_data, subtotal, shippingFee, totalPrice, status) VALUES ('$custEmail', '$address', '$cartData', '$subtotal', '$shippingFee', '$totalPrice', '$status')";
        $sqlrun2 = mysqli_query($conn, $sql2);

        echo '<script>console.log("Debugging Order: SQL query =", ' . json_encode($sql) . ');</script>';
        echo '<script>console.log("Debugging History: SQL query =", ' . json_encode($sql2) . ');</script>';
        echo '<script>console.log("Debugging: SQL query =", ' . json_encode($response) . ');</script>';
        
        if ($sqlrun) {
            ?>
            <script>
            var shippingFee = 0.00;
            document.cookie = "shippingFee=" + shippingFee.toFixed(2);
            </script>
            
            <?php
            $_SESSION['cart'] = [];
            $sqlDelete = "DELETE FROM cart WHERE email = '$custEmail'";
            $conn->query($sqlDelete);
        
            unset($_SESSION['subtotal']);
            unset($_SESSION['totalPrice']);

            ?>
            <script>
                console.log("Order inserted successfully.");
                AddOrder();
            </script>
            <?php
        } else {
            ?>
            <script>
                console.error("Error inserting:", <?php echo json_encode(mysqli_error($conn)); ?>);
                ErrOrder();
            </script>
            <?php
        }
    }
}


/**** ORDER AGAIN ****/
if (isset($_POST['orderAgain'])) {
    $custEmail = $_SESSION['custEmail'];
    $history_id = $_POST['history_id'];

    $sql = "SELECT * FROM history WHERE history_id='$history_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $address = $row['address'];
    $cartData = $row['cart_data'];
    $sub = $row['subtotal'];
    $shipping = $row['shippingFee'];
    $totalP = $row['totalPrice'];
    $status = 'Pending';

    $sql = "INSERT INTO orders(email, address, cart_data, subtotal, shippingFee, totalPrice, status) VALUES ('$custEmail', '$address', '$cartData', '$sub', '$shipping', '$totalP', '$status')";
    echo '<script>console.log("Debugging: SQL query =", ' . json_encode($sql) . ');</script>';
    $sqlrun = mysqli_query($conn, $sql);

    $sql2 = "INSERT INTO history(email, address, cart_data, subtotal, shippingFee, totalPrice, status) VALUES ('$custEmail', '$address', '$cartData', '$sub', '$shipping', '$totalP', '$status')";
    echo '<script>console.log("Debugging: SQL query =", ' . json_encode($sql) . ');</script>';
    $sqlrun2 = mysqli_query($conn, $sql2);

    if ($sqlrun) {
        ?><script>
            console.log("Ordered successfully.");
            AddOrder();
        </script>
        <?php
    } else {
        ?>
        <script>
            console.error("Error inserting order:", <?php echo json_encode(mysqli_error($conn)); ?>);
            ErrOrder();
        </script>
        <?php
    }
}



/********** DELETE ORDER **********/
    if (isset($_POST['delete_btn'])) {
        $order_ids = $_POST['order_ids'];
        $response = [];

        foreach ($order_ids as $order_id) {
            $order_id = mysqli_real_escape_string($conn, $order_id);

            $delete_query = "DELETE FROM orders WHERE order_id= '$order_id'";
            $delete_run = mysqli_query($conn, $delete_query);

            if ($delete_run) {
                $response[] = [
                    'order_id' => $order_id,
                    'status' => 'success'
                ];
            } else {
                $response[] = [
                    'order_id' => $order_id,
                    'status' => 'error',
                    'message' => mysqli_error($conn)
                ];
            }
        }
    }
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode($response);
    }


/*----------- EDIT ORDER ------------ */
   if (isset($_POST['editOrder'])) {
        $order_id = $_POST['order_id'];
        $orderStatus = $_POST['orderStatus'];
        $ordered_at = $_POST['ordered_at'];
        $custEm = $_POST['custEm'];

        $sql = "UPDATE orders set status = '$orderStatus', completed_at = NOW() where order_id = '$order_id'";
        $sqlrun = mysqli_query($conn, $sql);

        $sql2 = "UPDATE history set status = '$orderStatus', completed_at = NOW() where email = '$custEm' AND ordered_at = '$ordered_at'";
        $sqlrun2 = mysqli_query($conn, $sql2);

        if($sqlrun){
            ?>
            <script>
                EditOrder();
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
?>
