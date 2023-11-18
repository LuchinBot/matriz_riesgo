<?php
require('../../layout/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Actualizar impactos
    if (isset($_POST['name_event']) && isset($_POST['probabilidad']) && isset($_POST['impacto']) && isset($_POST['nivel'])) {
        $a = $_POST['nivel'];
        $b = $_POST['probabilidad'];
        $c = $_POST['impacto'];
        $d = $_POST['name_event'];


        $stmt = $base->prepare('INSERT INTO events(idlevel,idprobabilidad,idimpacto,name_event) values(?,?,?,?)');
        $stmt->execute(array($a,$b, $c, $d));
    }

    header("Location: ../../matriz");
    exit();
}
