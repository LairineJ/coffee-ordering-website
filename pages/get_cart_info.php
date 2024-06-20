<?php
session_start();

include "../assets/connection.php";

if (isset($_SESSION['custEmail'])) {
    $custEmail = $_SESSION['custEmail'];
    $sql = "SELECT cart_data FROM cart WHERE email = '$custEmail'";
    $prodId = $_GET['prod_id'];
    $value = $_GET['value'];
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cartData = json_decode($row['cart_data'], true);
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

        if (count($cartData) > 0) {
            $subtotal = calculateSubtotal($cartData);
            $shippingFee = isset($_COOKIE['shippingFee']) ? $_COOKIE['shippingFee'] : 0.00;
            $totalPrice = $subtotal + $shippingFee;

            $response = array(
                'subtotal' => number_format($subtotal, 2),
                'shippingFee' => number_format($shippingFee, 2),
                'totalPrice' => number_format($totalPrice, 2),
            );

            echo json_encode($response);
            $_SESSION['subtotal'] = $response['subtotal'];
            $_SESSION['shippingFee'] = $response['shippingFee'];
            $_SESSION['totalPrice'] = $response['totalPrice'];
        } else {
            $subtotal = calculateSubtotal($cartData);
            $shippingFee = isset($_COOKIE['shippingFee']) ? $_COOKIE['shippingFee'] : 0.00;
            $totalPrice = $subtotal + $shippingFee;

            $response = array(
                'subtotal' => number_format($subtotal, 2),
                'shippingFee' => number_format($shippingFee, 2),
                'totalPrice' => number_format($totalPrice, 2),
            );

            echo json_encode($response);
            $_SESSION['subtotal'] = $response['subtotal'];
            $_SESSION['shippingFee'] = $response['shippingFee'];
            $_SESSION['totalPrice'] = $response['totalPrice'];
        }
    } else {
            $subtotal = calculateSubtotal($cartData);
            $shippingFee = isset($_COOKIE['shippingFee']) ? $_COOKIE['shippingFee'] : 0.00;
            $totalPrice = $subtotal + $shippingFee;

            $response = array(
                'subtotal' => number_format($subtotal, 2),
                'shippingFee' => number_format($shippingFee, 2),
                'totalPrice' => number_format($totalPrice, 2),
            );

            echo json_encode($response);
            $_SESSION['subtotal'] = $response['subtotal'];
            $_SESSION['shippingFee'] = $response['shippingFee'];
            $_SESSION['totalPrice'] = $response['totalPrice'];
    }
} else {
    echo json_encode(array('subtotal' => '0.00', 'shippingFee' => '0.00', 'totalPrice' => '0.00'));
}

function calculateSubtotal($cart) {
    $subtotal = 0;

    foreach ($cart as $item) {
        $subtotal += $item['prod_price'] * $item['quantity'];
    }

    return $subtotal;
}

?>
