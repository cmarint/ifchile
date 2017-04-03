<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}
?>
<?php include "php/navbar.php"; ?>

	<div class="container" ng-controller="reporteController as oReporte" data-ng-init="oReporte.getLog(0)">  
        
		<h1>Reporte de Auditoría</h1>   
        
		<hr> 
        <table class="display" id="tblLog" cellspacing="0" width="100%">
        <thead>
		<tr><th width="120px">Fecha</th><th width="80px">Usuario</th><th>Acción</th></tr>
        <thead>
        </table>

    </div>

