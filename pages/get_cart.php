<?php
session_start();

// Check if the cart session variable is set
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $value) {
        // Display the cart item HTML structure
        echo "<div class='itemCard'>";
        
        // Add a condition to check if controls should be included
        if (!isset($_GET['exclude_controls']) || $_GET['exclude_controls'] == 'false') {
            echo "
                <form method='post' style='display: flex; width: 100%; hieght: 100%;'>
                    <input type='hidden' name='prod_id' value='{$value['prod_id']}'>
                    <button type='submit' name='remove'><i class='fas fa-times'></i></button>
                    <div class='cart-prodname' style='width: 85%;'>{$value['prod_name']}
                        <div class='Cardquanti'>
                            P{$value['prod_price']}
                        </div>
                    </div>
                    <div class='quantity-cart' style='hieght: 100%; width: 15%; backround-color: blue; display: flex; justify-content: center; align-items: center;'>
                        <input type='number' class='count' name='quantity' value='{$value['quantity']}' min='1' oninput='updateResult({$value['prod_id']})' id='numberInput_{$value['prod_id']}' style='height: fit-content; border: 2px solid; border-radius: 3px; width: 100%;'>
                    </div>
                </form>";
        } else {
            // If exclude_controls is true, only display product name and price
            echo "
                <div class='cart-prodname'>{$value['prod_name']}</div>
                <div class='Cardquanti'>
                    P{$value['prod_price']}
                </div>";
        }

        echo "</div>";
    }
} else {
    // Display a message if the cart is empty
    echo "Your cart is empty.";
}
?>

<script>
function updateResult(prodId) {
    console.log('updateResult called with prodId:', prodId);
    // Construct the dynamic ID
    var dynamicId = 'numberInput_' + prodId;

    // Do something with the value...
    var inputElement = document.getElementById(dynamicId);

    // Now you can access the value of the input element
    var inputValue = inputElement.value;

    // Do something with the value...
    console.log('Input value:', inputValue);

    // Make an AJAX request to a PHP script to update the specific item's quantity
    var xhr = new XMLHttpRequest();
   xhr.onreadystatechange = function() {
    console.log('Ready state:', xhr.readyState, 'Status:', xhr.status);

    if (xhr.readyState == 4) {
        console.log('Response from PHP script:', xhr.responseText);

        if (xhr.status == 200) {
            var responseData = JSON.parse(xhr.responseText);
            console.log('Parsed response data:', responseData);

            // Update the result elements with the formatted response
            document.getElementById('subDisplay').innerHTML = '₱' + responseData.subtotal;
            document.getElementById('shipFDisplay').innerHTML = '₱' + responseData.shippingFee;
            document.getElementById('totPriDisplay').innerHTML = '₱' + responseData.totalPrice;

            document.getElementById('subtotalDisplayModal').innerHTML = '₱' + responseData.subtotal;
            document.getElementById('shippingFeeDisplayModal').innerHTML = '₱' + responseData.shippingFee;
            document.getElementById('totalPriceDisplayModal').innerHTML = '₱' + responseData.totalPrice;
        }
    }
};

    // Use encodeURIComponent to properly handle special characters in the URL
    var encodedValue = encodeURIComponent(inputValue);

    // Update the URL to include the encoded value and the product ID
    xhr.open('GET', './pages/get_cart_info.php?prod_id=' + prodId + '&value=' + encodedValue, true);
    xhr.send();
}

</script>

