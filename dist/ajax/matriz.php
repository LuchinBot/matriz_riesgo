<?php
require('../../layout/conexion.php');
$url = "http://localhost/matriz_riesgo/";

if (isset($_GET['id'])) {

    //Listado
    $stmt = $base->prepare('SELECT * from matriz where idmatriz = ?');
    $data = $stmt->execute(array($_GET['id']));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $base->prepare('SELECT * from dimension where state_dimension= 1 ');
    $dimension = $stmt->execute();
    $dimension = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

    <form method="post" id="validateForm">
        <fieldset>
            <div class="modal-body">
                <input type="text" name="idmatriz" value="<?= $data['idmatriz'] ?>" hidden>
                <div class="form-group mb-3">
                    <label for="floatTitle">Titulo</label>
                    <input type="text" name="titulo_matriz" class="form-control" id="floatTitle" value="<?= $data['title_matriz'] ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="floatDescripcion">Descripción</label>
                    <textarea class="form-control" name="descripcion_matriz" id="floatDescripcion" autocomplete="off" required><?= $data['text_matriz'] ?></textarea>
                </div>
                <?php if ($data['generate_matriz'] == 0) { ?>
                    <div class="form-group">
                        <label>Dimensión</label>
                        <select class="select2" name="iddimension" style="width: 100%;" required title="Campo requerido">
                            <?php foreach ($dimension as $i) :
                                if ($data['iddimension'] == $i->iddimension) { ?>
                                    <option selected value="<?= $i->iddimension ?>"><?= $i->name_dimension ?></option>
                                <?php } else { ?>
                                    <option value="<?= $i->iddimension ?>"><?= $i->name_dimension ?></option>
                            <?php }
                            endforeach; ?>
                        </select>
                    </div>
                <?php } else { ?>
                    <div class="border rounded p-2 bg-success text-white fw-bolder d-flex justify-content-center text-uppercase">La matriz está generada</div>
                    <input type="text" name="iddimension" value="<?= $data['iddimension'] ?>" hidden>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="editMatriz" class="btn btn-primary">Actualizar</button>
            </div>
        </fieldset>
    </form>

<?php }

if (isset($_GET['generate'])) {

    //Obtenemos las filas y columnas
    $stmt = $base->prepare('SELECT * from matriz as m inner join dimension as d on(d.iddimension = m.iddimension) where m.idmatriz = ? ');
    $dimension = $stmt->execute(array($_GET['generate']));
    $dimension = $stmt->fetch(PDO::FETCH_ASSOC);

    //filas
    for ($i = 0; $i < $dimension['row_dimension']; $i++) {
        $stmt = $base->prepare('INSERT INTO probabilidad (idmatriz) VALUES (?)');
        $result = $stmt->execute(array($dimension['idmatriz']));
    }
    //columnas
    for ($i = 0; $i < $dimension['col_dimension']; $i++) {
        $stmt = $base->prepare('INSERT INTO impacto (idmatriz) VALUES (?)');
        $result = $stmt->execute(array($dimension['idmatriz']));
    }

    //niveles
    $nivelesRiesgo = array(
        "Bajo" => "Riesgo Bajo",
        "Moderado" => "Riesgo Moderado",
        "Alto" => "Riesgo Alto",
        "Crítico" => "Riesgo Crítico"
    );

    $valoresNiveles = array_values($nivelesRiesgo);

    for ($i = 0; $i < count($valoresNiveles); $i++) {
        $stmt = $base->prepare('INSERT INTO levels (idmatriz, name_level) VALUES (?, ?)');
        $result = $stmt->execute(array($_GET['generate'], $valoresNiveles[$i]));
    }

    //Actualizamos el estado de generacion
    $stmt = $base->prepare('UPDATE matriz set generate_matriz = 1 where idmatriz = ?');
    $data = $stmt->execute(array($_GET['generate']));
}
if (isset($_GET['delete'])) {

    //Listado
    $stmt = $base->prepare('DELETE FROM matriz where idmatriz = ?');
    $data = $stmt->execute(array($_GET['delete']));
    echo '<script>window.location.href = "' . $url . 'matriz";</script>';
}

if (isset($_GET['view'])) {
    $stmt = $base->prepare('SELECT * from probabilidad where idmatriz = ? ');
    $stmt->execute(array($_GET['view']));
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $base->prepare('SELECT * from impacto where idmatriz = ? ');
    $stmt->execute(array($_GET['view']));
    $cols = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $base->prepare('SELECT * from levels where idmatriz = ? ');
    $stmt->execute(array($_GET['view']));
    $levels = $stmt->fetchAll(PDO::FETCH_OBJ);


?>
    <form method="post" action="dist/ajax/save_matriz" class="valores_matriz">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-center text-secondary text-uppercase fw-bold">Probabilidades</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="fw-light text-center">Nombre</th>
                            <th class="fw-light text-center">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $probabilidad) : ?>
                            <tr>
                                <td>
                                    <input type="text" minlength="4" name="nombre_probabilidad[]" required class="w-100" value="<?php echo $probabilidad->name_probabilidad; ?>">
                                    <input type="hidden" name="id_probabilidad[]" value="<?php echo $probabilidad->idprobabilidad; ?>">
                                </td>
                                <td style="width: 25%;">
                                    <input type="number" min="1" name="valor_probabilidad[]" required class="w-100" value="<?php echo $probabilidad->value_probabilidad; ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="text-center text-secondary text-uppercase fw-bold">Impactos</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="fw-light text-center">Nombre</th>
                            <th class="fw-light text-center">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cols as $impacto) : ?>
                            <tr>
                                <td>
                                    <input type="text" minlength="4" name="nombre_impacto[]" required class="w-100" value="<?php echo $impacto->name_impacto; ?>">
                                    <input type="hidden" name="id_impacto[]" value="<?php echo $impacto->idimpacto; ?>">
                                </td>
                                <td style="width: 25%;">
                                    <input type="number" min="1" name="valor_impacto[]" required class="w-100" value="<?php echo $impacto->value_impacto; ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center border-bottom mb-4">
            <p class="text-start fw-light text-secondary"><i class="fa-solid fa-circle-info text-danger"></i> Rellena todo los valores para poder calcular el mínimo y máximo</p>
            <p class="btn bg-success mb-4 fw-bold calcularMinMaxBtn">Calcular</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6 class="text-center text-secondary text-uppercase fw-bold">Niveles de riesgo</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="fw-light text-center">Nombre</th>
                            <th class="fw-light text-center">Mínimo</th>
                            <th class="fw-light text-center">Máximo</th>
                            <th class="fw-light text-center">Color</th>
                        </tr>
                    </thead>
                    <tbody class="niveles">
                        <?php foreach ($levels as $level) : ?>
                            <tr>
                                <td>
                                    <p class="text-center fw-bolder text-secondary"><?php echo $level->name_level; ?></p>
                                    <input type="hidden" name="id_level[]" value="<?php echo $level->idlevel; ?>">
                                </td>
                                <td style="width: 20%;">
                                    <input type="number" min="1" name="min_level[]" required class="w-100" value="<?php echo $level->min_level; ?>">
                                </td>
                                <td style="width: 20%;">
                                    <input type="number" min="1" name="max_level[]" required class="w-100" value="<?php echo $level->max_level; ?>">
                                </td>
                                <td>
                                    <input type="color" name="color_level[]" required class="w-100" value="<?php echo $level->color_level; ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn bg-success mb-4 fw-bold">Guardar cambios</button>
        </div>

    </form>
