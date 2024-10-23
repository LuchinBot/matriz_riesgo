<?php
$title = "usuarios";
include "layout/header.php";
if (!isset($_SESSION['user']) && $_SESSION['profile'] == 'admin') {
  header('Location: login');
}
if (isset($_POST['addUsuario'])) {
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
if (isset($_POST['editUsuario'])) {
  $id = $_POST['iduser'];
  $a = $_POST['profile'];
  $b = $_POST['firstname'];
  $c = $_POST['lastname'];
  $d = $_POST['username'];

  if (isset($_POST['password']) && !empty($_POST['password'])) {
    $e = $_POST['password'];
    $hashedPassword = password_hash($e, PASSWORD_DEFAULT);

    $stmt = $base->prepare('UPDATE user set idprofile=?, firstname=?, lastname=?, username=?, keyword=? where iduser = ?');
    $result = $stmt->execute(array($a, $b, $c, $d, $hashedPassword, $id));

    if ($result) {
      echo '<script type="text/javascript">window.location = "' . $url . 'usuarios";</script>';
    }
  } else {
    $stmt = $base->prepare('UPDATE user set idprofile=?, firstname=?, lastname=?, username=? where iduser = ?');
    $result = $stmt->execute(array($a, $b, $c, $d, $id));

    if ($result) {
      echo '<script type="text/javascript">window.location = "' . $url . 'usuarios";</script>';
    }
  }
}

$stmt = $base->prepare('SELECT * from user where state_user= 1 ');
$usuarios = $stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $base->prepare('SELECT * from profiles');
$profiles = $stmt->execute();
$profiles = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<div class="layout-end p-4">
  <!--COLLAPSE user-->
  <div>
    <div class="card-body">
      <div class="d-flex mb-4 justify-content-between py-1 border-bottom">
        <h3 class="fw-bold">Usuarios</h3>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalAddUsuario">
          <i class="fa-solid fa-plus"></i>
        </button>
      </div>
      <table id="myTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">N°</th>
            <th class="text-start">Nombre</th>
            <th class="text-start">Usuario</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php $c = 1;
          foreach ($usuarios as $i) { ?>
            <tr class="gradeX">
              <td class="text-center"><?= $c ?></td>
              <td class="text-start"><?= $i->firstname ?></td>
              <td class="text-start"><?= $i->username ?></td>
              <td>
                <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-primary btn-user me-2" data-bs-toggle="modal" data-bs-target="#ModalEdituser" id="<?= $i->iduser  ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                  <a href="dist/ajax/user?delete=<?= $i->iduser ?>" class="btn text-white bg-danger"><i class="fa-solid fa-trash"></i></a>
                </div>
              </td>
            </tr>
          <?php $c++;
          } ?>
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalAddUsuario" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Registrar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="validateForm">
        <div class="modal-body">
          <fieldset>
            <div class="modal-body">
              <div class="form-group mb-3 w-100 d-flex">
                <select name="profile" class="select2 w-100">
                  <option value="1">Super Administrador</option>
                  <option value="2">Administrador</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="floatTitle1">Nombres</label>
                <input type="text" name="firstname" id="floatTitle1" class="form-control" placeholder="Jharold" autocomplete="off" required>
              </div>
              <div class="form-group mb-3">
                <label for="floatTitle2">Apellidos</label>
                <input type="text" name="lastname" id="floatTitle2" class="form-control" placeholder="Pinedo" autocomplete="off" required>
              </div>
              <div class="form-group mb-3">
                <label for="floatTitle3">Usuario</label>
                <input type="text" name="user" id="floatTitle3" class="form-control" placeholder="jharilto" autocomplete="off" required>
              </div>
              <div class="form-group mb-3">
                <label for="floatTitle4">Contraseña</label>
                <input type="text" name="key" id="floatTitle4" class="form-control" placeholder="*********" autocomplete="off" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" user-bs-dismiss="modal">Cancelar</button>
              <button type="submit" name="addUsuario" class="btn btn-primary">Actualizar</button>
            </div>
          </fieldset>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalEdituser" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Registrar user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="body-wrapper">

      </div>
    </div>
  </div>
</div>

<?php include "layout/footer.php"; ?>