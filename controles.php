<?php
include "layout/header.php";
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login');
}

if (isset($_POST['addControl'])) {
  $a = $_POST['correlativo'];
  $b = $_POST['name'];

  $stmt = $base->prepare('INSERT INTO control_iso (correlativo, name_control) VALUES (?, ?)');
  $result = $stmt->execute(array($a, $b));

  if ($result) {
    echo '<script type="text/javascript">window.location = "' . $url . 'controles";</script>';
  }
}

if (isset($_POST['editControl'])) {
  $id = $_POST['idcontrol'];
  $a = $_POST['correlativo'];
  $b = $_POST['name'];

  $stmt = $base->prepare('UPDATE control_iso set correlativo=?, name_control=? where idcontrol_iso = ?');
  $result = $stmt->execute(array($a, $b, $id));

  if ($result) {
    echo '<script type="text/javascript">window.location = "' . $url . 'controles";</script>';
  }
}

$stmt = $base->prepare('SELECT * from control_iso where state_control= 1 ');
$controles = $stmt->execute();
$controles = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<div class="layout-end p-4">
  <!--COLLAPSE Control-->
  <div>
    <div class="card-body">
      <table id="myTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">N°</th>
            <th class="text-start">Correlativo</th>
            <th class="text-start">Nombre</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php $c = 1;
          foreach ($controles as $i) { ?>
            <tr class="gradeX">
              <td class="text-center"><?= $c ?></td>
              <td class="text-start"><?= $i->correlativo ?></td>
              <td class="text-start"><?= $i->name_control ?></td>
              <td>
                <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-primary btn-control me-2" data-bs-toggle="modal" data-bs-target="#ModalEditControl" id="<?= $i->idcontrol_iso  ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                  <a href="dist/ajax/control?delete=<?= $i->idcontrol_iso ?>" class="btn text-white bg-danger"><i class="fa-solid fa-trash"></i></a>
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
<div class="modal fade" id="ModalAddControl" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Registrar Control</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="validateForm">
        <div class="modal-body">
          <fieldset>
            <div class="modal-body">
              <div class="form-group mb-3">
                <label for="floatTitle">Correlativo</label>
                <input type="text" name="correlativo" class="form-control" id="floatTitle" placeholder="1.1.1"  autocomplete="off" required>
              </div>
              <div class="form-group mb-3">
                <label for="floatTitle2">Control</label>
                <input type="text" name="name" class="form-control" id="floatTitle2" placeholder="Seguridad y control" autocomplete="off" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" control-bs-dismiss="modal">Cancelar</button>
              <button type="submit" name="addControl" class="btn btn-primary">Actualizar</button>
            </div>
          </fieldset>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalEditControl" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Registrar Control</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="body-wrapper">

      </div>
    </div>
  </div>
</div>

<?php include "layout/footer.php"; ?>