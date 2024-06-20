<?php include "../assets/connection.php" ?>
<form action = "order.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 1rem;">
        <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
            <h5 class="modal-title" id="exampleModalLabel">Update Order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="admin-modal-cmb">
                <div class="admin-modal-left">
                    <input type="hidden" name="order_id" value="<?php echo $row['order_id'] ?>"/>
                    <label>Order ID:</label>
                    <input name="orderID" id="orderID" type="text" value="<?php echo $row['order_id'];?>" readonly>
                    <label>Address:</label>
                    <input type="text" value="<?php echo $row['address'];?>" readonly>
                    <label>Subtotal:</label>
                    <input type="text" value="<?php echo $row['subtotal'];?>" readonly>
                    <label>Total Price:</label>
                    <input type="text" value="<?php echo $row['totalPrice'];?>" readonly>
                    <label>Date Ordered:</label>
                    <input type="text" name="ordered_at" value="<?php echo $row['ordered_at'];?>" readonly>
                    <label>Date Completed:</label>
                    <input type="text" value="<?php echo $row['completed_at'];?>" readonly>
                </div>
                <div class="admin-modal-right">
                    <label>Email:</label>
                    <input type="text" name="custEm" value="<?php echo $row['email'];?>" readonly>
                    <label>Status:</label>
                    <select name="orderStatus" id="orderStatus">
                        <?php
                            $sql = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = '$order_id'");
                            $getStatus = mysqli_fetch_array($sql);
                            
                            // Iterate over the options to create the select dropdown
                            $options = ["Completed", "Pending", "Cancelled"]; 
                            
                            foreach ($options as $option) {
                                $selected = ($row['status'] == $option) ? 'selected' : '';
                                echo '<option value="' . $option . '" ' . $selected  . '>' . $option . '</option>';
                            }
                            ?>
                    </select>
                    <label>Shipping Fee:</label>
                    <input type="text" value="<?php echo $row['shippingFee'];?>" readonly>
                    <label>Items Ordered:</label>
                    <textarea readonly style="height: fit-content; resize: none;" rows="7"><?php echo htmlspecialchars($row['cart_data']);?></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" name="editOrder" class="btn btn-success" id="editOrder">Update Order</button>
        </div>
    </div>
  </div>
</form>