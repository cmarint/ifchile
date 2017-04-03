
<form name="frmOp">
<div class="box  box-success" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getEstados(ngDialogData.datos.Estado)">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i> Información de Factura</h3>
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
                                <select   class="form-control" ng-options="estado.Id as estado.Descripcion for estado in oFactura.estados" data-ng-model="ngDialogData.datos.Estado" ng-disabled="true">
                                    
                                </select>               
                                </div>
                            </div>
                            <div class="col-md-12">                                
                                <div class="form-group input-group"> 
                                    <span class="input-group-addon"><i class="fa fa-comments"></i> Observaciones </span>
                                    <textarea  name="txtComentario" class="form-control" data-ng-model="ngDialogData.datos.Comentario" cols="90" id="observaciones" ng-disabled="true"></textarea>
                                </div>
                            </div>
                             <div class="col-md-6">   
                                 
                                <div ng-init="oFactura.getFiles(ngDialogData.datos.Id)" class="well well-sm pre-scrollable" style="width: 300px; height: 150px; color: navy; overflow-y : scroll;">
                                <span><i class="fa fa-files-o"></i> Archivos Anexos </span>
                                <div ng-repeat="item in oFactura.archivos">
                                    <a href="{{item.Ruta}}" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> {{ item.Ruta.substring(10,item.Ruta.length) }}</a>
                                </div>
                                
                                </div>   
                            </div>
                            
                        </div>
                                
                        </div>
                <!-- /.widget-user -->
                  </div>
                </div>
                <!-- /.col -->
                
            </div>
            <!-- /.box-body -->
             <div class="box-footer">          
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cerrar</button>
        </div>
     
</div>

</form>




