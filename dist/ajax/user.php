<?php
require('../../layout/conexion.php');
$url = "http://localhost/matriz_riesgo/";

if (isset($_GET['id'])) {

    //Listado
    $stmt = $base->prepare('SELECT * from user where iduser= ?');
    $user = $stmt->execute(array($_GET['id']));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $base->prepare('SELECT * from profiles');
    $profiles = $stmt->execute();
    $profiles = $stmt->fetchAll(PDO::FETCH_OBJ);

?>
    <form method="post" id="validateForm">
        <fieldset>
            <div class="modal-body">
                <input type="text" name="iduser" value="<?= $user['iduser'] ?>" hidden>
                <div class="form-group">
                    <label>Perfiles</label>
                    <select class="select2" name="profile" style="width: 100%;" required title="Campo requerido">
                        <?php foreach ($profiles as $i) :
                            if ($user['idprofile'] == $i->idprofile) { ?>
                                <option selected value="<?= $i->idprofile ?>"><?= $i->name ?></option>
                            <?php } else { ?>
                                <option value="<?= $i->idprofile ?>"><?= $i->name ?></option>
                        <?php }
                        endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="floatTitle1">Nombres</label>
                    <input type="text" name="firstname" id="floatTitle1" class="form-control" value="<?= $user['firstname'] ?>" placeholder="Jharold" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="floatTitle2">Apellidos</label>
                    <input type="text" name="lastname" id="floatTitle2" class="form-control" value="<?= $user['lastname'] ?>" placeholder="Pinedo" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="floatTitle3">Usuario</label>
                    <input type="text" name="username" id="floatTitle3" class="form-control" value="<?= $user['username'] ?>" placeholder="jharilto" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="floatTitle4">Cambiar contraseña</label>
                    <input type="text" name="key" id="floatTitle4" class="form-control" value="" placeholder="*********" autocomplete="off">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" control-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="editUsuario" class="btn btn-primary">Actualizar</button>
            </div>
        </fieldset>
    </form>
    <script src="<?= $url ?>dist/plugins/select2/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>


<?php }
if (isset($_GET['delete'])) {

    //Listado
    $stmt = $base->prepare('DELETE FROM user where iduser = ?');
    $data = $stmt->execute(array($_GET['delete']));
    echo '<script>window.location.href = "' . $url . 'usuarios";</script>';
} ?>