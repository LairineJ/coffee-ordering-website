<?php
session_start();
include '../assets/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
  <link rel="icon" type="image/png" href="../assets/images/icon/logo.png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

  <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

  <script defer src="../assets/js/table.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../assets/js/alert/alert.js"></script>
  <title>Admin | Login</title>
</head>

<body>
    <!-- Sign In -->
    <form method="post" action="">
        <div class="login-container">
            <div class="box">
                <div class="login-content-img">
                    <img src="../assets/images/icon/logo.png" class="logo" alt="">
                </div>
                <div class="login-content">
                    <div class="login-title">Administrator</div>
                    <div class="login-subtitle">Sign in to your account.</div>
                    <div class="logIn">
                        <input type="text" name="email" placeholder="Username" class="form-control">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                        <span class="text-center text-danger"></span>
                        <button type="submit" class="btn-login" name="adminLogin">Sign in</button>
                    </div>
                    <div class="home-link">
                        <a href="../index.php">Proceed to the main website ></a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Scripts -->
    <?php include '../assets/php/extensions/session.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

<style>
.login-title{
    font-family: 'Poppins';
    text-align: center;
    font-size: 2.4rem;
    color: #000;
    font-weight: 800;
    letter-spacing: .5px;
    margin-top: .5rem;
  }

  .login-subtitle{
    font-family: 'Poppins';
    text-align: center;
    font-size: 1.3rem;
    color: #191919;
    font-weight: 100;
    margin-bottom: 2rem;
  }

  .home-link{
    margin-top: .5rem;
    text-align: center;
  }

  .home-link a{
    text-decoration: none;
    color: #8A3324;
    transition: .5s;
  }

  .home-link a:hover{
    color: #704241;
  }
</style>