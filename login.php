<?php session_start(); ?>
<?php include "php/navbar.php"; ?>
<script>
    function Logon() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        Login (username, password);
    }
</script>
<p id="mensaje"></p>
<div id="error">
        <!-- error will be shown here ! -->
</div>
<div class="container" >

<div class="row">
<div class="col-md-6">
		<h2>Entrar</h2>
		<form role="form" name="login-form" method="post">
		  <div class="form-group">
		    <label for="user_email">Nombre de usuario o email</label>
		    <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario">
		  </div>
		  <div class="form-group">
		    <label for="password">Contrase&ntilde;a</label>
		    <input type="password" class="form-control" id="password" name="password" placeholder="Contrase&ntilde;a">
		  </div>

		  <button type="button" onclick="Logon()" id="btn-login" class="btn btn-success">Acceder</button>
		</form>
</div>
</div>
<div class="row">
	<div class="col-md-6">
		<a href="recuperarContrasena.php">Olvido su contraseña?</a>
	</div>
</div>
</div>
        <script src="js/login.js"></script>
	</body>
</html>