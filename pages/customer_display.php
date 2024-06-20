<thead>
            <tr>
                <th><input type="checkbox" id="selectAllCheckboxes" value="Check All" onClick='$(":checkbox").attr("checked",true);'></th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        <?php
            include '../assets/connection.php';
            $sql="select * from customer";
            $result=mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr data-product-id="<?php echo $row['customer_id']; ?>">
                    <td style="align-items: center; vertical-align: middle">   
                        <input type="checkbox" name="cust_checkbox[]" value="<?php echo $row['customer_id']; ?>">
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['f_name'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['l_name'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['address'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['contact'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle">
                        <?php echo $row['email'];?>
                    </td>
                </tr>
            
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
                <th></th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
            </tr>
        </tfoot>