<?php
session_start();
include "../assets/connection.php";
?>

<!-- Bootstrap modal structure -->
<form action="index.php" method="POST">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 1rem;">
            <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem; border-bottom: 0;">
            <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                <button type="button" class="btn-close closeHistory" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 50%; border: 1px solid #000; font-size: .7rem;"></button>
            </div>
            <div class="modal-body">
                <div class="checkout_body">
                <?php                    
                    $historyId = $history_id;
                    $sql = "SELECT * FROM history WHERE history_id = '$historyId'";
                    $result = mysqli_query($conn, $sql);
                    $hist = mysqli_fetch_assoc($result);
                ?>
                    <div class="userInfo">
                        <div class = "info">
                            <input type="hidden" name="history_id" value="<?php echo $historyId ?>">
                            <div class="name">
                                <span>Order Time:</span>
                                <input type="text" id="infoH" value="<?php echo $hist['ordered_at']; ?>" readonly>
                            </div>
                            <div class="name">
                                <span>Complete Time:</span>
                                <input type="text" id="infoH" value="<?php echo $hist['completed_at']; ?>" readonly>
                            </div>
                            <div class="name">
                                <span>Address:</span>
                                <input type="text" id="infoH" value="<?php echo $hist['address']; ?>" readonly>
                            </div>
                            <div class="name">
                                <span>Status:</span>
                                <input type="text" id="infoH" value="<?php echo $hist['status']; ?>" readonly>
                            </div>
                            <div class="sub-total-con" id="cart-details" style="margin-top: 1rem;">
                                <div class="sub-right">
                                    <h6 id="histoH">Sub Total:</h6>
                                    <h6 id="histoH">Delivery Fee:</h6>
                                    <h6 id="histoH">Total Price:</h6>
                                </div>
                                <div class="sub-left" id="cartInfoContainer">
                                    <div id="histoH">₱<?php echo $hist['subtotal']; ?></div>
                                    <div id="histoH">₱<?php echo $hist['shippingFee']; ?></div>
                                    <div id="histoH">₱<?php echo $hist['totalPrice']; ?></div>
                                </div>              
                            </div>
                        </div>
                    </div>

                    <div class="cartInfo">
                            <div class="cartItems h-100">
                                <?php
                                $cartData = json_decode($hist['cart_data'], true);
                                foreach ($cartData as $product) {
                                    echo "<div class='itemCard' style='height: 25%;'>
                                            <div class='cart-prodname' id='histoH' style='width: 90%;'>{$product['prod_name']}
                                                <div class='Cardquanti' id='histoH'>
                                                    {$product['quantity']}x
                                                </div>
                                            </div>
                                            <div class='quantity-cart' id='histoH'>
                                                {$product['prod_price']}
                                            </div>
                                        </div>";
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="orderAgain" class="btn btn-success" id="order">Order Again</button>
                </div>
            </div>
        </div>
</form>

<style>
    #histoH{
        font-size: .8rem;
    }

    #order{
    outline: none;
    border: none;
    padding: 0 30px 0 30px;
    height: 45px;
    border-radius: 30px;
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    text-align: center;
    background-color: #562B08;
    box-shadow: 1px 1px 5px #000,
                -1px -1px 5px #fff; 
    transition: .5s;
  }

  #order:hover{
    background-color: #6F4E37;
  }
</style>
<script src="../assets/js/cart.js"></script>