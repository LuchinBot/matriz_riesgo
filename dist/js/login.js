
$(document).ready(function () {
    var captcha = false;
    let intentos = localStorage.getItem('intentos');
    console.log(intentos);
    if (intentos >=3) {
        $('.main-login').remove();
        $('.main-login-intentes').show();
    }
    $('.btn-login').on('click', function () {
        var user = $('input[name="user"]').val();
        var key = $('input[name="key"]').val();
        var url = 'http://matriz_riesgo.test/';
        if (user != '' && key != '') {
            if (captcha == false) {
                $('.alert-login').html('');
                $('.btn-verify span').css({ 'background-color': '#dd0a0a7b', 'border-color': '#dd0d0d' });
            } else {
                // guardar datos
                const dataForm = {
                    username: $('input[name="user"]').val(),
                    keyword: $('input[name="key"]').val()
                };

                $.ajax({
                    type: "POST",
                    url: "dist/ajax/login",
                    data: dataForm,
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            localStorage.setItem('intentos', 0);
                            window.location.href = url + 'matriz';
                        } else {
                            // almacenar intentos
                            intentos++;
                            localStorage.setItem('intentos', intentos);
                            $('.alert-login').html('<div class="alert alert-danger text-center">' + data.message + '</div>');
                            if (intentos >= 3) {
                                $('.main-login').remove();
                                $('.main-login-intentes').show();
                            }
                        }
                    },
                    error: function (data) {
                        console.log('Error en la solicitud:', data);
                    }
                });
            }
        } else {
            $('.alert-login').html('<div class="alert alert-danger text-center">Todos los campos son obligatorios</div>');
        }
    })

    const num1 = Math.floor(Math.random() * 10) + 1;
    const num2 = Math.floor(Math.random() * 10) + 1;
    const num3 = Math.floor(Math.random() * 10) + 1;
    const captchaResultado = (num1 * num2) + num3;

    $('#captcha-prompt').text(`¿Cuánto es ${num1} x ${num2} + ${num3}?`);
    $('#verificar-btn').click(function () {
        const respuestaUsuario = parseInt($('#captcha-answer').val());
        if (respuestaUsuario === captchaResultado) {
            captcha = true;
            $('.captchaLogin').hide();
            $('.btn-verify span').css({ 'background-color': '#54d31d', 'border-color': '#307513' });

        } else {
            setTimeout(function () {
                $('#verificar-btn').addClass('bg-danger');
                $('#verificar-btn').html('<i class="fa fa-times"></i>');
            }, 1000);

            setTimeout(function () {
                $('#verificar-btn').removeClass('bg-danger').addClass('bg-info');
                $('#verificar-btn').html('<i class="fa fa-refresh"></i>');
            }, 2000);
        }
    });

    $('.btn-verify').click(function () {
        if (captcha == false || captcha == undefined) {
            $('.captchaLogin').show();
        }
    });

});