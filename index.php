<?php
include "layout/header.php";
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login');
}

?>
<!-- Content Header (Page header) -->

<div class="wrapper">
  <div class="layout">
    <div class="layout-start">
      <div class="start-body">
        <div id="hello" class="" style="display:block">
          <img src="<?= $url ?>dist/img/hello.png" style="width: 100%;">
          <h4>Bienvenido de vuelta</h4>
          <h1>Administrador</h1>
          <div class="moved">
            <a href="matriz" class="btn-moved text-white">
              <i class="fa-solid fa-face-laugh-beam"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?php include "layout/footer.php"; ?>