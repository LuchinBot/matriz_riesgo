<?php

session_start();
$id = "";
if (!isset($_SESSION['user'])) {
  header('Location: ../login');
}
$title_navbar = "Controles <strong>ISO 27001</strong>";
include "../layout/header.php";
?>


<?php include "../layout/footer.php";?>