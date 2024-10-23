$(document).ready(function () {
    $('input').attr('autocomplete', 'off');

    //Code ajax
    var id = 0;
    $('.btn-id').on('click', function () {
        id = $(this).attr('id');
        //Petición ajax al servidor{
        $.ajax({
            type: "GET",
            url: "dist/ajax/matriz?id=" + id,
            success: function (data) {
                $('.modal .body-wrapper').html(data);
            }
        });

    });
    $('.generate').on('click', function () {
        id = $(this).attr('id');
        //Petición ajax al servidor{
        $.ajax({
            type: "GET",
            url: "dist/ajax/matriz?generate=" + id,
            success: function (data) {
                $('.generate-matriz').fadeIn('slow', function () {
                    setTimeout(function () {
                        window.location = "matriz";
                    }, 10000);
                });
            }
        });

    });

    $('.btn-view').on('click', function () {
        id = $(this).attr('id');
        //Petición ajax al servidor{
        $.ajax({
            type: "GET",
            url: "dist/ajax/matriz?view=" + id,
            success: function (data) {
                $('.modal .body-wrapper').html(data);
            }
        });

    });

    $('.btn-matriz').on('click', function () {
        id = $(this).attr('id');
        //Petición ajax al servidor{
        $.ajax({
            type: "GET",
            url: "dist/ajax/matriz?matriz=" + id,
            success: function (data) {
                $('.modal .body-wrapper').html(data);
            }
        });

    });
    $('.btn-event-control').on('click', function () {
        id = $(this).attr('id');
        //Petición ajax al servidor{
        $.ajax({
            type: "GET",
            url: "dist/ajax/event?id=" + id,
            success: function (data) {
                $('.modal .body-wrapper').html(data);
            }
        });

    });

    $('.btn-control').on('click', function () {
        id = $(this).attr('id');
        //Petición ajax al servidor{
        $.ajax({
            type: "GET",
            url: "dist/ajax/control?id=" + id,
            success: function (data) {
                $('.modal .body-wrapper').html(data);
            }
        });

    });
    $('.btn-user').on('click', function () {
        id = $(this).attr('id');
        //Petición ajax al servidor{
        $.ajax({
            type: "GET",
            url: "dist/ajax/user?id=" + id,
            success: function (data) {
                $('.modal .body-wrapper').html(data);
            }
        });

    });

    var x = 1;
    $('.scroll').click(function () {
        if (x == 1) {
            $('.form-inputs').slideToggle();
            $(".btn-login i").removeClass('fa-solid fa-caret-down');
            $(".btn-login i").addClass('fa-solid fa-caret-right');
            x = 0;
        } else {
            $(".btn-login").attr("type", "submit");
        }
    });

    $('.moved').click(function () {
        state = 1;
        sessionStorage.setItem("state", state);
        base_show();
        console.log('hola');


    });

    var times = false;
    $('.times').click(function () {
        if (times) {
            $('.times').find('i').removeClass('fa-caret-left').addClass('fa-caret-right');

            $('.float-left').css('animation', 'traslate1 1s forwards');
            times = false;

        } else {
            $('.times').find('i').removeClass('fa-caret-right').addClass('fa-caret-left');


            $('.float-left').css('animation', 'traslate2 1s forwards');
            times = true;
        }
    });


});