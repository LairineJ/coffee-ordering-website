<thead>
            <tr>
                <th><input type="checkbox" id="selectAllCheckboxes" value="Check All" onClick='$(":checkbox").attr("checked",true);'></th>
                <th>Type</th>
                <th>Category</th>
                <th>Visibility</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            include '../assets/connection.php';
            $sql="select * from sub_categ";
            $result=mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr data-product-id="<?php echo $row['s_categ_id']; ?>">
                    <td style="align-items: center; vertical-align: middle">   
                       <input type="checkbox" name="sCateg_checkbox[]" value="<?php echo $row['s_categ_id']; ?>">
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <?php echo $row['m_categ_name'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle;"><input type="hidden" name="initialMCateg" value="<?php echo $row['s_categ_name'];?>">
                        <?php echo $row['s_categ_name'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <?php echo $row['s_categ_visibility'];?>
                    </td>
                    <td style="align-items: center; vertical-align: middle;">
                        <?php echo '<img src="data:image/png;base64,' .base64_encode($row['s_categ_img']) . '" style="width:60px; height: 60px;" />'; ?>
                    </td>
                    <td style="align-items: center; vertical-align: middle; width: 1px; white-space: nowrap;">
                        <button name="edit_btn" style="background: transparent; border: none;"  class="edit_btn" data-bs-toggle="modal" data-bs-target="#EditSubCategModal_<?php echo $row['s_categ_id']?>"><span class="material-icons-outlined" style="font-size: 2rem; color: #ffc107; cursor: pointer;">edit</span></button>
                    </td>
                </tr>
                <!-- Edit Product Modal -->
                <div class="modal fade" id="EditSubCategModal_<?php echo $row['s_categ_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <?php include "../assets/php/modals/editSubCategoryModal.php"; ?>
            </div>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
                <th></th>
                <th>Type</th>
                <th>Category</th>
                <th>Visibility</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </tfoot>