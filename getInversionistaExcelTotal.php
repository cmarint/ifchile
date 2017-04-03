<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}
?>
<?php include "php/navbar.php"; ?>
	<div class="container" ng-controller="reporteController as oReporte" data-ng-init="oReporte.getInversionistas(0)">  
        
		<h1>Inversionistas con Operaciones</h1>   
        
		<hr> 
        <table class="table table-bordered table-hover" id="tblInversion">
        <thead>
		<tr><th>Nombre</th><th>Usuario</th><th>Rut</th><th>Dirección</th><th>Correo</th></tr>
        <thead>
        </table>

    </div>

