<?php
session_start();
$id = "";
if (!isset($_SESSION['user'])) {
  header('Location: ../login');
}
include "layout/header.php";

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
<!-- Content Header (Page header) -->

<div class="wrapper">
  <div class="layout">
    <div class="layout-start">
      <div class="start-body">
        <div id="hello" class="" style="display:block">
          <img src="<?= $url ?>dist/img/hello.png" style="width: 100%;">
          <h4>Bienvenido de vuelta</h4>
          <h1>Administrador</h1>
          <div class="moved">
            <button type="button" class="btn-moved">
              <i class="fa-solid fa-face-laugh-beam"></i>
            </button>
          </div>
        </div>
        <div id="profile" style="display:none">
          <div class="profile-top">
            <img src="<?= $url ?>dist/img/userv2.jpg">
            <div class="d-flex flex-column text-left ml-2">
              <p>Brian Tipismana</p>
              <span>Administrador <i class="fa-solid fa-circle ml-2 text-success" style="font-size:7px"></i></span>
            </div>

          </div>
          <ul class="navbar-profile">
            <li>
              <span>
                <i class="fa-solid fa-bars-staggered"></i> </span>
              <button type="button" data-toggle="collapse" data-target="#matriz" aria-expanded="false" aria-controls="">
                Lista de Matrices
              </button>
            </li>
            <li>
              <span>
                <i class="fa-solid fa-hands-holding"></i> </span>
              <button type="button" data-toggle="collapse" data-target="#matriz" aria-expanded="false" aria-controls="">
                Lista de Controles
              </button>
            </li>
            <li>
              <span>
                <i class="fa-solid fa-rectangle-list"></i>
              </span>
              <button type="button" data-toggle="collapse" data-target="#matriz" aria-expanded="false" aria-controls="">
                Lista de Matrices
              </button>
            </li>
          </ul>
          <a href="logout" style="font-size:20px;color: #007CFF">
            <i class="fa-solid fa-right-from-bracket"></i> </a>
        </div>
      </div>
    </div>
    <div class="layout-end pl-5" style="display:none">
      <div style="min-height: 120px;">
        <div class="collapse width" id="matriz">
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
      </div>
    </div>
  </div>
</div>
</div>


<?php include "layout/footer.php"; ?>