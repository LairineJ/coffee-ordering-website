<thead>
            <tr>
                <th><input type="checkbox" id="selectAllCheckboxes" value="Check All" onClick='$(":checkbox").attr("checked",true);'></th>
                <th>Name</th>
                <th>Username</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            include '../assets/connection.php';
            $sql="select * from admin WHERE username != 'superAdmin'";
            $result=mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr data-product-id="<?php echo $row['admin_id']; ?>">
                    <td style="align-items: center; vertical-align: middle">   
                       <input type="checkbox" name="admin_checkbox[]" value="<?php echo $row['admin_id']; ?>">
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <?php echo $row['name'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <?php echo $row['username'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle;"><input type="hidden" name="initialMCateg" value="<?php echo $row['s_categ_name'];?>">
                        <?php echo $row['status'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle; width: 1px; white-space: nowrap;">
                        <button name="edit_btn" style="background: transparent; border: none;"  class="edit_btn" data-bs-toggle="modal" data-bs-target="#editAdminModal_<?php echo $row['admin_id']?>"><span class="material-icons-outlined" style="font-size: 2rem; color: #ffc107; cursor: pointer;">edit</span></button>
                    </td>
                </tr>
                <!-- Edit Product Modal -->
                <div class="modal fade" id="editAdminModal_<?php echo $row['s_categ_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <?php include "../assets/php/modals/editAdminModal.php"; ?>
            </div>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
                <th></th>
                <th>Name</th>
                <th>Username</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>