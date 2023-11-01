<?php
session_start();
$id = "";
if (!isset($_SESSION['user'])) {
  header('Location: ../login');
}

$title_navbar = "Matriz de Riesgo";
include "../layout/header.php";

if (isset($_POST['new'])) {
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'];

  $stmt = $base->prepare('INSERT INTO matriz (titulo, descripcion) VALUES (?, ?)');
  $result = $stmt->execute(array($titulo, $descripcion));

  if ($result) {
    echo '<script type="text/javascript">window.location = "' . $url . 'pages/matriz";</script>';
  }
}
$stmt = $base->prepare('select * from matriz ');
$data1 = $stmt->execute();
$data1 = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $base->prepare('select ma.codigo as codigo_matriz, coni.descripcion as descripcion_control from controles_matriz as con inner join
                        matriz as ma on(ma.codigo=con.codigo_matriz) inner join
                        controles_iso as coni on(coni.codigo=con.codigo_control_iso_1 and coni.codigo_ref=con.codigo_control_iso_2) ');
$data2 = $stmt->execute();
$data2 = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Matriz de Riesgo</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= $url ?>pages/matriz">Matriz de riesgo</a></li>
          <li class="breadcrumb-item active">Administración</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<section class="content">
  
  <div class="card">
    <div class="card-header">
      <button type="button" class="ml-2 border-0 bg-success" data-toggle="modal" data-target="#new" data-whatever="@mdo" style="width: 30px; height: 30px; border-radius:50px"><i class="fa fa-plus"></i></button>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>N°</th>
            <th>Titulo</th>
            <th>Descripción</th>
            <th>Controles</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php $c = 1;
          foreach ($data1 as $v1) { ?>
            <tr class="gradeX">
              <td><?= $c ?></td>
              <td><?= $v1->titulo ?></td>
              <td><?= $v1->descripcion ?></td>
              <td>
                <?php
                $v = 1;
                foreach ($data2 as $v2) {
                  if ($v1->codigo == $v2->codigo_matriz) {
                    echo '<i class="text-success">' . $v2->descripcion_control . '</i><br>';
                    $v = 0;
                  }
                }
                if ($v == 1) {
                  echo '<i class="text-secondary">No existen controles</i>';
                }
                ?>
              </td>
              <td>
                <div class="d-flex">
                  <a id="<?= $v1->codigo ?>" class="edit-matriz bg-primary d-flex m-1 align-items-center justify-content-center text-white" style="width: 30px; height: 30px;" data-toggle="modal" data-target="#edit" data-whatever="@mdo">
                    <i class="fa fa-edit"></i></i>
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
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Controles</th>
            <th>Acciones</th>
          </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

</section>

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
            <label for="recipient-name" class="col-form-label">Titulo</label>
            <input type="text" class="form-control" name="titulo" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="message-text"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" name="new" class="btn btn-primary">Enviar</button>
          </div>
          
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="new" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar <?= $title_navbar ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" name="edit" class="btn btn-primary">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include "../layout/footer.php"; ?>