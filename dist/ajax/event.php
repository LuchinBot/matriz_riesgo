<?php
require('../../layout/conexion.php');
$url = "http://localhost/matriz_riesgo/";

if (isset($_GET['id'])) {

    //Listado
    $stmt = $base->prepare('SELECT * from events as e inner join levels as l on(l.idlevel = e.idlevel)
    inner join probabilidad as p on(p.idprobabilidad = e.idprobabilidad) inner join impacto as i on(i.idimpacto=e.idimpacto)
    left join matriz as m on(m.idmatriz = i.idmatriz) where e.idevent = ?');
    $event = $stmt->execute(array($_GET['id']));
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $base->prepare('SELECT * from control_iso where state_control= 1 ');
    $control = $stmt->execute();
    $control = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $base->prepare('SELECT * from control_event where idevent=? ');
    $control_event = $stmt->execute(array($_GET['id']));
    $control_event = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

    <form method="post" id="validateForm">
        <fieldset>
            <div class="modal-body">
                <input type="text" name="idmatriz" value="<?= $event['idmatriz'] ?>" hidden>
                <input type="text" name="idevent" value="<?= $event['idevent'] ?>" hidden>
                <div class="form-group mb-3">
                    <label for="floatTitle">Evento</label>
                    <input type="text" readonly class="form-control" id="floatTitle" value="<?= $event['name_event'] ?>" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="floatTitle2">Nivel de Riesgo</label>
                    <input type="text" name="nivel" readonly class="form-control" id="floatTitle2" value="<?= $event['name_level'] ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>Controles</label>
                    <select class="js-example-basic-multiple" name="idcontrol[]" multiple="multiple" style="width: 100%; overflow:hidden" required title="Campo requerido">
                        <?php foreach ($control as $i) : ?>
                            <?php $selected = false; ?>
                            <?php foreach ($control_event as $j) :
                                if ($j->idcontrol === $i->idcontrol_iso) {
                                    $selected = true;
                                    break;
                                }
                            endforeach; ?>

                            <option <?= ($selected) ? 'selected' : ''; ?> value="<?= $i->idcontrol_iso ?>"><?= $i->correlativo.' - '.$i->name_control ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" event-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="addControl" class="btn btn-primary">Actualizar</button>
            </div>
        </fieldset>
    </form>

<?php } ?>

<script src="<?= $url ?>dist/plugins/select2/select2.min.js"></script>

<script>
    $(document).ready(function() {

        $('.js-example-basic-multiple').select2();
    });
</script>