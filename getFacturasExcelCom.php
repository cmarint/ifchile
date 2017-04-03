<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}
?>
<?php include "php/navbar.php"; ?>

	<div class="container" ng-controller="reporteController as oReporte" data-ng-init="oReporte.getFacturasCompradas(2)">  
        
		<h1>Facturas Compradas</h1>   
        
		<hr> 
        <table class="table table-bordered table-hover" id="tblFactPublic">
        <thead>
		<tr><th>ID</th><th>Emisor</th><th>Pagador</th><th>Monto Factura</th><th>Fecha Publicación</th><th>Fecha Vencimiento</th><th>Fecha Compra</th><th>Estado</th><th>Inversionista</th></tr>
        <thead>
        </table>

    </div>

