<?php
session_start();
$id = "";
if (!isset($_SESSION['user'])) {
  header('Location: ../login');
}

$title_navbar = "Controles <strong>ISO 27001</strong>";
include "../layout/header.php";

if (isset($_POST['new'])) {
  $codigo_ref = $_POST['codigo_ref'];
  $descripcion = $_POST['descripcion'];

  $stmt = $base->prepare('INSERT INTO controles_iso (codigo_ref, descripcion) VALUES (?, ?)');
  $result = $stmt->execute(array($codigo_ref, $descripcion));

  if ($result) {
    echo '<script type="text/javascript">window.location = "' . $url . 'pages/controles_iso";</script>';
  }
}
$stmt = $base->prepare('select * from controles_iso');
$data1 = $stmt->execute();
$data1 = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<div class="col">
  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h5><?= $title_navbar ?></h5>
            <button type="button" class="ml-2 border-0 bg-success" data-toggle="modal" data-target="#new" data-whatever="@mdo" style="width: 30px; height: 30px; border-radius:50px"><i class="fa fa-plus"></i></button>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="ibox-content">

            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $c = 1;
                  foreach ($data1 as $v1) { ?>
                    <tr class="gradeX">
                      <td><?= $c ?></td>
                      <td><?= $v1->codigo_ref ?></td>
                      <td><?= $v1->descripcion ?></td>
                      <td>
                        <div class="d-flex">
                          <a class="bg-primary d-flex m-1 align-items-center justify-content-center text-white" style="width: 30px; height: 30px;">
                            <i class="fa fa-pencil"></i></i>
                          </a>
                          <a class="bg-danger d-flex m-1 align-items-center justify-content-center text-white" style="width: 30px; height: 30px;">
                            <i class="fa fa-trash"></i></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php $c++;
                  } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>N°</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                  </tr>
                </tfoot>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="new" tabindex="-1" aria-labelledby="new" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar <?= $title_navbar ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Código</label>
            <input type="text" class="form-control" name="codigo_ref" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="message-text"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" name="new" class="btn btn-primary">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include "../layout/footer.php"; ?>