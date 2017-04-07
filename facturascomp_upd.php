
<form name="frmOp">
<div class="box  box-success" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getEstados(ngDialogData.datos.Estado)">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i> Actualizar Factura</h3>
            </div>
        <!-- /.box-header -->
            <div class="box-body no-padding">             
              
                <!-- /.col -->
                <div class="col-md-12 col-sm-6">
                  <div class="pad box-pane-right" >
                    <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                            <div class="widget-user-image">
                                <img class="img-circle" src="content/images/detFact.png" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username"><strong>Pagador : {{ngDialogData.datos.Receptor}}</strong></h3>
                            <h4 class="widget-user-desc">Emisor : {{ngDialogData.datos.Emisor}} <span ng-show="ngDialogData.datos.isSeguro==1" class="pull-right text-black"><i class="fa fa-lock"></i> Con Seguro</span><span ng-show="ngDialogData.datos.isSeguro==0" class="pull-right text-black"><i class="fa fa-unlock"></i> Sin Seguro</span></h4>
                            </div>
                            <div class="col-xs-12"><hr></div>
                            <div class="box-footer no-padding">
                            <div class="col-md-12">                
                                <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-flag"></i> Estado </span> 
                                <select   class="form-control" ng-options="estado.Id as estado.Descripcion for estado in oFactura.estados" data-ng-model="ngDialogData.datos.Estado" name="IdEstado">
                                    
                                </select>               
                                </div>
                            </div>
                            <div class="col-md-12" ng-show="ngDialogData.datos.EstadoOld >= 6">                
                                <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-line-chart"></i> Tasa Especial de Mora</span> 
                                <input type="number" min="0" ng-maxlength="3" name="TasaMora" data-ng-model="ngDialogData.datos.TasaMora" class="form-control" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/">
                                </div>
                            </div>
                            <div class="col-md-12">                                
                                <div class="form-group input-group"> 
                                    <span class="input-group-addon"><i class="fa fa-comments"></i> Observaciones </span>                  
                                    <textarea  name="txtComentario" class="form-control" data-ng-model="ngDialogData.datos.Comentario" cols="90" id="observaciones"></textarea>
                                </div>
                            </div>                        
                        </div>
                                
                        </div>
                        <div class="panel panel-danger" ng-show="ngDialogData.datos.Estado == 4">
                            <div class="panel-body"><b>
                                <i class="fa fa-hand-paper-o"></i> Confirma cambio a estado [Vigente]?: <input type="checkbox" ng-model="checked" aria-label="Toggle ngShow" ></b>
                            </div>
                        </div>
                <!-- /.widget-user -->
                  </div>
                     
                </div>
                <!-- /.col -->
               
                
            </div>
            <!-- /.box-body -->
            
             <div class="box-footer">          
            <button ng-show="ngDialogData.datos.EstadoOld < 6" id="btnSimular" type="button" class="btn btn-success" data-ng-click="oFactura.updFactura(ngDialogData.datos,2)" ng-disabled="!frmOp.$valid" ng-show="ngDialogData.datos.Estado
 != 4||checked">
                <i class=" fa fa-plus-circle">
                </i>
                Actualizar
            </button>
             <button ng-show="ngDialogData.datos.EstadoOld >= 6" id="btnSimular" type="button" class="btn btn-success" data-ng-click="oFactura.updFactura(ngDialogData.datos,3)" ng-disabled="!frmOp.$valid" ng-show="ngDialogData.datos.Estado
 != 4||checked">
                <i class=" fa fa-plus-circle">
                </i>
                Actualizar
                 
            </button>
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cancelar</button>
        </div>
     
</div>

</form>




