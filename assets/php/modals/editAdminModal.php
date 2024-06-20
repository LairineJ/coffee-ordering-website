<?php include "../assets/connection.php" ?>
<form action = "admins.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Edit Administrator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class = "subModalInput">
        <input type="hidden" name="admin_id" value="<?php echo $row['admin_id'] ?>"/>
        <label>Name:</label>
        <input name="adName" id="adName" type="text" placeholder="Add Name" value="<?php echo $row['name'];?>" required>
        <label>Username:</label>
        <input name="adUsername" id="adUsername" type="text" placeholder="Add Username" value="<?php echo $row['username'];?>" required>
        <label>Password:</label>
        <input name="adPassword" id="adPassword" type="text" placeholder="Add Password" required>
        <label>Status:</label>
        <select name="adStatus" id="adStatus">
        <?php
        include "../assets/connection.php";
        $sql = mysqli_query($conn, "SELECT DISTINCT status FROM admin");
        while ($adStatus = mysqli_fetch_array($sql)) {
            $selected = ($adStatus['status'] == $row['status']) ? 'selected' : '';
            echo '<option ' . $selected  . '>' . $adStatus['status'] . '</option>';
        }
        ?>
        </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="editAdmin" class="btn btn-success" id="editAdmin">Edit Admin</button>
      </div>
    </div>
  </div>
</form>