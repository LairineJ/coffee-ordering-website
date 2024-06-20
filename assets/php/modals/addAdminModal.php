<?php include "../assets/connection.php" ?>
<form action = "admins.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title" id="exampleModalLabel">Add Administrator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class = "subModalInput">
        <label>Name:</label>
        <input name="adName" id="adName" type="text" placeholder="Enter Name" required>
        <label>Username:</label>
        <input name="adUsername" id="adUsername" type="text" placeholder="Enter Username" required>
        <label>Password:</label>
        <input name="adPassword" id="adPassword" type="password" placeholder="Enter Password" required>
        <label>Status:</label>
        <select name="adStatus" id="adStatus">
            <?php
            include "../assets/connection.php";
            $sql = mysqli_query($conn, "SELECT DISTINCT status FROM admin");
            while ($aStatus = mysqli_fetch_array($sql)) {
                echo '<option>' . $aStatus['status'] . '</option>';
            }
            ?>
        </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addAdmin" class="btn btn-success" id="addAdmin">Add Admin</button>
      </div>
    </div>
  </div>
</form>