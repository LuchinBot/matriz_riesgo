<?php
$url = "http://localhost/matriz_riesgo/";

require('layout/conexion.php');

$stmt = $base->prepare('SELECT * from probabilidad where idmatriz = ? ');
$stmt->execute(array(8));
$rows = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $base->prepare('SELECT * from impacto where idmatriz = ? ');
$stmt->execute(array(8));
$cols = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $base->prepare('SELECT * from levels where idmatriz = ? ');
$stmt->execute(array(8));
$levels = $stmt->fetchAll(PDO::FETCH_OBJ);

echo '<table class="table table-bordered">';

// Encabezado de columnas
echo '<thead><tr><th></th>';
foreach ($cols as $col) {
    echo '<th>' . $col->name_impacto . '</th>';
}
echo '</tr></thead>';

// Contenido de la tabla
echo '<tbody>';
foreach ($rows as $row) {
    echo '<tr>';
    // Encabezado de fila
    echo '<th>' . $row->name_probabilidad . '</th>';
    // Multiplicar los valores de fila y columna y mostrar el resultado
    foreach ($cols as $col) {
        $resultado = $row->value_probabilidad * $col->value_impacto;
        echo '<td class="resultado">' . $resultado . '</td>';
    }
    echo '</tr>';
}
echo '</tbody></table>'; ?>

<script src="<?= $url ?>dist/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
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
    });
</script>

