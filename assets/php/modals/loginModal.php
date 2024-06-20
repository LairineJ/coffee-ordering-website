<?php include "../assets/connection.php" ?>
<form action="index.php" method="POST" enctype="multipart/form-data">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1rem; padding: 1.4rem;" >
      <div class="modal-header" style= "border-top-left-radius: 1rem; border-top-right-radius: 1rem; border-bottom: 0;">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 50%; border: 1px solid #000; font-size: .7rem;"></button>
      </div>
      <div class="modal-body">
        <div class="login-logo">
            <img src = "../assets/images/icon/logo.png">
        </div>
        <div class="login-title">Welcome Back!</div>
        <div class="login-subtitle">Sign in to your account.</div>
        <div class = "credentials">
          <input type="hidden" name="customer_id" value="<?php echo $row['customer_id'] ?>"/>
          <div class="email_ad">
            <span class="fa-solid fa-envelope"></span>
            <input name="custEmail" id="custEmail" type="email" placeholder="Enter Email Address" required>
          </div>
          <div class="pass">
            <span class="fa-solid fa-lock"></span>
            <input name="custPass" id="custPass" type="password" placeholder="Enter Password" style="margin-right: 0" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="loginBtn" class="btn btn-success" id="loginBtn">Log In</button>
      </div>
      <div class="sign-up-link">
          Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Create One</a>
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
    font-size: 1.5rem;
    color: #000;
    font-weight: 800;
    letter-spacing: .5px;
    margin-top: .5rem;
  }

  .login-subtitle{
    font-family: 'Poppins';
    text-align: center;
    font-size: .9rem;
    color: #191919;
    font-weight: 100;
    margin-bottom: 1rem;
  }
  
  .credentials{
    padding: 1.5rem;
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

  .email_ad,
  .pass{
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #c2c4c3;
    transition: .5s ease;
  }

  .email_ad:hover,
  .pass:hover{
    border-bottom: 1px solid #4b3619;
  }

  .email_ad span,
  .pass span {
      margin-right: 10px;
      font-size: 1.5rem;
  }

  #loginBtn{
    outline: none;
    border: none;
    width: 100%;
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

  #loginBtn:hover{
    background-color: #6F4E37;
  }

  .sign-up-link{
    text-align: center;
  }

  .sign-up-link a{
    text-decoration: none;
    color: #8A3324;
    transition: .5s;
  }

  .sign-up-link a:hover{
    color: #704241;
  }
</style>