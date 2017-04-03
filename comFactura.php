<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
  print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

?>
<?php include "php/navbar.php"; ?>
	<div class="container">   
    <div class="row">
        <div class="col-sm-10 col-xs-12">
            <div class="panel panel-success">
              <div class="panel-heading"><h3 class="panel-title">Panel de Inversión</h3></div>
              <div class="panel-body">
                  <div class="alert alert-success" role="alert">
                    <p>Usted ha realizado una operación de inversión y su número de orden es: <strong>#9999999</strong>.</p>
                    <p>Se ha enviado un correo a su cuenta xxxxxx@xxxxxxx.cl confirmando la operación y con las instrucciones para realizar el pago.</p>
                  </div>
                  <div class="row">
                   <div class="col-sm-4 col-xs-12">
                    <img src="content/images/factura.jpg" width="300" height="400" class="img-rounded" alt="Cinque Terre">
                   </div>
                   <div class="col-sm-8 col-xs-12">
                      <div class="well">
                          <table class="table table-bordered">
                            <tr><th>Emisor</th><td>Nombre_Emisor</td></tr>
                            <tr><th>Pagador</th><td>Nombre_Receptor</td></tr>
                            <tr><th>Monto</th><td>$100.000.000</td></tr>
                            <tr><th>Utilidad Esperada</th><td>$1.000.000</td></tr>
                            <tr><th>Utilidad Real</th><td>$800.000</td></tr>
                            <tr><th>Fecha Pago</th><td>30/11/2016</td></tr>
                            <tr><th>Fecha Vencimiento</th><td>31/12/2016</td></tr>
                            <tr><th>Días de Pago</th><td>30</td></tr>
                            <tr><th>Descuento</th><td>5%</td></tr>
                            <tr><th>Utilidad con Seguro</th><td>3%</td></tr>
                            <tr><th>Utilidad sin Seguro</th><td>4%</td></tr>
                          </table>
                      </div>
                   </div>
                  </div>
                  </div>
            <div class="panel-footer">
               <a class="btn btn-default btn-block" href="catalogo2.php" role="button">Continuar</a>
            </div>
          </div>
  	   </div>
      </div>
  </div>
	</div> <!-- container -->
 </body>
</html>