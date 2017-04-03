<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

?>
<html>
	<head>
		<title>.: HOME :.</title>
		<!--<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">-->
	</head>
	<body>
	<?php include "php/navbar.php"; ?>
	
	<div class="container" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getFacturasCompradas()">
		<h1>Facturas Compradas</h1>       
		<form>
		<table id="tblFactCompradas" class="table table-bordered table-hover">
		<thead>
		<tr><th>ID</th><th>Factura</th><th>Emisor</th><th>Pagador</th><th>Monto Factura</th><th>Fecha Compra</th><th>Fecha Vencimiento</th><th>Fecha Transferencia</th><th>Inversionista</th><th>Estado</th><th colspan="2">Opciones</th></tr>
		</thead>
    	</table>
    	</form>
    	
	</div>

	</body>
</html>