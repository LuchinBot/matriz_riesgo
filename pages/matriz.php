<?php

session_start();
$id = "";
if (!isset($_SESSION['user'])) {
  header('Location: ../login');
}
$title_navbar = "Matriz de Riesgo";
include "../layout/header.php";
?>

<div class="col">
  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h5><?= $title_navbar ?></h5>
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
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Controles</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="gradeX">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "../layout/footer.php"; ?>