<?php
session_start();

if (isset($_POST['add_cart'])) {
    $prod_id = $_POST['prod_id'];
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'])) {
        $session_array_id = array_column($_SESSION['cart'], "prod_id");

        if (!in_array($prod_id, $session_array_id)) {
            $_SESSION['cart'][] = array(
                "prod_id" => $prod_id,
                "prod_name" => $prod_name,
                "prod_price" => $prod_price,
                "quantity" => $quantity
            );
        } else {
            // If the product is already in the cart, find its index
            $index = array_search($prod_id, $session_array_id);

            // Increase the quantity of the existing product in the cart
            $_SESSION['cart'][$index]['quantity'] += $quantity;
        }

        // Calculate and store the total price in the session
        $totalPrice = calculateTotalPrice($_SESSION['cart']);
        $_SESSION['totalPrice'] = $totalPrice;

        if (isset($_SESSION['custEmail'])) {
            $custEmail = $_SESSION['custEmail'];
            $cart_data = json_encode($_SESSION['cart']);

            // Check if the user already has a cart record in the database
            $sql = "SELECT * FROM cart WHERE email = '$custEmail'";
                        $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Update the existing record
                $sql = "UPDATE cart SET cart_data = '$cart_data' WHERE email = '$custEmail'";
            } else {
                // Insert a new record
                $sql = "INSERT INTO cart (email, cart_data) VALUES ('$custEmail', '$cart_data')";
            }

            $conn->query($sql);
        }
    } else {
        // If the cart is empty, create a new session array
        $_SESSION['cart'] = array(
            array(
                "prod_id" => $prod_id,
                "prod_name" => $prod_name,
                "prod_price" => $prod_price,
                "quantity" => $quantity
            )
        );

        // Calculate and store the total price in the session
        $totalPrice = calculateTotalPrice($_SESSION['cart']);
        $_SESSION['totalPrice'] = $totalPrice;
    }
}

// Function to calculate the total price based on the cart items
function calculateTotalPrice($cart) {
    $totalPrice = 0;

    foreach ($cart as $item) {
        $totalPrice += $item['prod_price'] * $item['quantity'];
    }

    return $totalPrice;
}
?>

