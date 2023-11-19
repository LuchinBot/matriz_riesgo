<?php
$title = "Matrices";
include "layout/header.php";
if (!isset($_SESSION['user'])) {
  header('Location: login');
}
if (isset($_POST['addMatriz'])) {
  $a = $_POST['iddimension'];
  $b = $_SESSION['user'];
  $c = $_POST['titulo_matriz'];
  $d = $_POST['descripcion_matriz'];

  $stmt = $base->prepare('INSERT INTO matriz (iddimension,iduser, title_matriz, text_matriz) VALUES (?,?, ?,?)');
  $result = $stmt->execute(array($a, $b, $c,$d));

  if ($result) {
    echo '<script type="text/javascript">window.location = "' . $url . 'matriz";</script>';
  }
}

if (isset($_POST['editMatriz'])) {
  $id = $_POST['idmatriz'];
  $a = $_POST['iddimension'];
  $b = $_POST['titulo_matriz'];
  $c = $_POST['descripcion_matriz'];

  $stmt = $base->prepare('UPDATE matriz set iddimension=?, title_matriz=?, text_matriz=? where idmatriz = ?');
  $result = $stmt->execute(array($a, $b, $c, $id));

  if ($result) {
    echo '<script type="text/javascript">window.location = "' . $url . 'matriz";</script>';
  }
}

$stmt = $base->prepare('SELECT * from matriz as m inner join dimension as d on(d.iddimension = m.iddimension) where iduser = ? and m.state_matriz = 1 ');
$data1 = $stmt->execute(array($_SESSION['user']));
$data1 = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $base->prepare('SELECT * from control_event as con inner join
                        matriz as ma on(ma.idmatriz=con.idmatriz) inner join
                        control_iso as coni on(coni.idcontrol_iso=con.idcontrol) ');
$data2 = $stmt->execute();
$data2 = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $base->prepare('SELECT * from dimension where state_dimension= 1 ');
$dimension = $stmt->execute();
$dimension = $stmt->fetchAll(PDO::FETCH_OBJ);


?>

<div class="layout-end p-4">
  <!--COLLAPSE MATRIZ-->
  <div>
    <div class="card-body">
      <table id="myTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>N°</th>
            <th>Titulo</th>
            <th>Dimension</th>
            <th>Controles</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php $c = 1;
          foreach ($data1 as $v1) { ?>
            <tr class="gradeX">
              <td><?= $c ?></td>
              <td><?= $v1->title_matriz ?></td>
              <td><?= $v1->name_dimension ?></td>
              <td>
                <?php
                $v = 1;
                foreach ($data2 as $v2) {
                  if ($v1->idmatriz == $v2->idmatriz) {
                    echo '<i class="text-success">' . $v2->name_control . '</i><br>';
                    $v = 0;
                  }
                }
                if ($v == 1) {
                  echo '<i class="text-secondary">No existen controles</i>';
                }
                ?>
              </td>
              <td>
                <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-primary btn-id me-2" data-bs-toggle="modal" data-bs-target="#ModalEditMatriz" id="<?= $v1->idmatriz  ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                  <?php if ($v1->generate_matriz == 0) { ?>
                    <button id="<?= $v1->idmatriz ?>" class="btn text-white bg-info me-2 generate"><i class="fa-solid fa-rotate"></i></button>
                  <?php } else { ?>
                    <button type="button" class="btn btn-warning btn-view me-2" data-bs-toggle="modal" data-bs-target="#ModalDateMatriz" id="<?= $v1->idmatriz  ?>"><i class="fa-solid fa-eye"></i></button>
                    <button type="button" class="btn btn-success btn-matriz me-2" data-bs-toggle="modal" data-bs-target="#ModalViewMatriz" id="<?= $v1->idmatriz  ?>"><i class="fa-solid fa-table-cells"></i></button>
                  <?php } ?>
                  <a href="dist/ajax/matriz?delete=<?= $v1->idmatriz ?>" class="btn text-white bg-danger"><i class="fa-solid fa-trash"></i></a>
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
<div class="modal fade" id="ModalAddMatriz" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Registrar Matriz</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="validateForm">
        <fieldset>
          <div class="modal-body">
            <div class="form-group mb-3">
              <label for="floatTitle">Titulo</label>
              <input type="text" name="titulo_matriz" class="form-control" id="floatTitle" placeholder="Matriz" autocomplete="off" required title="Campo requerido">
            </div>
            <div class="form-group">
              <label for="floatDescripcion">Descripción</label>
              <textarea class="form-control" name="descripcion_matriz" id="floatDescripcion" placeholder="Matriz de ejemplo" autocomplete="off" required title="Campo requerido"></textarea>
            </div>
            <div class="form-group">
              <label>Dimensión</label>
              <select class="select2" name="iddimension" style="width: 100%;" required title="Campo requerido">
                <?php foreach ($dimension as $i) : ?>
                  <option value="<?= $i->iddimension ?>"><?= $i->name_dimension ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" name="addMatriz" class="btn btn-primary">Registrar</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="ModalEditMatriz" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Registrar Matriz</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="body-wrapper">

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalDateMatriz" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Visualizar Matriz</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="body-wrapper p-4">

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalViewMatriz" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Visualizar Matriz</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="body-wrapper p-4">

      </div>
    </div>
  </div>
</div>
<div class="generate-matriz" style="display: none;">
  <i class="fa-solid fa-robot text-success fs-3"></i>
</div>

<?php include "layout/footer.php"; ?>