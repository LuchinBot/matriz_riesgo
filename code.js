$(document).ready(function () {
    var id = 1;
    var riesgo = "";
    var color = "";
    var datosTemporales;
    $('#obtener').hide();

    $('#operacion').on('click', function () {

        var evento = $('#evento').val();
        var probs = $('#probs').val();
        var cons = $('#cons').val();
        var datosTemporales = $('#mi-elemento').data('datos-temporales');

        // Accedemos a los valores individuales
        var valor1 = datosTemporales.rac1;
        var valor2 = datosTemporales.rac2;
        var valor3 = datosTemporales.rto1;
        var valor4 = datosTemporales.rto2;
        var valor5 = datosTemporales.ral1;
        var valor6 = datosTemporales.ral2;
        var valor7 = datosTemporales.rex1;
        var valor8 = datosTemporales.rex2;

        if (probs != 0 && cons != 0) {
            //calculo de nivel de riesgo
            var res = probs * cons;
            if (res >= valor1 && res <= valor2) {
                riesgo = "Aceptable";
                color = "#01DF01"
            } else if (res >= valor3 && res <= valor4) {
                riesgo = "Tolerable";
                color = "#AEB404"
            } else if (res >= valor5 && res <= valor6) {
                riesgo = "Alto";
                color = "#FF4000"
            } else if (res >= valor7 && res <= valor8) {
                riesgo = "Extremo";
                color = "#B40404"
            }

            //RESULTADO
            $('#riesgo').val(riesgo);
            $('#riesgo').css({
                'background': color,
                'color': '#FFF'
            });
            $('#resultados').prepend(id + '. ' + evento + ' con una Probabilidad ' + probs + ' y una Consecuencia ' + cons + ' tiene un nivel de <b>[ Riesgo ' + riesgo + ' ]</b><br>');
            id = id + 1;
        }
    });
    $('#borrar').on('click', function () {
        $('#resultados').html('');
    });


    //PROCESOS DE LLENADO DE MATRIZ
    $('#calcular_matriz').on('click', function () {
        var valoresp = [];
        var valoresc = [];
        var repetidosp = false;
        var repetidosc = false;

        $('#p1, #p2, #p3, #p4, #p5').each(function () {
            var valor = $(this).val();
            if ($.inArray(valor, valoresp) !== -1) {
                repetidosp = true;
                return false;
            }
            valoresp.push(valor);
        });
        $('#c1, #c2, #c3, #c4, #c5').each(function () {
            var valor = $(this).val();
            if ($.inArray(valor, valoresc) !== -1) {
                repetidosc = true;
                return false;
            }
            valoresc.push(valor);
        });

        if (repetidosp == true && repetidosc == true) {
            alert('Los valores ingresados deben ser diferentes entre sí');
        } else {
            var con1 = 1;
            var con2 = 1;
            var con3 = 1;
            var con4 = 1;
            for (var i = 1; i < 27; i++) {
                var p = 0;
                var c = 0;
                if (i <= 5) {
                    p = $('#p1').val();
                    c = $('#c' + i).val();
                    var producto = p * c;
                    //C1
                    var fila = $('tbody tr').eq(2);
                    var td = fila.find('td').eq(i - 1);
                    $(td).text(producto);
                    $('#probs1').val(p);
                    $('#cons1').val($('#c1').val());
                } else if (i > 5 && i < 11) {
                    p = $('#p2').val();
                    c = $('#c' + con1).val();
                    var producto = p * c;
                    //C2
                    var fila = $('tbody tr').eq(3);
                    var td = fila.find('td').eq(i - 6);
                    $(td).text(producto);
                    con1 = con1 + 1;
                    $('#probs2').val(p);
                    $('#cons2').val($('#c2').val());
                } else if (i > 10 && i < 16) {
                    p = $('#p3').val();
                    c = $('#c' + con2).val();
                    var producto = p * c;
                    //C3
                    var fila = $('tbody tr').eq(4);
                    var td = fila.find('td').eq(i - 11);
                    $(td).text(producto);
                    con2 = con2 + 1;
                    $('#probs3').val(p);
                    $('#cons3').val($('#c3').val());
                } else if (i > 15 && i < 21) {
                    p = $('#p4').val();
                    c = $('#c' + con3).val();
                    var producto = p * c;
                    //C4
                    var fila = $('tbody tr').eq(5);
                    var td = fila.find('td').eq(i - 16);
                    $(td).text(producto);
                    con3 = con3 + 1;
                    $('#probs4').val(p);
                    $('#cons4').val($('#c4').val());
                } else if (i > 20 && i < 26) {
                    p = $('#p5').val();
                    c = $('#c' + con4).val();
                    var producto = p * c;
                    //C5
                    var fila = $('tbody tr').eq(6);
                    var td = fila.find('td').eq(i - 21);
                    $(td).text(producto);
                    con4 = con4 + 1;
                    $('#probs5').val(p);
                    $('#cons5').val($('#c5').val());
                }
            }
            var inputsVacios = $('.xyz').filter(function () {
                return $(this).val() !== '';
            });
            if (inputsVacios.length === $('.xyz').length) {
                $('#asignar_parametros').prop("disabled", false);
            }
        }

    });

    //PROCESO DE PINTADO DE ACUERDO A LOS PARAMETROS
    $('#asignar_parametros').click(function () {
        var ac1 = $('#ac1').val();
        var ac2 = $('#ac2').val();
        var to1 = $('#to1').val();
        var to2 = $('#to2').val();
        var al1 = $('#al1').val();
        var al2 = $('#al2').val();
        var ex1 = $('#ex1').val();
        var ex2 = $('#ex2').val();

        //condicionar si las escalas estan bien
        for (var i = 0; i < 5; i++) {
            for (var e = 0; e < 5; e++) {
                var fila = $('tbody tr').eq(2 + i);
                var td = fila.find('td').eq(e);
                if (parseInt(td.text()) >= ac1 && parseInt(td.text()) <= ac2) {
                    td.css('background', '#01DF01');
                } else if (parseInt(td.text()) >= to1 && parseInt(td.text()) <= to2) {
                    td.css('background', '#AEB404');
                } else if (parseInt(td.text()) >= al1 && parseInt(td.text()) <= al2) {
                    td.css('background', '#FF4000');
                } else if (parseInt(td.text()) >= ex1 && parseInt(td.text()) <= ex2) {
                    td.css('background', '#B40404');
                }

            }
        }

        datosTemporales = {
            rac1: ac1,
            rac2: ac2,
            rto1: to1,
            rto2: to2,
            ral1: al1,
            ral2: al2,
            rex1: ex1,
            rex2: ex2
        };

        $('#mi-elemento').data('datos-temporales', datosTemporales);
        $('#operacion').prop("disabled", false);

    });

    //CONTROL DE INPUTS
    $('.xyz, .n-riesgo').on('input', function () {
        var valor = $(this).val();
        if (valor && parseFloat(valor) < 1) {
            alert('El valor debe ser mayor que 0');
            $(this).val('');
        }

    });

    $("#ac2").on("input", function () {
        var inputValue = $(this).val();
        $("#to1").val(parseInt(inputValue) + 1);
        $("#to1").prop('readonly', true);
    });
    $("#to2").on("input", function () {
        var inputValue = $(this).val();
        $("#al1").val(parseInt(inputValue) + 1);
        $("#al1").prop('readonly', true);
    });
    $("#al2").on("input", function () {
        var inputValue = $(this).val();
        $("#ex1").val(parseInt(inputValue) + 1);
        $("#ex1").prop('readonly', true);
    });
    //Valores de probabilidad y consecuencia

    $("#c1").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            $("#c1").prop('readonly', true);
            $("#c2").prop('readonly', false);
            $("#c2").focus();
        }
    });
    $("#c2").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        var inputValue = $(this).val();
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            if (parseInt(inputValue) <= $("#c1").val()) {
                alert('El valor debe ser mayor que el anterior');
                $(this).val('');
            } else {
                $("#c1").prop('readonly', true);
                $("#c3").prop('readonly', false);
                $("#c3").focus();
            }
        }
    });
    $("#c3").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        var inputValue = $(this).val();
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            if (parseInt(inputValue) <= $("#c2").val()) {
                alert('El valor debe ser mayor que el anterior');
                $(this).val('');
            } else {
                $("#c2").prop('readonly', true);
                $("#c4").prop('readonly', false);
                $("#c4").focus();
            }
        }
    });
    $("#c4").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        var inputValue = $(this).val();
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            if (parseInt(inputValue) <= $("#c3").val()) {
                alert('El valor debe ser mayor que el anterior');
                $(this).val('');
            } else {
                $("#c3").prop('readonly', true);
                $("#c5").prop('readonly', false);
                $("#c5").focus();
            }
        }
    });
    $("#c5").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        var inputValue = $(this).val();
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            if (parseInt(inputValue) <= $("#c4").val()) {
                alert('El valor debe ser mayor que el anterior');
                $(this).val('');
            } else {
                $("#c4").prop('readonly', true);
                $("#p5").prop('readonly', false);
                $("#p5").focus();
            }
        }
    });
    $("#p5").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            $("#p5").prop('readonly', true);
            $("#p4").prop('readonly', false);
            $("#p4").focus();
        }
    });
    $("#p4").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        var inputValue = $(this).val();
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            if (parseInt(inputValue) <= $("#p5").val()) {
                alert('El valor debe ser mayor que el anterior');
                $(this).val('');
            } else {
                $("#p4").prop('readonly', true);
                $("#p3").prop('readonly', false);
                $("#p3").focus();
            }
        }
    });
    $("#p3").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        var inputValue = $(this).val();
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            if (parseInt(inputValue) <= $("#p4").val()) {
                alert('El valor debe ser mayor que el anterior');
                $(this).val('');
            } else {
                $("#p3").prop('readonly', true);
                $("#p2").prop('readonly', false);
                $("#p2").focus();
            }
        }
    });
    $("#p2").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        var inputValue = $(this).val();
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            if (parseInt(inputValue) <= $("#p3").val()) {
                alert('El valor debe ser mayor que el anterior');
                $(this).val('');
            } else {
                $("#p2").prop('readonly', true);
                $("#p1").prop('readonly', false);
                $("#p1").focus();
            }
        }
    });
    $("#p1").on("keydown", function (event) {
        // Obtiene el código de tecla presionada
        var keyCode = event.keyCode || event.which;
        var inputValue = $(this).val();
        // Verifica si se presionó la tecla Enter
        if (keyCode === 13) {
            if (parseInt(inputValue) <= $("#p2").val()) {
                alert('El valor debe ser mayor que el anterior');
                $(this).val('');
            } else {
                $('#calcular_matriz').prop("disabled", false);
                $('#calcular_matriz').focus();
            }
        }
    });

    //Limpiar inputs x and y
    $('#limpiarx').on('click', function(){
        $('#c1').val(' ');
        $('#c2').val(' ');
        $('#c3').val(' ');
        $('#c4').val(' ');
        $('#c5').val(' ');
        $("#c2").prop('readonly', true);
        $("#c3").prop('readonly', true);
        $("#c4").prop('readonly', true);
        $("#c5").prop('readonly', true);
        $("#c1").prop('readonly', false);
        $("#c1").focus();
    });
    $('#limpiary').on('click', function(){
        $('#p1').val(' ');
        $('#p2').val(' ');
        $('#p3').val(' ');
        $('#p4').val(' ');
        $('#p5').val(' ');
        $("#p1").prop('readonly', true);
        $("#p2").prop('readonly', true);
        $("#p3").prop('readonly', true);
        $("#p4").prop('readonly', true);
        $("#p5").prop('readonly', false);
        $("#p5").focus();
    });


});