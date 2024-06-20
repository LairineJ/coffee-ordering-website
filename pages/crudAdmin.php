<?php
    include "../assets/connection.php";

/*----------- Add Admin ----------------- */
    if(isset($_POST['addAdmin'])){
        $aUsername = $_POST['adUsername'];
        $aPassword = $_POST['adPassword'];
        $aName = $_POST['adName'];
        $aStatus = $_POST['adStatus'];
        
        $sql = "INSERT INTO admin(username, password, name, status) VALUES('$aUsername', '$aPassword', '$aName', '$aStatus')";
        $sqlrun = mysqli_query($conn, $sql);
        if($sqlrun){
            ?>
            <script>
            AddAdmin();
        </script>
            <?php
        }
        else {
            ?>
            <script>
                ErrorAlert();
            </script>
            <?php
        }
    };

    /* ---------- Delete Admin -----------*/
    $response = [];
    if (isset($_POST['delete_btn'])) {
        $admin_ids = $_POST['admin_ids'];

        foreach ($admin_ids as $admin_id) {
            $admin_id = mysqli_real_escape_string($conn, $admin_id);

            $delete_query = "DELETE FROM admin WHERE admin_id= '$admin_id'";
            $delete_run = mysqli_query($conn, $delete_query);

            if ($delete_run) {
                $response[] = [
                    'admin_id' => $admin_id,
                    'status' => 'success'
                ];
            } else {
                $response[] = [
                    'admin_id' => $admin_id,
                    'status' => 'error',
                    'message' => mysqli_error($conn)
                ];
            }
        }
    }
    echo json_encode($response);


   /*----------- Edit Admin ------------ */
   if (isset($_POST['editAdmin'])) {
    $admin_id = $_POST['admin_id'];
    $adName = $_POST['adName'];
    $adPassword = $_POST['adPassword'];
    $adUsername = $_POST['adUsername'];
    $adStatus = $_POST['adStatus'];

    $sql = "UPDATE admin set name = '$adName', username = '$adUsername', password = '$adPassword', status = '$adStatus' where admin_id = '$admin_id'";
    $sqlrun = mysqli_query($conn, $sql);
    if($sqlrun){
        ?>
        <script>
            EditAdmin();
        </script>
        <?php
    }
    else {
        ?>
        <script>
            ErrorAlert();
        </script>
        <?php
    }

};
  ?>