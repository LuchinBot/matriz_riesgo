<?php
$login = 1;
$title = "Registrarse";
include "layout/header.php";

if (isset($_SESSION['user'])) {
  header('Location: matriz');
  exit(); // Asegúrate de hacer un exit después de redirigir
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $profile = $_POST['profile'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $user = $_POST['user'];
  $token = $_POST['key'];
  $hashedPassword = password_hash($token, PASSWORD_DEFAULT);

  $stm = $base->prepare('SELECT * FROM user WHERE username=?');
  $stm->execute(array($user));
  $res = $stm->fetch(PDO::FETCH_ASSOC);

  if ($res) {
    echo '<script type="text/javascript">alert("Usuario ya existe");</script>';
  } else {
    $stm = $base->prepare('INSERT INTO user ( idprofile, firstname, lastname, username, keyword) VALUES (?, ?, ?, ?, ?)');
    $stm->execute(array($profile, $firstname, $lastname, $user, $hashedPassword));

    if ($stm->rowCount() > 0) {
      header('Location: login');
    }
  }
}

?>

<div class="wrapper">
  <div class="py-3 px-5 bg-white main-login">
    <div class="mb-5 b-2">
      <h1 class="title-captcha text-center text-dark">YOP'</h1>
    </div>
    <form class="demo-form" method="POST">
      <div class="form-group-login w-100 d-flex">
        <select name="profile" class="select2 w-100">
          <option value="1">Super Administrador</option>
          <option value="2">Administrador</option>
        </select>
      </div>
      <div class="form-group-login">
        <i class="fa-regular fa-user"></i>
        <input type="text" class="form-control-login" name="firstname" autocomplete="off" />
      </div>
      <div class="form-group-login">
        <i class="fa-regular fa-user"></i>
        <input type="text" class="form-control-login" name="lastname" autocomplete="off" />
      </div>
      <div class="form-group-login">
        <i class="fa-regular fa-user"></i>
        <input type="text" class="form-control-login" name="user" autocomplete="off" />
      </div>
      <div class="form-group-login">
        <i class="fa-regular fa-eye"></i>
        <input type="password" class="form-control-login" name="key" autocomplete="off" />
      </div>
      <div class="alert-login w-100">
      </div>
      <button type="submit" name="register" class="btn-login">
        Crear
      </button>
    </form>
  </div>
</div>
<?php include "layout/footer.php"; ?>