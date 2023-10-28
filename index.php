<?php

session_start();
$id = "";
if (!isset($_SESSION['user'])) {
  header('Location: login');
}
$title_navbar = "Bienvenido al sistema principal";
include "layout/header.php";
?>


<?php include "layout/footer.php";?>