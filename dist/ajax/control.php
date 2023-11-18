<?php
require('../../layout/conexion.php');
$url = "http://localhost/matriz_riesgo/";

if (isset($_GET['id'])) {

    //Listado
    $stmt = $base->prepare('SELECT * from control_iso where idcontrol_iso= ?');
    $control = $stmt->execute(array($_GET['id']));
    $control = $stmt->fetch(PDO::FETCH_ASSOC);

?>

    <form method="post" id="validateForm">
        <fieldset>
            <div class="modal-body">
                <input type="text" name="idcontrol" value="<?= $control['idcontrol_iso'] ?>" hidden>
                <div class="form-group mb-3">
                    <label for="floatTitle">Correlativo</label>
                    <input type="text" name="correlativo" maxlength="10" class="form-control" id="floatTitle" value="<?= $control['correlativo'] ?>" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="floatTitle2">Control</label>
                    <input type="text" name="name" class="form-control" maxlength="255" id="floatTitle2" value="<?= $control['name_control'] ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" control-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="editControl" class="btn btn-primary">Actualizar</button>
            </div>
        </fieldset>
    </form>

<?php } ?>
