<?php 
    session_start();
    include "../assets/connection.php"; 

    $custEmail = $_SESSION['custEmail'];

    $sql = "select * from customer where email = '$custEmail'";
    $sqlrun = mysqli_query($conn, $sql);
    if($sqlrun){
        $result = mysqli_fetch_assoc($sqlrun);
    }
?>

<form action = "index.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 1rem; padding: 1.4rem;" >
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem; border-bottom: 0;">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 50%; border: 1px solid #000; font-size: .7rem;"></button>
      </div>
      <div class="modal-body" style="padding: .5rem">
        <div class="login-title">Personal Information</div>
        <div class="login-subtitle">Need to change your account details?</div>
        <div class = "credentials">
          <label>Personal Details</label>
          <div class="personalInfo">
            <input name="cust_fname" id="cust_fname" type="text" placeholder="First Name" value="<?php echo $result['f_name']; ?>" required>
            <input name="cust_lname" id="cust_lname" type="text" placeholder="Last Name" value="<?php echo $result['l_name']; ?>" required>
          </div>
          <label>Login & Contact Details</label>
          <div class="loginInfo">
            <input name="cust_email" id="cust_email" type="email" placeholder="Email Address" value="<?php echo $result['email']; ?>" required>
            <div class="contact-wrapper">
                <span>+63</span>
                <input name="cust_contact" id="cust_contact" type="tel" pattern="[0-9]{10}" placeholder="Mobile Number"  value="<?php echo $result['contact']; ?>" required>
            </div>
          </div>
          <div class="loginInfo">
            <input name="cust_oldPassword" id="cust_oldPassword" type="password" placeholder="Enter Old Password">
            <input name="cust_newPassword" id="cust_newPassword" type="password" placeholder="Enter New Password">
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; margin: 0;">
        <button type="submit" name="saveInfo" class="btn btn-success" id="saveInfo">Save</button>
      </div>
    </div>
  </div>
</form>

<style>
  .login-logo{
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .login-logo img{
    height: 150px; 
    width: 150px; 
    border: 1px solid #DDD; 
    border-radius: 20%;
  }

  .login-title{
    font-family: 'Poppins';
    text-align: center;
    font-size: 1.8rem;
    color: #000;
    font-weight: 800;
    letter-spacing: .5px;
    margin-top: .5rem;
  }

  .login-subtitle{
    font-family: 'Poppins';
    text-align: center;
    font-size: 1.2rem;
    color: #191919;
    font-weight: 100;
    margin-bottom: 1rem;
  }
  
  .credentials{
    padding: 1.2rem;
  }

  .credentials input {
    font-family: 'Poppins';
    flex: 1;
    border: none;
    border-radius: 0;
    outline: none;
    background-color: rgb(244, 244, 244);
    font-size: 1rem;
    color: #000;
    padding: 20px 10px 20px 5px;
    width: 100%;
}

  .personalInfo input,
  .loginInfo input{
    border: none;
    border-radius: 0;
    outline: none;
    background-color: rgb(244, 244, 244);
    font-size: 1rem;
    color: #000;
    padding: 20px 5px; 
    margin-right: 10px;
    border-bottom: 1px solid #c2c4c3;
    width: calc(100% / 2 - 0px);
}

  .personalInfo,
  .loginInfo{
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  .contact-wrapper {
    display: flex;
    align-items: center;
    width: calc(100% / 2 - 0px);
}

  .contact-wrapper input {
    border: none;
    border-radius: 0;
    outline: none;
    background-color: rgb(244, 244, 244);
    font-size: 1rem;
    color: #000;
    padding: 20px 5px;
    border-bottom: 1px solid #c2c4c3;
}

  .contact-wrapper span {
    font-size: 1rem;
    color: #555555;
    background-color: rgb(244, 244, 244);
    padding: 20px 5px;
    border-bottom: 1px solid #c2c4c3;
  }

  #saveInfo{
    outline: none;
    border: none;
    width: 45%;
    height: 50px;
    border-radius: 30px;
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    text-align: center;
    background-color: #562B08;
    box-shadow: 1px 1px 5px #000,
                -1px -1px 5px #fff; 
    transition: .5s;
  }

  #saveInfo:hover{
    background-color: #6F4E37;
  }
</style>

<!-- JS -->
<script>
    document.getElementById("cust_contact").addEventListener("input", function (event) {
        let inputValue = event.target.value;
        inputValue = inputValue.replace(/[^0-9]/g, "");

        if (inputValue.length > 10) {
            inputValue = inputValue.slice(0, 10);
        }

        event.target.value = inputValue;
    });
</script>