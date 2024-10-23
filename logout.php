<?php
require ('layout/conexion.php');
session_start();
// Cambiar el valor de la variable de sesión
$stmt = $base->prepare('UPDATE user SET session_user = 0 WHERE iduser = ?');
$stmt->execute(array($_SESSION['user']));

session_destroy();

header('Location: login');
?>