<?php

session_start();
$id = "";
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sitio web para conocer sobre las matrices de riesgo">
  <meta name="keywords" content="Matriz de riesgo, Matrices">
  <meta name="author" content="Luis José Hidalgo Rodríguez y Roy Ruiz García">
  <meta name="robots" content="index, follow">
  <title>Matriz de Riesgo</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    #centrado {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 1200px;
      background-color: #F2F2F2;
      box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
    }

    .bg-gris {
      background: #585858;
    }

    @font-face {
      font-family: 'adineue PRO Cyr Bold';
      src: url('fonts/adineuePROCyr-BoldWeb.eot');
      src: url('fonts/adineuePROCyr-BoldWeb.eot?#iefix') format('embedded-opentype'),
        url('fonts/adineuePROCyr-BoldWeb.woff') format('woff'),
        url('fonts/adineuePROCyr-BoldWeb.ttf') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    * {
      font-family: 'adineue PRO Cyr bold';
    }

    #cuadro td {
      color: #FFF;
    }

    #resultados {
      overflow-y: scroll;
      max-height: 100px;
      scroll-margin-inline-end: end;
    }

    .niveles {
      width: 120px;
    }

    .nivel {
      width: 30px;
      height: 30px;
    }

    .aceptable {
      background-color: #01DF01;
    }

    .tolerable {
      background-color: #AEB404;
    }

    .alto {
      background-color: #FF4000;
    }

    .extremo {
      background-color: #B40404;
    }

    .xyz {
      width: 50px;
      margin: auto;
      display: flex;
    }

    .n-riesgo {
      text-align: center;
    }

    .xyz::-webkit-outer-spin-button,
    .xyz::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .n-riesgo::-webkit-outer-spin-button,
    .n-riesgo::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    @media (max-width:768px) {
      .main {
        width: 100%;
        display: flex;
        flex-direction: column !important;
      }

      .main .col-8 {
        width: 100% !important;
      }

      .main .col-4 {
        width: 100% !important;
      }

      #centrado {
        position: relative;
        width: 100% !important;
        left: 0%;
        top: 0%;
        transform: translate(0);
      }

      table {
        width: 100%;
      }

      .n-riesgo {
        width: 65px !important;
      }

      #ultimo {
        flex-direction: column !important;
      }
    }
  </style>
</head>

