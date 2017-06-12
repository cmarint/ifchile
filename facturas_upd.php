
<form name="frmOp">
<div class="box box-primary" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getEstados(ngDialogData.datos.Estado)">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i> Actualizar Factura</h3>
            </div>
       <div class="box-body">
        <div class="row">
             <div class="col-md-4">
                 <label>Monto Factura</label>
                 <div class="form-group input-group" ng-class="{'has-error':frmOp.txtMonto.$error.required}">
                     <span class="input-group-addon">$</span>
                     <input ng-change ="oFactura.calUtilidad(ngDialogData.datos.Monto,ngDialogData.datos.Descuento,ngDialogData.datos.DiasPago,'txtUtilidadEsperada');oFactura.calUtilidad(ngDialogData.datos.Monto,ngDialogData.datos.DescuentoSeguro,ngDialogData.datos.DiasPago,'txtUtilidadReal')" type="text" name="txtMonto" class="form-control" data-ng-model="ngDialogData.datos.Monto" ng-required="true" format="number">
                 </div>
            </div>  
             <div class="col-md-4">
                <label>Emisor</label>
                <div class="form-group input-group"  ng-class="{'has-error':frmOp.txtEmisor.$error.required}">
                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span> 
                   <input  type="text" value="Nombre Emisor" id="txtEmisor" name="txtEmisor" class="form-control" data-ng-model="ngDialogData.datos.Emisor" ng-required="true" ng-change="oFactura.limpiaCaracteres(ngDialogData.datos.Emisor,'txtEmisor')">
                </div>
            </div>    
            <div class="col-md-4">
                <label>Pagador</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtReceptor.$error.required}">
                <span class="input-group-addon"><i class="fa fa-user-secret"></i></span> 
                    <input  type="text" name="txtReceptor" id="txtReceptor" class="form-control" data-ng-model="ngDialogData.datos.Receptor" ng-required="true" ng-change="oFactura.limpiaCaracteres(ngDialogData.datos.Receptor,'txtReceptor')">
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
                  <input ng-required="true" date-input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control pull-right" data-ng-model="ngDialogData.datos.FechaVencimiento" data-ng-init="ngDialogData.datos.DiasPago = oFactura.calDiasPago2(ngDialogData.datos.FechaExp, ngDialogData.datos.FechaVencimiento,'txtDiaPago')" ng-change="oFactura.calDiasPago(ngDialogData.datos.FechaExp, ngDialogData.datos.FechaVencimiento,'txtDiaPago');oFactura.calUtilidad(ngDialogData.datos.Monto,ngDialogData.datos.Descuento,ngDialogData.datos.DiasPago,'txtUtilidadEsperada');oFactura.calUtilidad(ngDialogData.datos.Monto,ngDialogData.datos.DescuentoSeguro,ngDialogData.datos.DiasPago,'txtUtilidadReal')" name="startDate" id="fchVenc2">
                </div>
            </div>
             <div class="col-md-4">
                <label>Tasa Descuento sin Seguro</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtDescuento.$invalid||frmOp.txtDescuento.$error.required}">
                   <span class="input-group-addon">%</span>
                    <input ng-change ="oFactura.calUtilidad(ngDialogData.datos.Monto,ngDialogData.datos.Descuento,ngDialogData.datos.DiasPago,'txtUtilidadEsperada')" type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" string-to-number min="0" max="2" step="0.1" name="txtDescuento" class="form-control" data-ng-model="ngDialogData.datos.Descuento" ng-required="true">
                </div>
                  <div role="alert">
                    <small class="error" ng-show="frmOp.txtDescuento.$invalid&&!frmOp.txtDescuento.$error.required">
                            La tasa no puede superar el 2% y debe tener un máximo de dos decimales</small>
                </div>
            </div>   
            <div class="col-md-4">
                <label>Tasa Descuento con Seguro</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtDescuentoSeg.$invalid||frmOp.txtDescuentoSeg.$error.required}">
                   <span class="input-group-addon">%</span>
                    <input ng-change ="oFactura.calUtilidad(ngDialogData.datos.Monto,ngDialogData.datos.DescuentoSeguro,ngDialogData.datos.DiasPago,'txtUtilidadReal')"  type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" string-to-number min="0" max="{{ngDialogData.datos.Descuento - 0.01 }}" step="0.1"  name="txtDescuentoSeg" class="form-control" data-ng-model="ngDialogData.datos.DescuentoSeguro" ng-required="true">
                </div>
                  <div role="alert">
                    <small class="error" ng-show="frmOp.txtDescuentoSeg.$invalid&&!frmOp.txtDescuentoSeg.$error.required">
                            La tasa no puede superar el 2%, debe ser menor que la Tasa sin Seguro y debe tener un máximo de dos decimales</small>
                </div>
            </div>    
             
        </div>
        <div class="row">
            <div class="col-md-4">
                <label>Dias de Pago</label> 
                <div class="form-group input-group"> 
                 <span class="input-group-addon"><i class="fa fa-calendar-check-o "></i></span>                    
                     <input ng-disabled="true" type="text" id="txtDiaPago" name="txtDiaPago" class="form-control" data-ng-model="ngDialogData.datos.DiasPago" format="number" ng-required="true" >
                    
                 </div>
            </div>   
            <div class="col-md-4">
                 <label>Utilidad Esperada sin Seguro</label>
                 <div class="form-group input-group" ng-class="{'has-error':frmOp.txtUtilidadEsperada.$error.required}">
                     <span class="input-group-addon">$</span>
                     <input ng-disabled="true" type="text" id ="txtUtilidadEsperada" name="txtUtilidadEsperada" class="form-control" data-ng-model="ngDialogData.datos.UtilidadSin" format="number"  ng-required="true">
                 </div>
            </div> 
             <div class="col-md-4">
                <label>Utilidad Esperada con Seguro</label>
                <div class="form-group input-group" ng-class="{'has-error':frmOp.txtUtilidadReal.$error.required}">
                     <span class="input-group-addon">$</span>
                     <input  ng-disabled="true" type="text" id="txtUtilidadReal" name="txtUtilidadReal" class="form-control" data-ng-model="ngDialogData.datos.UtilidadCon" format="number" ng-required="true">
                 </div>
            </div>            
         
            
        </div>
        <div class="row">
                     
            <div class="col-md-4">
                <label>Estado</label>
                <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-flag"></i></span> 
                <select ng-disabled="false" class="form-control" ng-options="estado.Id as estado.Descripcion for estado in oFactura.estados" data-ng-model="ngDialogData.datos.Estado" name="idEstado">
                    <!--<option value="">Seleccione Estado</option>-->
                </select>               
                </div>
            </div>   
             <div class="col-md-4">
                <label>Días Publicación</label>
               <div class="form-group input-group" ng-class="{'has-error':frmOp.endDate.$error.required}">
                <span class="input-group-addon"><i class="fa fa-calendar-check-o "></i></span> 
                  <input ng-required="true" name="endDate" min="1" max="{{ oFactura.validaDias(ngDialogData.datos.DiasPago) }}" type="number" data-ng-model="ngDialogData.datos.DiasExpiracion" ng-change="oFactura.calExpiracion(ngDialogData.datos.DiasExpiracion)" string-To-Number ng-maxlength="2" ng-pattern="/^([1-9]|10)$/">
                                  
                </div>
                 <div role="alert">
                    <small class="text-danger" ng-show="frmOp.endDate.$invalid">
                           Debe ser menor a los días de pago y no superior a 10.</small>
                </div>
            </div>
             <div class="col-md-4">
                <label>Fecha Expiración</label>
               <div class="input-group date" ng-class="{'has-error':frmOp.endDate.$error.checkEndDate&&!frmOp.endDate.$error.required}">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input ng-required="true" date-input name="endDate" type="date" class="form-control pull-right" data-ng-model="ngDialogData.datos.FechaExp" id="fchExp3" readonly>
                                  
                </div>
                <div role="alert">
                    <small class="error" ng-show="frmOp.endDate.$error.checkEndDate">
                            La fecha no puede ser menor a la fecha de Vencimiento</small>
                </div>
                
            </div>
            
        </div>
        <div class="row">
          <div class="col-md-12">
              <label>Observaciones</label>
            <div class="form-group input-group">                  
                  <textarea  name="txtComentario" class="form-control" data-ng-model="ngDialogData.datos.Comentario" cols="90" id="observaciones"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
           <div class="col-md-8">
               <label for="exampleInputFile">Factura</label> 
                <div class="form-group" ng-class="{'has-error':frmOp.imgFact.$error.required}">                                   
                  <input name="imgFact" valid-file accept="image/x-png,image/gif,image/jpeg" type="file" required file-model="myFile"  data-ng-model="ngDialogData.datos.ImagenFactura" />
                                     
                </div>
                
            </div>
         
        </div>

        </div>
        <div class="box-footer">
            <button id="btnSimular" type="button" class="btn btn-success" data-ng-click="oFactura.updFactura(ngDialogData.datos,1)" ng-disabled="!frmOp.$valid">
                <i class=" fa fa-plus-circle">
                </i>
                Actualizar
            </button>
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cancelar</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    
     $('#fchPago').datepicker({
      autoclose: true
    });
      $('#fchPlazoPago').datepicker({
      autoclose: true
    });
       $('#fchVenc').datepicker({
      autoclose: true
    });

</script>



