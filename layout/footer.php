<div class="footer">
    <div class="float-right">
        Tarapoto - <strong>Perú</strong>
    </div>
    <div>
        Área de Tecnologías de la Información &copy; 2023
    </div>
</div>
</div>
</div>

<!-- Mainly scripts -->
<script src="<?= $url ?>js/jquery-3.1.1.min.js"></script>
<script src="<?= $url ?>js/popper.min.js"></script>
<script src="<?= $url ?>js/bootstrap.js"></script>
<script src="<?= $url ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= $url ?>js/plugins/dataTables/datatables.min.js"></script>
<script src="<?= $url ?>js/inspinia.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- Page-Level Scripts -->
<script>
    // Upgrade button class name
    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-white btn-sm';

    $(document).ready(function() {
        $('.dataTables-example').DataTable({
            "language": {
                "sEmptyTable": "No hay datos disponibles en la tabla",
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing": "Procesando...",
                "sSearch": "Buscar:",
                "sZeroRecords": "No se encontraron registros coincidentes",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": activar para ordenar la columna en orden ascendente",
                    "sSortDescending": ": activar para ordenar la columna en orden descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });

        //otros

        var tabla = $('.dataTables-example').DataTable();

        // Manejar el evento de cambio para el selector de opciones
        $('#filtroColumna1').on('change', function() {
            var filtroValor = $(this).val();
            tabla.column(0).search(filtroValor).draw();
        });

    });

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>

</body>

</html>