<?php }
if (isset($_GET['matriz'])) {
    $stmt = $base->prepare('SELECT * from probabilidad where idmatriz = ? order by value_probabilidad desc');
    $stmt->execute(array($_GET['matriz']));
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $base->prepare('SELECT * from impacto where idmatriz = ? order by value_impacto asc');
    $stmt->execute(array($_GET['matriz']));
    $cols = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $base->prepare('SELECT * from levels where idmatriz = ? ');
    $stmt->execute(array($_GET['matriz']));
    $levels = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo '<table class="table table-bordered">';

    // Encabezado de columnas
    echo '<thead><tr><th class="text-center fw-bold"><i class="fa-solid fa-xmark"></i></th>';
    foreach ($cols as $col) {
        echo '<th class="text-center">' . $col->name_impacto . '</th>';
    }
    echo '</tr></thead>';

    // Contenido de la tabla
    echo '<tbody>';
    foreach ($rows as $row) {
        echo '<tr>';
        // Encabezado de fila
        echo '<th class="text-center">' . $row->name_probabilidad . '</th>';
        // Multiplicar los valores de fila y columna y mostrar el resultado
        foreach ($cols as $col) {
            $resultado = $row->value_probabilidad * $col->value_impacto;
            echo '<td class="resultado text-center text-white">' . $resultado . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
?>
    <form method="post" action="dist/ajax/save_events">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center fw-bold">Evento</th>
                    <th class="text-center fw-bold">Probabilidad</th>
                    <th class="text-center fw-bold">Impacto</th>
                    <th></th>
                    <th class="text-center fw-bold">Riesgo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" required name="name_event" class="form-control" placeholder="Incendio forestal">
                    </td>
                    <td>
                        <select class="form-control probabilidad_event" name="probabilidad">
                            <?php foreach ($rows as $row) { ?>
                                <option value="<?= $row->idprobabilidad ?>" id="<?= $row->value_probabilidad ?>">
                                    <?= $row->name_probabilidad ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control impacto_event" name="impacto">
                            <?php foreach ($cols as $col) { ?>
                                <option value="<?= $col->idimpacto ?>" id="<?= $col->value_impacto ?>">
                                    <?= $col->name_impacto ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn bg-success calcular-riesgo"><i class="fa-solid fa-equals"></i></button>
                    </td>
                    <td>
                        <input type="text" required readonly name="result_event" class="form-control text-center fw-bold text-white" placeholder="Bajo">
                        <input type="hidden" name="nivel">
                    </td>
                    <td>
                        <button type="submit" class="btn bg-primary subir-evento"><i class="fa-solid fa-cloud-arrow-up"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>

    </form>

    <script>
        $(document).ready(function() {
            //Colorear matriz
            var nivelesRiesgo = <?php echo json_encode($levels); ?>;

            $('table tbody td.resultado').each(function() {
                var resultado = parseFloat($(this).text());
                if (!isNaN(resultado)) {
                    for (var i = 0; i < nivelesRiesgo.length; i++) {
                        if (resultado >= nivelesRiesgo[i].min_level && resultado <= nivelesRiesgo[i].max_level) {
                            $(this).css('background-color', nivelesRiesgo[i].color_level);
                            break;
                        }
                    }
                }
            });

            $('.subir-evento').attr('disabled', true);
            var probabilidad = 0;
            var impacto = 0;
            $('.calcular-riesgo').on('click', function() {
                $('.probabilidad_event').each(function() {
                    var selectedOption = $(this).children('option:selected');
                    probabilidad = selectedOption.attr('id');

                });
                $('.impacto_event').each(function() {
                    var selectedOption = $(this).children('option:selected');
                    impacto = selectedOption.attr('id');
                });
                console.log(impacto);
                if (probabilidad != '' && impacto != '') {
                    $('.subir-evento').attr('disabled', false);
                    if (!isNaN(probabilidad) && !isNaN(impacto)) {
                        var resultado = probabilidad * impacto;

                        // Eliminamos el color de fondo antes de asignar uno nuevo
                        $('input[name="result_event"]').css('background-color', '');

                        // Colorear el resultado según los niveles de riesgo
                        for (var i = 0; i < nivelesRiesgo.length; i++) {
                            if (resultado >= nivelesRiesgo[i].min_level && resultado <= nivelesRiesgo[i].max_level) {
                                $('input[name="result_event"]').val(nivelesRiesgo[i].name_level);
                                $('input[name="nivel"]').val(nivelesRiesgo[i].idlevel);
                                $('input[name="result_event"]').css('background-color', nivelesRiesgo[i].color_level);
                                break;
                                console.log(nivelesRiesgo[i].idlevel);
                            }
                        }
                    }
                }

            });

        });
    </script>
<?php
}
?>

<!--JS-->

<script src="<?= $url ?>dist/plugins/select2/select2.min.js"></script>

<script>
    $(document).ready(function() {

        $('.select2').select2();
        //$('.niveles :input').prop('disabled', true);

        $('.calcularMinMaxBtn').on('click', function() {
            var valoresMultiplicados = [];
            var minimo = 0;
            var maximo = 0;

            // Obtener valores de probabilidad e impacto
            var valoresProbabilidad = $('input[name="valor_probabilidad[]"]').map(function() {
                return parseFloat($(this).val()) || 0;
            }).get();

            var valoresImpacto = $('input[name="valor_impacto[]"]').map(function() {
                return parseFloat($(this).val()) || 0;
            }).get();

            console.log(valoresProbabilidad);
            console.log(valoresImpacto);

            if (valoresProbabilidad.length > valoresImpacto.length) {
                // Calcular el producto de probabilidad e impacto
                for (var i = 0; i < valoresProbabilidad.length; i++) {
                    for (var j = 0; j < valoresImpacto.length; j++) {
                        var resultadoMultiplicacion = valoresProbabilidad[i] * valoresImpacto[j];
                        valoresMultiplicados.push(resultadoMultiplicacion);
                    }
                }
            } else {
                for (var i = 0; i < valoresImpacto.length; i++) {
                    for (var j = 0; j < valoresProbabilidad.length; j++) {
                        var resultadoMultiplicacion = valoresProbabilidad[j] * valoresImpacto[i];
                        valoresMultiplicados.push(resultadoMultiplicacion);
                    }
                }
            }

            // Eliminar valores cero del array
            var valoresNoCero = valoresMultiplicados.filter(function(valor) {
                return valor !== 0;
            });

            // Calcular el mínimo y el máximo
            minimo = Math.min(...valoresNoCero);
            maximo = Math.max(...valoresNoCero);

            // Mostrar resultados
            if (valoresNoCero.length > 0) {
                console.log('Mínimo:', minimo);
                console.log('Máximo:', maximo);
                $('.niveles :input').prop('disabled', false);
                $('input[name="min_level[]"]').val(minimo);
                $('input[name="max_level[]"]').val(maximo);
            } else {
                console.log('Todos los valores deben ser mayores a cero.');
                $('.niveles :input').prop('disabled', true);

            }
        });

    });
</script>