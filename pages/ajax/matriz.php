<?php
require('C:\laragon\www\matriz_riesgo\mysql\conexion.php');

$id = $_GET['id'];
$stmt = $base->prepare('select * from matriz where codigo = ? ');
$data = $stmt->execute(array($id));
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $base->prepare('select * from controles_iso ');
$c = $stmt->execute();
$c = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $base->prepare('select ma.codigo as codigo_matriz, coni.descripcion as descripcion_control from controles_matriz as con inner join
                        matriz as ma on(ma.codigo=con.codigo_matriz) inner join
                        controles_iso as coni on(coni.codigo=con.codigo_control_iso_1 and coni.codigo_ref=con.codigo_control_iso_2) where ma.codigo = ?');
$mc = $stmt->execute(array($id));
$mc = $stmt->fetchAll(PDO::FETCH_OBJ);

if ($id!=0) {
    echo '
    <div class="form-group">
    <label for="recipient-name" class="col-form-label">Titulo</label>
    <input type="text" class="form-control" name="titulo" value="' . $data["titulo"] . '" id="recipient-name">
    </div>
    <div class="form-group">
    <label for="message-text" class="col-form-label">Descripción</label>
    <textarea class="form-control" name="descripcion" id="message-text">' . $data["descripcion"] . '</textarea>
    </div>
    ';
    echo '
    <div class="form-group">
    <label for="message-text" class="col-form-label">Todos los controles</label><br>
    <div class="d-flex">
    <select class="select2" style="width: 90% !important;" name="states[]" multiple="multiple">';
    foreach ($c as $c1) {
        echo '<option value="' . $c1->codigo . '">' . $c1->descripcion . '</option>';
    }
    echo '
    </select>
    <button type="button" class="ml-2 border-0 bg-success" style="width: 30px; height: 30px; border-radius:50px"><i class="fa fa-plus"></i></button>
    </div>
    </div>
    ';

}
