function Login(username, password){
        var parametros = {
                "username" : username,
                "password" : password
        };
        $.ajax({
                data:  parametros,
                url:   'php/login.php',
                type:  'GET',
                beforeSend: function () {
                        $("#error").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                    if (response == 'OK1') {
                        location.href= "getFacturasReport.php";
                    } else if (response == 'OK2') {
                        location.href= "facturas_pub_adm.php";
                    } else if (response == 'OK3') {
                        location.href= "getCatalogo.php";
                    } else {
                        $("#error").html(response);
                    }
                }
        });
}