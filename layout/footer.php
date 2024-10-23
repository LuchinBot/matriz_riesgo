</div>
</div>
<!--
<div class="loader-page">
    <i class="fa fa-reload fs-3"></i>
</div>
-->
<script src="<?= $url ?>dist/plugins/popper/popper.min.js"></script>
<script src="<?= $url ?>dist/plugins/bootstrap/bootstrap.min.js"></script>
<script src="<?= $url ?>dist/plugins/jquery/jquery.min.js"></script>
<script src="<?= $url ?>dist/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?= $url ?>dist/plugins/select2/select2.min.js"></script>
<script src="<?= $url ?>dist/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= $url ?>dist/plugins/jquery-validate/jquery.validate.min.js"></script>

<script src="<?= $url ?>dist/js/code.js"></script>
<script src="<?= $url ?>dist/js/login.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $("#validateForm").validate({});
        $('#myTable').DataTable({

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

    });
    $(window).on('load', function() {
        setTimeout(function() {
            $(".loader-page").css({
                visibility: "hidden",
                opacity: "0"
            })
        }, 1000);

    });
</script>
</body>

</html>