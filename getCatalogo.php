<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

?>
<?php include "php/navbar.php"; ?>
<div class="container" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getCatalogo()">
    <div ng-show="oFactura.catalogo.data == 0">
        <div class="jumbotron">
          <h3>Información Importante</h3>
          <p>No tenemos facturas disponibles para invertir. Estamos gestionando para ofrecerte alternativas en los próximos días.</p>      
        </div>    
    </div>
 
	<div class="row">
        <div class="col-xs-18 col-sm-6 col-md-3" ng-repeat="item in oFactura.catalogo.data">
        
          <div class="thumbnail">
                   <!-- <img src="{{item.ImagenFactura}}" width="150" height="200"> -->
              <div class="caption">
                  
                  <h4>Pagador: {{item.Receptor}}</h4>
                  <div class="alert alert-success" role="alert">
                      <h4> <b>Monto Factura ${{ item.Monto | number}}</b></h4>
                  </div>
                <div class="alert alert-warning" role="alert">
                    <span ng-if="confirmed" class="animate-if">
                      <div class="alert alert-danger" role="alert">
                       <h4><strong>Monto a Invertir: {{ item.MontoInvertirCon | currency: $ : 0}}</strong></h4>
                      </div>
                      <h4 style="color: black">Con Seguro<span class="pull-right text-white"><i class="fa fa-lock"></i></span></h4>
                      <h4 style="color: black">Utilidad: ${{item.UtilidadCon | number: 0}}</h4>
                      <h4 style="color: black">Descuento: {{item.DescuentoSeguro | number}}%</h4>
                      
                    </span>
                    <span ng-if="!confirmed" class="animate-if">
                      <div class="alert alert-danger" role="alert">
                        <h4><strong>Monto a Invertir: {{ item.MontoInvertirSin | currency: $ : 0}}</strong></h4>
                      </div>
                      <h4 style="color: black">Sin Seguro<span class="pull-right text-white"><i class="fa fa-unlock"></i></span></h4>
                      <h4 style="color: black">Utilidad: ${{item.UtilidadSin | number: 0}}</h4>
                      <h4 style="color: black">Descuento: {{item.Descuento | number}}%</h4>
                      
                    </span>
                </div>
                <div class="alert alert-danger" role="alert">
                    <p>Expira en <b>{{oFactura.calDiasPago2(item.FechaVencimiento,item.FechaExp,'txtDiaPago') | number: 0}}</b> días</p>
                </div>
                <p>Emisor: {{item.Emisor}}<br>Días de Pago: {{ oFactura.calDiasPago2(item.FechaVencimiento,item.FechaVencimiento,'txtDiaPago') | number: 0 }}</p>
                <input type="checkbox" ng-model="confirmed" ng-change="change()" id="conseguro" />
                <label for="ng-change-example1">Con seguro</label>
                <br />
                    <input type="button" type="button" class="btn btn-primary" role="button" ng-click="oFactura.showPopUpViewFacturaPorComprar(item, confirmed);" value="Invertir">
            </div>
          </div>
        </div>

   </div><!--/row-->

</div>
</body>
</html>