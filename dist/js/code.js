var state = parseInt(sessionStorage.getItem("state")) || 0;
if (state == 1) {
    $('#hello').css('display', 'none');
}
$(document).ready(function () {
    if (state == 1) {
        base_show();
    }

    //Code ajax
    $('.edit-matriz').click(function () {
        var id = $(this).attr('id');
        console.log(id);
        $.ajax({
            type: "POST",
            url: "ajax/matriz.php?id=" + id,
            success: function (respuesta) {
                $("#edit .modal-body").html(respuesta);
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


    });

    function base_show() {
        $('#hello').hide();
        $('#profile').slideToggle();
        $('.layout-end').slideToggle();
        $('.layout-start').css({
            'width': '30%',
            'justify-content': 'start',
            'box-shadow': 'rgba(17, 17, 26, 0.1) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 48px',
            'border-radius':'20px'
        });
    }
});