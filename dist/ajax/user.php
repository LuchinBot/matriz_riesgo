<?php
session_start(); // Asegúrate de iniciar la sesión
require('layout/conexion.php');

if (isset($_SESSION['user'])) {
    header('Location: matriz');
    exit();
}

$display = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $token = $_POST['key'];
    $hashedPassword = password_hash($token, PASSWORD_DEFAULT);

    $stm = $base->prepare('INSERT INTO user (username, keyword) VALUES (?, ?)');
    $stm->execute(array($user, $hashedPassword));
    $res = $stm->fetch(PDO::FETCH_ASSOC);

    if ($res) {
        $_SESSION['user'] = $res['iduser'];
        $_SESSION['fullname'] = $res['firstname'] . ' ' . $res['lastname'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
    }
}
