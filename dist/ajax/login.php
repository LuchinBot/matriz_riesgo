<?php
require('../../layout/conexion.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $token = $_POST['keyword'];

    // Buscar el usuario en la base de datos
    $stm = $base->prepare('SELECT * FROM user INNER JOIN profiles ON profiles.idprofile = user.idprofile WHERE user.username=?');
    $stm->execute(array($user));
    $res = $stm->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($res && password_verify($token, $res['keyword'])) {
        if($res['session_user'] == 0){
            $_SESSION['user'] = $res['iduser'];
            $_SESSION['firstname'] = $res['firstname'];
            $_SESSION['profile'] = $res['name'];
            $data = [
                'success' => true
            ];
            $stm = $base->prepare('UPDATE user SET session_user = 1 WHERE iduser = ?');
            $stm->execute(array($res['iduser']));
        }else{
            $data = [
                'success' => false,
                'message' => 'Usuario ya conectado.'
            ];
        }
        echo json_encode($data);
       
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Usuario o contraseña incorrectos'
        ]);
    }
}
