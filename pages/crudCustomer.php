<?php 
    include "../assets/connection.php";
    session_start();
    $custEmail = $_SESSION['custEmail'];

    /*----------- Add Customer ------------ */
    if(isset($_POST['signup'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = "";
        $emailAdd = $_POST['emailAdd'];
        $contactNo = $_POST['contactNo'];
        $pass = $_POST['pass'];
        $cpassword = $_POST['cpassword'];

        if($pass == $cpassword){
        $sql = "insert into customer (f_name, l_name, address, contact, email, password)
        values ('$fname', '$lname', '$address', '$contactNo', '$emailAdd', '$pass')";
        $sqlrun = mysqli_query($conn, $sql);
        if($sqlrun){
                ?>
              <script>
                AddCustomer();
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
        }
        else {
            ?>
              <script>
                  ErrorAlert();
              </script>
              <?php
        }
    }


     /*----------- Edit Customer [Customer Side] ----------------- */
    if(isset($_POST['saveInfo'])){
        $fname = $_POST['cust_fname'];
        $lname = $_POST['cust_lname'];
        $emailAdd = $_POST['cust_email'];
        $contactNo = $_POST['cust_contact'];
        $oldPass = $_POST['cust_oldPassword'];
        $newPass = $_POST['cust_newPassword'];

        $getOldPassword = "SELECT * FROM customer WHERE email = '$custEmail'";
        $result = mysqli_query($conn, $getOldPassword);
        $row = mysqli_fetch_assoc($result);
        
        $oldPassword = $row['password'];

        if (!empty($oldPass) && !empty($newPass)){
            if($oldPassword == $oldPass){
              $sql = "UPDATE customer SET f_name = '$fname', l_name='$lname', contact='$contactNo', email='$emailAdd', password='$newPass' WHERE email = '$custEmail'";
              $sqlrun = mysqli_query($conn, $sql);
              if($sqlrun){
                      ?>
                    <script>
                      EditCustomerInfo();
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
              }
            else {
                ?>
                  <script>
                      ErrorPassMismatch()
                  </script>
                  <?php
            }
        }else if(empty($oldPass) && empty($newPass)){
          $sql = "UPDATE customer SET f_name = '$fname', l_name='$lname', contact='$contactNo', email='$emailAdd' WHERE email = '$custEmail'";
              $sqlrun = mysqli_query($conn, $sql);
              if($sqlrun){
                      ?>
                    <script>
                      EditCustomerInfo();
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
          }
        else if(!empty($oldPass) && empty($newPass)){
            ?>
          <script>
            ErrorNewPasswordEmpty();
          </script>
            <?php
        }
        else if(empty($oldPass) && !empty($newPass)){
            ?>
          <script>
            ErrorOldPasswordEmpty();
          </script>
            <?php
        }
      }   
?>

       