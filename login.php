<?php session_start(); ?>
<?php include "php/navbar.php"; ?>
<script>
    function Logon() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        Login (username, password);
    }
</script>
<script src="js/login.js"></script>

<div class="intro-login">
    <div class="container" >
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                        alt="">
                    <form class="form-signin" role="form" name="login-form" method="post">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Ingrese Usuario o email" required autofocus>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese Contrase&ntilde;a" required>
                    <button class="btn btn-lg btn-primary btn-block" type="button" onclick="Logon()" id="btn-login">
                        Acceder</button>
                    <div id="error"></div>
                    <a href="recuperarContrasena.php" class="pull-right need-help">Olvid&oacute; su Contrase&ntilde;a? </a><span class="clearfix"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



	</body>
</html>
