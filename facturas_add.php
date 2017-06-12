<?php
$fecha = new DateTime(date('Y-m-d'));
$fecha->add(new DateInterval('P1D'));
$fecha = $fecha->format('Y-m-d');
?>
<form name="frmOp">
<div class="box box-primary" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getEstados(0)">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i> Nueva Factura</h3>
            </div>
       <div class="box-body">
        <div class="row">
            <!-- 
            <div class="col-md-4">
                <label>Glosa</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtGlosa.$error.required}">   
                <span class="input-group-addon"><i class="fa fa-map"></i></span>                 
                    <input type="text" name="txtGlosa" class="form-control" data-ng-model="ngDialogData.Glosa" ng-required="true">       
                </div>
            </div> -->
            <div class="col-md-4">
                 <label>Monto Factura</label>
                 <div class="form-group input-group" ng-class="{'has-error':frmOp.txtMonto.$error.required}">
                     <span class="input-group-addon">$</span>
                     <input  ng-change ="oFactura.calUtilidad(ngDialogData.Monto,ngDialogData.Descuento,ngDialogData.DiasPago,'txtUtilidadEsperada');oFactura.calUtilidad(ngDialogData.Monto,ngDialogData.DescuentoSeguro,ngDialogData.DiasPago,'txtUtilidadReal')" type="number" name="txtMonto"  min="0" max="9999999999" step="100000" class="form-control" data-ng-model="ngDialogData.Monto" ng-required="true">
                 </div>
            </div>  
             <div class="col-md-4">
                <label>Emisor</label>
                <div class="form-group input-group"  ng-class="{'has-error':frmOp.txtEmisor.$error.required}">
                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span> 
                   <input  type="text" id="txtEmisor" value="Nombre Emisor" name="txtEmisor" class="form-control" data-ng-model="ngDialogData.Emisor" ng-required="true" ng-change="oFactura.limpiaCaracteres(ngDialogData.Emisor,'txtEmisor')">
                </div>
            </div>    
             <div class="col-md-4">
                <label>Pagador</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtReceptor.$error.required}">
                <span class="input-group-addon"><i class="fa fa-user-secret"></i></span> 
                    <input  type="text" name="txtReceptor" id="txtReceptor" class="form-control" data-ng-model="ngDialogData.Receptor" ng-required="true" ng-change="oFactura.limpiaCaracteres(ngDialogData.Receptor,'txtReceptor')">
                </div>
            </div>
        </div>
        <div class="row">  
            <div class="col-md-4">
                <label>Fecha Vencimiento</label>
               <div class="input-group date" ng-class="{'has-error':frmOp.startDate.$error.required}">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input ng-required="true"  type="date" min="<?php echo $fecha; ?>" class="form-control pull-right" ng-change="oFactura.calDiasPago(ngDialogData.FechaExpiracion, ngDialogData.FechaVencimiento,'txtDiaPago');oFactura.calUtilidad(ngDialogData.Monto,ngDialogData.Descuento,ngDialogData.DiasPago,'txtUtilidadEsperada');oFactura.calUtilidad(ngDialogData.Monto,ngDialogData.DescuentoSeguro,ngDialogData.DiasPago,'txtUtilidadReal');" data-ng-model="ngDialogData.FechaVencimiento" name="startDate" id="fchVenc2">
                </div>
               
            </div>
             <div class="col-md-4">
                <label>Tasa Descuento sin Seguro</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtDescuento.$invalid||frmOp.txtDescuento.$error.required}">
                   <span class="input-group-addon">%</span>
                    <input ng-change ="oFactura.calUtilidad(ngDialogData.Monto,ngDialogData.Descuento,ngDialogData.DiasPago,'txtUtilidadEsperada')" type="number" min="0" max="2" step="0.01" maxlength="4" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" name="txtDescuento" class="form-control" data-ng-model="ngDialogData.Descuento"  ng-required="true">
                </div>
                 <div role="alert">
                    <small class="text-danger" ng-show="frmOp.txtDescuento.$invalid&&!frmOp.txtDescuento.$error.required">
                            La tasa no puede superar el 2% y debe tener un máximo de dos decimales</small>
                </div>
            </div>  
            <div class="col-md-4">
                <label>Tasa Descuento con Seguro</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtDescuentoSeg.$invalid||frmOp.txtDescuentoSeg.$error.required}">
                   <span class="input-group-addon">%</span>
                    <input ng-change ="oFactura.calUtilidad(ngDialogData.Monto,ngDialogData.DescuentoSeguro,ngDialogData.DiasPago,'txtUtilidadReal')" type="number" min="0" max="{{ngDialogData.Descuento - 0.01}}" step="0.1" maxlength="4" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" name="txtDescuentoSeg" class="form-control" data-ng-model="ngDialogData.DescuentoSeguro"   ng-required="true">
                </div>
                <div role="alert">
                    <small class="text-danger" ng-show="frmOp.txtDescuentoSeg.$invalid&&!frmOp.txtDescuentoSeg.$error.required">
                            La tasa no puede superar el 2%, debe ser menor que la Tasa sin Seguro y debe tener un máximo de dos decimales</small>
                </div>
            </div>  
        </div>
        <div class="row">
             <div class="col-md-4">
                <label>Dias de Pago</label> 
                <div class="form-group input-group"> 
                 <span class="input-group-addon"><i class="fa fa-calendar-check-o "></i></span>  
                     <input ng-disabled="true" type="text" id="txtDiaPago" name="txtDiaPago" class="form-control" data-ng-model="ngDialogData.DiasPago" format="number" ng-required="true" >               
                 </div>
            </div>            
            <div class="col-md-4">
                 <label>Utilidad Esperada sin Seguro</label>
                 <div class="form-group input-group" ng-class="{'has-error':frmOp.txtUtilidadEsperada.$error.required}">
                     <span class="input-group-addon">$</span>
                     <input ng-disabled="true" type="text" id ="txtUtilidadEsperada" name="txtUtilidadEsperada"  class="form-control" data-ng-model="ngDialogData.UtilidadEsperada" format="number"  ng-required="true">
                 </div>
            </div> 
             <div class="col-md-4">
                <label>Utilidad Esperada con Seguro</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtUtilidadReal.$error.required}">
                     <span class="input-group-addon">$</span>
                     <input ng-disabled="true" type="text" id="txtUtilidadReal" name="txtUtilidadReal" class="form-control" data-ng-model="ngDialogData.UtilidadEsperadaSeguro" format="number" ng-required="true">
                 </div>
            </div>                
        </div>
        <div class="row">
           
            <div class="col-md-4">
                <label>Estado</label>
                <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-flag"></i></span> 
                <select ng-disabled="true" class="form-control" ng-options="estado.Id as estado.Descripcion for estado in oFactura.estados" data-ng-model="ngDialogData.Estado">
                    <option value="">Seleccione Estado</option>
                </select>               
                </div>
            </div>   
             <div class="col-md-4">
                <label>Días Publicación</label>
               <div class="form-group input-group" ng-class="{'has-error':frmOp.endDate.$error.required}">
                <span class="input-group-addon"><i class="fa fa-calendar-check-o "></i></span> 
                  <input ng-required="true" name="endDate" min="1" max="{{ oFactura.validaDias(ngDialogData.DiasPago) }}" type="number" data-ng-model="ngDialogData.FechaExpiracion" id="fchExp2" ng-change="oFactura.calExpiracion(ngDialogData.FechaExpiracion)" ng-maxlength="2" ng-pattern="/^([1-9]|10)$/">
                                  
                </div>
                 <div role="alert">
                    <small class="text-danger" ng-show="frmOp.endDate.$invalid">
                           Debe ser menor a los días de pago y no superior a 10.</small>                     
                </div>
            </div>
             <div class="col-md-4">
                <label>Fecha Fin Publicación</label>
               <div class="form-group input-group" ng-class="{'has-error':frmOp.endDate.$error.required}">
                <span class="input-group-addon"><i class="fa fa-calendar-check-o "></i></span> 
                  <input ng-required="true" name="endDate" type="date" data-ng-model="ngDialogData.FechaExpiracion2" id="fchExp3" readonly>
                                  
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <label>Observaciones</label>
            <div class="form-group input-group" >                  
                  <textarea  name="txtComentario" class="form-control" data-ng-model="ngDialogData.Comentario" cols="90" id="observaciones" style="resize: none;overflow-y: scroll;"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
           <div class="col-md-8">
               <label for="exampleInputFile">Factura</label> 
                <div class="form-group" ng-class="{'has-error':frmOp.imgFact.$error.required}">                
                  <input name="imgFact" valid-file accept="image/x-png,image/gif,image/jpeg" type="file" required file-model="myFile" data-ng-model="ngDialogData.ImagenFactura" />     
                </div>    
            </div>
        </div>
                        <div class="panel panel-danger" ng-show="!frmOp.txtMonto.$error.required&&!frmOp.startDate.$error.required">
                            <div class="panel-body"><b>
                                <i class="fa fa-hand-paper-o"></i> Confirma que Monto Factura {{ngDialogData.Monto | currency : $ : 0 }} y Fecha Vencimiento {{ ngDialogData.FechaVencimiento | date:'dd/MM/yyyy'}} son Correctos?: <input type="checkbox" ng-model="checked" aria-label="Toggle ngShow" ></b>
                            </div>
                        </div>
        </div>
        <div class="box-footer">
            <button id="btnSimular" type="button" class="btn btn-success" data-ng-click="oFactura.addFactura(ngDialogData)" ng-disabled="!frmOp.$valid" ng-show="checked">
                <i class=" fa fa-plus-circle">
                </i>
                Ingresar
            </button>
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cancelar</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    
     $('#fchPago').datepicker({
      autoclose: true
    });
      $('#fchExp').datepicker({
       autoclose: true,
      format: 'dd/mm/yyyy',
      language: 'es',
      todayHighlight:true
    });
       $('#fchVenc').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
      language: 'es',
      todayHighlight:true
    });



</script>



