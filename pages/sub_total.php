<?php
session_start();

include "../assets/connection.php";

if (isset($_SESSION['custEmail']) && isset($_GET['prod_id']) && isset($_GET['value'])) {
    $custEmail = $_SESSION['custEmail'];
    $prodId = $_GET['prod_id'];
    $value = $_GET['value'];

    $sql = "SELECT cart_data FROM cart WHERE email = '$custEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cartData = json_decode($row['cart_data'], true);

        // Initialize the subtotal to zero
        $subtotal = 0;

        // Update the quantity of the specific product and calculate the subtotal
        foreach ($cartData as &$item) {
            if ($item['prod_id'] == $prodId) {
                $item['quantity'] = $value;
            }
            $subtotal += $item['prod_price'] * $item['quantity'];
        }
        
        // Save the updated cart data back to the database
        $updatedCartData = json_encode($cartData);
        $updateSql = "UPDATE cart SET cart_data = '$updatedCartData' WHERE email = '$custEmail'";
        $conn->query($updateSql);

        // Echo the new subtotal
        echo $subtotal;
    }
}
?>
