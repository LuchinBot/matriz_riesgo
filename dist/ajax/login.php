<?php
require('../../layout/conexion.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $token = $_POST['keyword'];

    // Buscar el usuario en la base de datos
    $stm = $base->prepare('SELECT * FROM user WHERE username=?');
    $stm->execute(array($user));
    $res = $stm->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($res && password_verify($token, $res['keyword'])) {
        $_SESSION['user'] = $res['iduser'];
        $_SESSION['fullname'] = $res['firstname'] . ' ' . $res['lastname'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
    }
}
