<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

?>
	<?php include "php/navbar.php"; ?>
	<div class="container" ng-controller="inversionController as oInversion" data-ng-init="oInversion.getFacturasVigentes()">
		<h1 ng-init="oInversion.getFacturasVigentesTotal()">Cartera Vigente y Morosa</h1>      
        <h3>Monto Total Invertido: {{ oInversion.totales.data[0].MontoTotal | currency : $ : 0 }}</h3>
		<hr>
		<table id="tblFactVigentes" class="table table-bordered table-hover">
		<thead>
			<tr><th>Id</th><th>Factura</th><th>Emisor</th><th>Receptor</th><th>Monto</th><th>Estado</th><th>Fecha Compra</th><th>Fecha Vencimiento</th><th>Opciones</th></tr>
		</thead>
	   	</table>
	</div>
	</body>
</html>