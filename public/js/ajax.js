window.addEventListener('DOMContentLoaded', () => {

    /*LOGEO DE USUARIO VIA AJAX*/
    $('#btn-login').click(function () {
        let datos = $('#frmAjaxLogin').serialize();
        $.ajax({
            type: 'POST',
            url: 'Login',
            data: datos,
            success: function (r) {
                if (r == 1) {
                    console.log('Numero de Retorno : ' + r);
                    Swal.fire(
                        'GoodS!',
                        'Bienvenida',
                        'success'
                    ).then(function () {
                        window.location = "dashboard"; //CAMBIAR POR "PROFILE"
                    });
                } else {
                    console.log('Numero de Retorno : ' + r);
                    Swal.fire(
                        'Fail!',
                        'Sus credenciales estan Incorrectas!',
                        'error'
                    ).then(function () {
                        window.location = "Admin";
                    });
                }
            }
        })
        return false;
    });


});