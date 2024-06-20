<footer class="footer">
    <div class="waves">
      <div class="wave" id="wave1"></div>
      <div class="wave" id="wave2"></div>
      <div class="wave" id="wave3"></div>
      <div class="wave" id="wave4"></div>
    </div>
    <ul class="social-icon">
      <li class="social-icon__item"><a class="social-icon__link" href="https://www.facebook.com/cafeharaya">
          <ion-icon name="logo-facebook"></ion-icon>
        </a></li>
      <li class="social-icon__item"><a class="social-icon__link" href="https://mail.google.com/mail/u/0/?fs=1&to=cafeharaya@gmail.com&su=&body=&tf=cm">
          <ion-icon name="mail"></ion-icon>
        </a></li>
      <li class="social-icon__item"><a class="social-icon__link" href="https://www.instagram.com/cafeharaya?fbclid=IwAR1bGdp4ectewVKNHkXdC1yyNrz8609HZstCFMDhxtnLjYiI2x1apxtesYQ">
          <ion-icon name="logo-instagram"></ion-icon>
        </a></li>
    </ul>

    <ul class="menu">
      <p class="social-icon__link" style="margin-right: 1rem;">
        <ion-icon name="call"></ion-icon> 09178944937
      </p>
      <p class="social-icon__link" style="margin-right: 1rem;">
        <ion-icon name="home"></ion-icon> Arbortowne Plaza 1, Karuhatan Road 1441
      </p>
    </ul>
    <p>&copy;2023 CAFE HARAYA | All Rights Reserved</p>
  </footer>

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<style>
.footer {
  position: relative;
  width: 100%;
  background: #562B08;
  min-height: 90px;
  padding: 15px 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin-top: 7rem;
}

.social-icon,
.menu {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 10px 0;
  flex-wrap: wrap;
}

.social-icon__item {
  list-style: none;
}

.social-icon__link,
.social-icon_link {
  font-size: 2rem;
  color: #fff;
  margin: 0 10px;
  display: inline-block;
  transition: 0.5s;
}
.social-icon__link:hover {
  transform: translateY(-10px);
  color: #F5CCA0;
}

.footer p {
  color: #fff;
  font-size: 1rem;
  font-weight: 300;
}

.wave {
  position: absolute;
  top: -100px;
  left: 0;
  width: 100%;
  height: 100px;
  background: url("../assets/images/icon/wave.png");
  background-size: 1000px 100px;
  
}

.wave#wave1 {
  z-index: 200;
  opacity: 1;
  bottom: 0;
  animation: animateWaves 4s linear infinite;
}

.wave#wave2 {
  z-index: 199;
  opacity: 0.5;
  bottom: 10px;
  animation: animate 4s linear infinite !important;
}

.wave#wave3 {
  z-index: 200;
  opacity: 0.2;
  bottom: 15px;
  animation: animateWaves 3s linear infinite;
}

.wave#wave4 {
  z-index: 199;
  opacity: 0.7;
  bottom: 20px;
  animation: animate 3s linear infinite;
}

@keyframes animateWaves {
  0% {
    background-position-x: 1000px;
  }
  100% {
    background-positon-x: 0px;
  }
}

@keyframes animate {
  0% {
    background-position-x: -1000px;
  }
  100% {
    background-positon-x: 0px;
  }
}
</style>