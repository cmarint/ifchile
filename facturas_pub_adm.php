<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

?>
<?php include "php/navbar.php"; ?>
	<div class="container" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getFacturasPublicadasAdm()">    
		<h1>Facturas Publicadas y Expiradas</h1> 
        <a class="btn btn-success" ng-click="oFactura.showPopUpAddFactura();" role="button"><i class=" fa fa-plus-circle">
                </i> Nuevo</a>
		<hr> 
		<form>
		<table id="tblFactPublic" class="table table-bordered table-hover">
		<thead>
		<tr><th>ID</th><th>Factura</th><th>Emisor</th><th>Pagador</th><th>Monto Factura</th><th>Fecha Publicación</th><th>Fecha Vencimiento</th><th>Estado</th><th></th></tr>
		</thead>
    	</table>
    	</form>    	
	</div>

