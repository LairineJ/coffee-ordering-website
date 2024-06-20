<thead>
            <tr>
                <th><input type="checkbox" id="selectAllCheckboxes" value="Check All" onClick='$(":checkbox").attr("checked",true);'></th>
                <th>Order ID</th>
                <th>Email</th>
                <th>Address</th>
                <th>Items Ordered</th>
                <th>Subtotal</th>
                <th>Shipping Fee</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Ordered Time</th>
                <th>Completed Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            include '../assets/connection.php';
            $sql="select * from orders";
            $result=mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr data-product-id="<?php echo $row['order_id']; ?>">
                    <td style="align-items: center; vertical-align: middle">   
                        <input type="checkbox" name="order_checkbox[]" value="<?php echo $row['order_id']; ?>">
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['order_id'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['email'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['address'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['cart_data'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['subtotal'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['shippingFee'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['totalPrice'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['status'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['ordered_at'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['completed_at'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <button name="edit_btn" style="background: transparent; border: none;"  class="edit_btn" data-bs-toggle="modal" data-bs-target="#editOrderModal_<?php echo $row['order_id']?>"><span class="material-icons-outlined" style="font-size: 2rem; color: #ffc107; cursor: pointer;">edit</span></button>
                    </td>
                </tr>
            
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
                <th></th>
                <th>Order ID</th>
                <th>Email</th>
                <th>Address</th>
                <th>Items Ordered</th>
                <th>Subtotal</th>
                <th>Shipping Fee</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Ordered Time</th>
                <th>Completed Time</th>
                <th>Action</th>
            </tr>
        </tfoot>