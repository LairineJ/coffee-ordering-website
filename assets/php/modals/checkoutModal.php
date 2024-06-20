<?php include "../assets/connection.php"; 
session_start();

$custEmail = $_SESSION['custEmail'];

$sql = "select * from customer where email = '$custEmail'";
$sqlrun = mysqli_query($conn, $sql);
if($sqlrun){
    $result = mysqli_fetch_assoc($sqlrun);
    $prevLoc = $result['address'];
}
?>
<form action = "index.php" method="POST" enctype="multipart/form-data">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 1rem; padding: 1.4rem;" >
            <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem; border-bottom: 0;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 50%; border: 1px solid #000; font-size: .7rem;"></button>
            </div>
            <div class="modal-body">
		            <div class="checkout_body">
			              <div class="userInfo">
				                <div class="checkout-logo">
                            <img src = "../assets/images/icon/logo.png">
                            <span>ORDER INFO</span>
                        </div>
                        <div class = "info">
                            <div class="name">
                                <span class="fa-solid fa-user"></span>
                                <input name="name" id="name" type="text" value="<?php echo $result['f_name'] . ' ' . $result['l_name']; ?>" readonly required>
                            </div>
                            <div class="contact">
                                <span class="fa-solid fa-phone"></span>
                                <input name="contact" id="contact" type="number" value="<?php echo $result['contact'];?>" readonly required>
                            </div>
                            <!-- Input for location search -->
                            <div class="locationSearch">
                                <input name="locationSearch" type="text" id="checkoutInput" value="<?php echo $prevLoc; ?>">
                                <button onclick="searchLocation()" id="setLocationBtn" type="button" name="checkoutBtn" style="background-color: #562B08; color: #fff; padding: 10px 5px 10px 5px; font-size: .8rem; border-radius: 5px; border: none;">Set Location</button>
                            </div>
                            <!-- Map container inside modal body -->
                            <div id="mapContainer" style="height: 300px;"></div>
                        </div>
			            </div>
                    <div class="cartInfo h-100">
                        <div class="cartItems h-100" id="checkout-conn">
                    
                        </div>
                        <div class="sub-total-con" id="cart-details">
                            <div class="sub-right">
                                <h6>Sub Total:</h6>
                                <h6>Delivery Fee:</h6>
                                <h6>Total Price:</h6>
                            </div>
                            <div class="sub-left" id="cartInfoContainer">
                                <div id="subtotalDisplayModal">₱0.00</div>
                                <div id="shippingFeeDisplayModal">₱0.00</div>
                                <div id="totalPriceDisplayModal">₱0.00</div>
                            </div>
                            <script>
                                $(document).ready(function () {
                                    function updateCartInfo() {
                                        $.ajax({
                                            url: '../pages/get_cart_info.php',
                                            method: 'POST',
                                            dataType: 'json',
                                            success: function (response) {
                                                // Update the HTML in the modal with the received information
                                                $('#subtotalDisplayModal').html('₱' + response.subtotal);
                                                $('#shippingFeeDisplayModal').html('₱' + response.shippingFee);
                                                $('#totalPriceDisplayModal').html('₱' + response.totalPrice);
                                            },
                                            error: function () {
                                                console.error('Failed to update cart information.');
                                            }
                                        });
                                    }
                                    updateCartInfo();
                                });
                            </script>                     
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="checkout" class="btn btn-success" id="checkout" disabled>Checkout</button>
            </div>
        </div>
    </div>
</form>



<style>
  .modal-content{
    position: absolute;
  }

  .checkout_body{
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto;
    grid-template-areas: "userInfo cartInfo";
    position: relative;
    height: 100%;
  }

  .checkout-logo img{
    height: 90px; 
    width: 90px; 
  }

  .checkout-logo {
    display: flex;
    align-items: center;
  }

  .checkout-logo span {
    font-size: 3rem;
    color: #562B08;
    font-family: 'Chela One', cursive;
  }

  .info {
	  padding: 1.5rem;
  }
  
  .cartItems {
    background-color: #FFF8EA;
    border: 1px solid #DDD;
    border-radius: 3%;
    overflow-y: auto;
    width: 100%;
    height: 100%;
    position: relative;
    padding: 1rem;
    margin-bottom: 1rem;
  }

  .itemCard{
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    background-color: #fff;
    margin-top: 1rem;
    width: 100%;
    height: 100px;
    position: relative;
    padding: 1rem;
    display: flex;
    align-items: center;
  }

  .CardPrice{
    width: 10%;
    font-size: 1.2rem;
    font-weight: normal;
  }

  .Cardquanti{
    font-size: .9rem;
    color: #808080;
  }

  .Cardname{
    width: 90%;
    font-size: 1.2rem;
    font-weight: normal;
  }

  .userInfo {
    grid-area: userInfo;
    display: flex;
    flex-direction: column;
  }

  .cartInfo {
    grid-area: cartInfo;
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    position: absolute;
  }

  .userInfo input {
    font-family: 'Poppins';
    border: none;
    border-radius: 0;
    outline: none;
    background-color: rgb(244, 244, 244);
    font-size: .8rem;
    color: #000;
    padding: 10px 5px 10px 5px;
    width: 100%;
    height: 100%;
}

  .name,
  .contact,
  .locationSearch,
  .mapContainer,
  .address{
    display: flex;
    align-items: center;
	justify-content: center;
    margin-bottom: 10px;
    border-bottom: 1px solid #c2c4c3;
    transition: .5s ease;
  }

  .name span,
  .contact span,
  .address span{
      margin-right: 10px;
      font-size: .8rem;
  }

  .sub-total-con {
    display: flex;
    justify-content: space-between;
}
   .sub-right {
    width: 45%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

	.sub-left {
		width: 45%;
		text-align: right;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
   #checkout{
    outline: none;
    border: none;
    padding: 0 30px 0 30px;
    height: 50px;
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

  #checkout:hover{
    background-color: #6F4E37;
  }
</style>