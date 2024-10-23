<?php
$login = 1;
$title = "Loguearse";
include "layout/header.php";

if (isset($_SESSION['user'])) {
  header('Location: matriz');
  exit();
}

?>
<style>
  .wrapper {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>
<div class="wrapper">
  <div class="py-3 px-5 bg-white main-login">
    <div class="mb-5 b-2">
      <h1 class="title-captcha text-center text-dark">YOP'</h1>
    </div>
    <form class="demo-form">
      <div class="form-group-login">
        <i class="fa-regular fa-user"></i>
        <input type="text" class="form-control-login" name="user" autocomplete="off" />
      </div>
      <div class="form-group-login">
        <i class="fa-regular fa-eye"></i>
        <input type="password" class="form-control-login" name="key" autocomplete="off" />
      </div>
      <div class="btn-verify">
        <span></span>
        <h1 class="p-0 title-captcha" style="font-size: 17px;">CAPTA</h1>
      </div>
      <div class="alert-login w-100">
      </div>
      <button type="button" class="btn-login">
        Iniciar sesión
      </button>
    </form>
  </div>
  <div class="py-3 px-5 bg-white main-login-intentes">
    <div class="mb-5 b-2">
      <img src="<?= $url ?>dist/img/intentes.png" alt="">
      <h1 class="title-captcha text-center text-dark">YOP'</h1>
      <p>
        <strong class="text-danger">Demasiados intentos</strong>
        <br>
        <small class="text-muted">Comunicate con el administrador</small>
      </p>
    </div>
  </div>
</div>
<div class="captchaLogin">
  <div class="basecaptchaLogin">
    <div class="wrapper">
      <div class="captcha">
        <div class="captcha-container">
          <h1 class="title-captcha">CAPTA</h1>
          <p id="captcha-prompt" class="bg-success p-2 m-0"></p>
          <div class="d-flex flex-column mb-3">
            <input type="text" id="captcha-answer" placeholder="Ingresa tu respuesta">
            <button id="verificar-btn"><i class="fa fa-circle-check"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "layout/footer.php"; ?>