<body style="font-size: 12px">
  <div id="centrado" class="p-5 rounded">
    <h4 class="text-center text-secondary">MATRIZ DE RIESGO CON HTML, CSS Y JQUERY</h4>
    <br>
    <div class="row" id="main">
      <!--Matriz-->
      <div class="col-lg-8">
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="cuadro" style="font-size: 12px">
            <thead>
              <tr>
                <th colspan="2" class="border"></th>
                <th colspan="5" class="bg-gris text-white">CONSECUENCIA</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th colspan="2" class="border"></th>
                <th class="bg-gris text-white">Mínima</th>
                <th class="bg-gris text-white">Menor</th>
                <th class="bg-gris text-white">Moderada</th>
                <th class="bg-gris text-white">Mayor</th>
                <th class="bg-gris text-white">Máxima</th>
              </tr>
              <tr>
                <th colspan="2" class="bg-gris text-white">PROBABILIDAD</th>
                <th class="bg-gris text-white"><input type="number" id="c1" class="form-control xyz" maxlength="2" autofocus></th>
                <th class="bg-gris text-white"><input type="number" id="c2" class="form-control xyz" maxlength="2" readonly></th>
                <th class="bg-gris text-white"><input type="number" id="c3" class="form-control xyz" maxlength="2" readonly></th>
                <th class="bg-gris text-white"><input type="number" id="c4" class="form-control xyz" maxlength="2" readonly></th>
                <th class="bg-gris text-white"><input type="number" id="c5" class="form-control xyz" maxlength="2" readonly></th>
                <th class="bg-gris text-white"><button class="btn" id="limpiarx">✍</button></th>
              </tr>
              <tr class="bg-secondary">
                <th class="bg-gris text-white">Muy alta</th>
                <th class="bg-gris text-white"><input type="number" id="p1" class="form-control xyz" readonly></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr class="bg-secondary">
                <th class="bg-gris text-white">Alta</th>
                <th class="bg-gris text-white"><input type="number" id="p2" class="form-control xyz" readonly></th>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
              </tr>
              <tr class="bg-secondary">
                <th class="bg-gris text-white">Media</th>
                <th class="bg-gris text-white"><input type="number" id="p3" class="form-control xyz" readonly></th>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
              </tr>
              <tr class="bg-secondary">
                <th class="bg-gris text-white">Baja</th>
                <th class="bg-gris text-white"><input type="number" id="p4" class="form-control xyz" readonly></th>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
              </tr>
              <tr class="bg-secondary">
                <th class="bg-gris text-white">Muy Baja</th>
                <th class="bg-gris text-white"><input type="number" id="p5" class="form-control xyz" readonly></th>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
              </tr>
              <tr class="">
                <th class="text-white"></th>
                <th class="bg-gris text-white"><button class="btn" id="limpiary">✍</button></th>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
                <td id=""></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!--Parámetros y botones-->
      <div class="col-lg-4">
        <div class="mt-3">
          <h6 class="text-center text-secondary">ESCALAS</h6>
          <hr>
          <div class="form-inline mt-2">
            <div class="d-flex niveles">
              <span class="nivel aceptable"></span>
              <label class="mx-2">Aceptable: </label>
            </div>
            <label>De</label>
            <input type="number" class="form-control mx-2 n-riesgo" style="width: 80px;" id="ac1">
            <label>A</label>
            <input type="number" class="form-control mx-2 n-riesgo" style="width: 80px;" id="ac2">
          </div>
          <div class="form-inline mt-2">
            <div class="d-flex niveles">
              <span class="nivel tolerable"></span>
              <label class="mx-2">Tolerable: </label>
            </div>
            <label>De</label>
            <input type="number" class="form-control mx-2 n-riesgo" style="width: 80px;" id="to1">
            <label>A</label>
            <input type="number" class="form-control mx-2 n-riesgo" style="width: 80px;" id="to2">
          </div>
          <div class="form-inline mt-2">
            <div class="d-flex niveles">
              <span class="nivel alto"></span>
              <label class="mx-2">Alto: </label>
            </div>
            <label>De</label>
            <input type="number" class="form-control mx-2 n-riesgo" style="width: 80px;" id="al1">
            <label>A</label>
            <input type="number" class="form-control mx-2 n-riesgo" style="width: 80px;" id="al2">
          </div>
          <div class="form-inline mt-2">
            <div class="d-flex niveles">
              <span class="nivel extremo"></span>
              <label class="mx-2">Extremo: </label>
            </div>
            <label>De</label>
            <input type="number" class="form-control mx-2 n-riesgo" style="width: 80px;" id="ex1">
            <label>A</label>
            <input type="number" class="form-control mx-2 n-riesgo" style="width: 80px;" id="ex2">
          </div>
        </div>
        <button class="btn text-white bg-primary w-100 my-2" id="asignar_parametros" disabled>Pintar Matriz</button>
        <button class="btn text-white bg-dark w-100" id="calcular_matriz" disabled style="opacity:0">Calcular Matriz</button>
      </div>
    </div>

    <div class="col-lg-12 my-3">
      <div class="d-flex text-center" id="ultimo">
        <div class="form-control border-0 border-top">
          <label class="my-2 mx-3">Evento</label>
          <input type="text" class="form-control text-center" id="evento" value="">
        </div>
        <div class="form-control border-0 border-top">
          <label class="my-2 mx-3"> Probabilidad</label>
          <select class="form-control" id="probs">
            <option selected value="0">Elejir</option>
            <option id="probs1">Muy Alta</option>
            <option id="probs2">Alta</option>
            <option id="probs3">Media</option>
            <option id="probs4">Baja</option>
            <option id="probs5">Muy Baja</option>
          </select>
        </div>
        <div class="form-control border-0 border-top">
          <label class="my-2 mx-3"> Consecuencia</label>
          <select class="form-control" id="cons">
            <option selected value="0">Elejir</option>
            <option id="cons1">Mínima</option>
            <option id="cons2">Menor</option>
            <option id="cons3">Moderada</option>
            <option id="cons4">Mayor</option>
            <option id="cons5">Máxima</option>
          </select>
        </div>
        <div class="form-control border-0 border-top">
          <label class="my-2 mx-3"> Nivel de Riesgo</label>
          <div class="d-flex">
            <button class="btn border btn-success" id="operacion" disabled>=</button>
            <input type="text" disabled class="form-control text-center" id="riesgo" placeholder="---">
          </div>
        </div>
      </div>

    </div>
    <!--Mostrar Resultados-->
    <div class="col">
      <span id="mi-elemento"></span>

      <p class="text-secondary">Historial - <span id="borrar" class="text-danger" style="cursor:pointer">Borrar</span>: </p>
      <hr>
      <div id="resultados" class="text-secondary font-italic">
        <!--....-->
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="code.js"></script>
</body>

</html>