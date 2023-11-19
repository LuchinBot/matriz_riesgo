<?php
$title = "Eventos";
include "layout/header.php";
if (!isset($_SESSION['user'])) {
  header('Location: login');
}

if (isset($_POST['addControl'])) {
  $a = $_POST['idmatriz'];
  $b = $_POST['idevent'];
  $c = $_POST['idcontrol'];
  

  // Obtener todos los registros actuales
  $stmt_select = $base->prepare('SELECT idcontrol_event, idcontrol FROM control_event WHERE idmatriz = ? AND idevent = ?');
  $stmt_select->execute(array($a, $b));

  // Almacenar los ID de control_event
  $existing_control_events = array();
  while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
    $existing_control_events[$row['idcontrol']] = $row['idcontrol_event'];
  }

  // Iterar sobre los controles enviados por el formulario
  foreach ($c as $idcontrol) {
    if (!isset($existing_control_events[$idcontrol])) {
      $stmt_insert = $base->prepare('INSERT INTO control_event (idmatriz, idevent, idcontrol) VALUES (?, ?, ?)');
      $result = $stmt_insert->execute(array($a, $b, $idcontrol));
    } else {
      unset($existing_control_events[$idcontrol]);
    }
  }

  // Eliminar los registros que ya no están en el formulario
  foreach ($existing_control_events as $idcontrol_event) {
    $stmt_delete = $base->prepare('DELETE FROM control_event WHERE idcontrol_event = ?');
    $result = $stmt_delete->execute(array($idcontrol_event));
  }


  echo '<script type="text/javascript">window.location = "' . $url . 'eventos";</script>';
}


$stmt = $base->prepare('SELECT * from events as e inner join levels as l on(l.idlevel = e.idlevel)
inner join probabilidad as p on(p.idprobabilidad = e.idprobabilidad) inner join impacto as i on(i.idimpacto=e.idimpacto) 
left join matriz as m on(m.idmatriz = i.idmatriz)where m.iduser = ? and e.state_event= 1 ');
$eventos = $stmt->execute(array($_SESSION['user']));
$eventos = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<div class="layout-end p-4">
  <!--COLLAPSE MATRIZ-->
  <div>
    <div class="card-body">
      <table id="myTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">N°</th>
            <th class="text-center">Evento</th>
            <th class="text-center">Probabilidad</th>
            <th class="text-center">Impacto</th>
            <th class="text-center">Riesgo</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php $c = 1;
          foreach ($eventos as $i) { ?>
            <tr class="gradeX">
              <td class="text-center"><?= $c ?></td>
              <td class="text-center"><?= $i->name_event ?></td>
              <td class="text-center"><?= $i->name_probabilidad ?></td>
              <td class="text-center"><?= $i->name_impacto ?></td>
              <td class="text-center"><?= $i->name_level ?></td>
              <td>
                <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-primary btn-event-control me-2" data-bs-toggle="modal" data-bs-target="#ModalAddControl2" id="<?= $i->idevent  ?>"><i class="fa-solid fa-shield-halved"></i></button>
                  <a href="dist/ajax/event?delete=<?= $i->idevent ?>" class="btn text-white bg-danger"><i class="fa-solid fa-trash"></i></a>
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
<div class="modal fade" id="ModalAddControl2" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

<?php include "layout/footer.php"; ?>