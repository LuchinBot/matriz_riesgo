<?php
require('conexion.php');
$autor = "Tony";
$url = "http://matriz_riesgo.test/";
session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= $url ?>dist/img/unsm.png" type="image/icon">
  <title><?= $title ?> | Dashboard</title>

  <!--Font google-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  <!--Styles-->
  <link href="<?= $url ?>dist/css/important.css" rel="stylesheet">
  <link href="<?= $url ?>dist/css/login.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/select2/select2.min.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/adminlte/adminlte.min.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/fontawesome/css/all.min.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/fontawesome/css/solid.min.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/fontawesome/css/brands.min.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/summernote/summernote-bs4.min.css" rel="stylesheet">
  <link href="<?= $url ?>dist/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
</head>

<body>
  <?php if (!isset($login)) { ?>
    <div class="float-left">
      <span class="times">
        <i class="fa fa-caret-right"></i>
      </span>
      <div class="profile-top">
        <img src="<?= $url ?>dist/img/userv2.jpg">
        <div class="d-flex flex-column text-left ms-2">
          <p><?= $_SESSION['firstname'] ?></p>
          <span style="text-transform: uppercase; font-size:10px; color : #d2d2d2"><?= $_SESSION['profile'] ?></span>
        </div>
      </div>
      <ul class="navbar-profile">
        <li>
          <span data-bs-toggle="modal" data-bs-target="#ModalAddMatriz">
            <i class="fa-solid fa-plus"></i>
          </span>
          <a href="matriz" class="d-flex justify-content-center align-items-center">
            <div class="btn_dom d-flex" id="btn_collapseMatriz">
              Matrices
            </div>
          </a>
        </li>
        <li>
          <a href="eventos" class="d-flex justify-content-center align-items-center">
            <span>
              <i class="fa-solid fa-bomb"></i>
            </span>
            <div class="btn_dom d-flex" id="btn_collapseMatriz">
              Eventos
            </div>
          </a>
        </li>
        <li>
          <span data-bs-toggle="modal" data-bs-target="#ModalAddControl">
            <i class="fa-solid fa-plus"></i>
          </span>
          <a href="controles" class="d-flex justify-content-center align-items-center">
            <div class="btn_dom d-flex" id="btn_collapseMatriz">
              Controles
            </div>
          </a>
        </li>
        <hr>
        <?php if ($_SESSION['profile'] == 'super') { ?>
          <li>
            <span data-bs-toggle="modal" data-bs-target="#ModalAddUsuario">
              <i class="fa-solid fa-plus"></i>
            </span>
            <a href="usuarios" class="d-flex justify-content-center align-items-center">
              <div class="btn_dom d-flex" id="btn_collapseUsuario">
                Usuarios
              </div>
            </a>
          </li>
        <?php } ?>
        <li>
          <a href="logout" id="logout" class="d-flex text-white align-items-center text-danger" style="font-weight: 700;">
            <span class="add bg-danger">
              <i class="fa-solid fa-right-from-bracket"></i>
            </span>
            Salir
          </a>
        </li>
      </ul>
    </div>
    <div class="wrapper container">
      <div class="layout">
      <?php } ?>