<?php
require('../../layout/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Actualizar impactos
    if (isset($_POST['nombre_impacto']) && isset($_POST['valor_impacto']) && isset($_POST['id_impacto'])) {
        $nombres_impacto = $_POST['nombre_impacto'];
        $valores_impacto = $_POST['valor_impacto'];
        $ids_impacto = $_POST['id_impacto'];

        for ($i = 0; $i < count($nombres_impacto); $i++) {
            $stmt = $base->prepare('UPDATE impacto SET name_impacto = ?, value_impacto = ? WHERE idimpacto = ?');
            $stmt->execute(array($nombres_impacto[$i], $valores_impacto[$i], $ids_impacto[$i]));
        }
    }

    // Actualizar probabilidades
    if (isset($_POST['nombre_probabilidad']) && isset($_POST['valor_probabilidad']) && isset($_POST['id_probabilidad'])) {
        $nombres_probabilidad = $_POST['nombre_probabilidad'];
        $valores_probabilidad = $_POST['valor_probabilidad'];
        $ids_probabilidad = $_POST['id_probabilidad'];

        for ($i = 0; $i < count($nombres_probabilidad); $i++) {
            $stmt = $base->prepare('UPDATE probabilidad SET name_probabilidad = ?, value_probabilidad = ? WHERE idprobabilidad = ?');
            $stmt->execute(array($nombres_probabilidad[$i], $valores_probabilidad[$i], $ids_probabilidad[$i]));
        }
    }

      // Actualizar niveles
      if (isset($_POST['min_level'])  && isset($_POST['max_level']) && isset($_POST['id_level'])) {
        $min_levels = $_POST['min_level'];
        $max_levels = $_POST['max_level'];
        $color_levels = $_POST['color_level'];
        $ids_levels = $_POST['id_level'];

        for ($i = 0; $i < count($min_levels); $i++) {
            $stmt = $base->prepare('UPDATE levels SET  min_level = ?,max_level = ?,color_level = ? WHERE idlevel = ?');
            $stmt->execute(array($min_levels[$i],$max_levels[$i],$color_levels[$i], $ids_levels[$i]));
        }
    }

    // Redireccionar a alguna página después de guardar los cambios
    header("Location: ../../matriz");
    exit();
}
?>
