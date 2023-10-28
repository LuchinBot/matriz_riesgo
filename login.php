<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$autor = $_ENV['AUTOR'];

session_start();
if (isset($_SESSION['user'])) {
  header('Location: /');
}
$msg = "";
if (isset($_POST['login'])) {
  $email = $_POST['user'];
  $token = $_POST['password'];

  if ($email == "admin" && $token = "123456") {
    $_SESSION['user'] = "Admin";
    header('Location: /');
  } else {
    $msg = "* Error en las credenciales";
  }
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="text-center animated fadeInDown mt-5">
        <div class="py-3 px-5 bg-white middle-box loginscreen" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
            <div class="mb-2">
                <img src="img/login.jpg" style="width: 100%;">
            </div>
            <p>Autenticarse para iniciar sesión</p>
            <form class="m-t" role="form" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="user" placeholder="Usuario" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" required="">
                </div>
                <button type="submit" class="btn btn-primary rounded-0 block full-width m-b" name="login">Acceder</button>
            </form>
            <p class="m-t"> <small><?=$autor?> &copy; 2023</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>
