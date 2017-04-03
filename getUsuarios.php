<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
  print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

?>
<?php include "php/navbar.php"; ?>
	<div class="container" ng-controller="userController as oUser" data-ng-init="oUser.getUsuarios()">       
    <!-- Nav Tab -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active">
        <a href="#admin" aria-controls="admin" role="tab" data-toggle="tab">Administradores</a>
      </li>
      <li role="presentation">
        <a href="#inver" aria-controls="inver" role="tab" data-toggle="tab">Inversionistas</a>
      </li>
    </ul>

    <!-- Tab panels -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="admin">

        <h1>Administradores</h1>
        <button id="btnSimular" type="button" class="btn btn-success" data-ng-click="oUser.showPopUpAddUsuario();">
         <i class=" fa fa-plus-circle"></i>
                Nuevo
        </button>
		    <hr>
		      <table id="tblUsuarios" class="table table-bordered table-hover">
          <thead>
		        <tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>E-Mail</th><th>Perfil</th><th>Estado</th><th colspan="2">Opciones</th></tr>
          </thead>
		      </table>
      </div>

      <div role="tabpanel" class="tab-pane" id="inver">
        <h1>Inversionistas</h1>
        <button id="btnSimular" type="button" class="btn btn-info" data-ng-click="oUser.showPopUpAddUsuarioInv();">
         <i class=" fa fa-plus-circle"></i>
                Nuevo
        </button>
        <hr>
          <table id="tblUsuariosInv" class="table table-bordered table-hover">
          <thead>
            <tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>E-Mail</th><th>Perfil</th><th>Estado</th><th colspan="2">Opciones</th></tr>
          </thead>
          </table>
      </div>



    </div><!-- Tab Panels --> 
	</div> <!-- container -->
    </body>
</html>
