<?php
 include "../assets/connection.php";
 
    /* ---------- Delete Customer -----------*/
    

if (isset($_POST['delete_btn'])) {
    $cust_ids = $_POST['cust_ids'];
    $response = []; 

    foreach ($cust_ids as $customer_id) {
        $customer_id = mysqli_real_escape_string($conn, $customer_id);

        $delete_query = "DELETE FROM customer WHERE customer_id= '$customer_id'";
        $delete_run = mysqli_query($conn, $delete_query);

        if ($delete_run) {
            $response[] = [
                'customer_id' => $customer_id,
                'status' => 'success'
            ];
        } else {
            $response[] = [
                'customer_id' => $customer_id,
                'status' => 'error',
                'message' => mysqli_error($conn)
            ];
        }
    }
}
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode($response);
    }
?>