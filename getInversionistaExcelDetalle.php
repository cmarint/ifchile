<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}
?>
<?php include "php/navbar.php"; ?>
	<div class="container" ng-controller="reporteController as oReporte" ng-init="oReporte.getInversionistaDetalle(<?php echo $_GET['ID']; ?>)">  
        
    <h1>Operaciones del Inversionista</h1>   
       
		<hr> 
        <table class="table table-bordered table-hover" id="tblInversionDetalle" >
        <thead>
		<tr><th>ID Factura</th><th>Monto Factura</th><th>Monto Invertido</th><th>Fecha Compra</th><th>Utilidad Real</th><th>Estado</th><th>Inversionista</th></tr>
        <thead>
        </table>	

    </div>

