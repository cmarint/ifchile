
<form name="frmOp">
<div class="box  box-success" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getEstados(0)">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i> Información Factura</h3>
            </div>
        <!-- /.box-header -->
            <div class="box-body no-padding">
             
                <div class="col-md-5 col-sm-6 bg-gray" >
                   <a href="{{ngDialogData.datos.ImagenFactura}}"  target="_blank" ng-show="{{ngDialogData.datos.ImagenFactura.substring(ngDialogData.datos.ImagenFactura.length-4,ngDialogData.datos.ImagenFactura.length) === '.pdf'}}">{{ngDialogData.datos.ImagenFactura.substring(9,ngDialogData.datos.ImagenFactura.length)}}</a>
                  
                   <img src='{{ngDialogData.datos.ImagenFactura}}'  width='380' height='600' alt="" class="img-responsive center-block" ng-show="{{ngDialogData.datos.ImagenFactura.substring(ngDialogData.datos.ImagenFactura.length-4,ngDialogData.datos.ImagenFactura.length) !== '.pdf'}}"/>
                 
                </div>
                <!-- /.col -->
                <div class="col-md-7 col-sm-6">
                  <div class="pad box-pane-right" >
                    <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                            <div class="widget-user-image">
                                <img class="img-circle" src="content/images/detFact.png" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h2 class="widget-user-username"><strong>Pagador : {{ngDialogData.datos.Receptor}}</strong></h2>
                            <h4 class="widget-user-desc">Emisor : {{ngDialogData.datos.Emisor}} <span ng-show="ngDialogData.datos.isSeguro==1" class="pull-right text-black"><i class="fa fa-lock"></i> Con Seguro</span><span ng-show="ngDialogData.datos.isSeguro==0" class="pull-right text-black"><i class="fa fa-unlock"></i> Sin Seguro</span></h4>
                            <h5 class="widget-user-desc"> <span class="pull-right text-black"><i class="fa fa-user"></i> {{ngDialogData.datos.Usuario}}</span></h5>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="#">Monto <span class="pull-right text-black">{{ngDialogData.datos.Monto| currency}}</span></a></li>
                                <!-- <li><a href="#">Pagador <span class="pull-right text-black">{{ngDialogData.datos.Receptor}}</span></a></li> -->
                                <li><a href="#">Tasa <span ng-show="ngDialogData.datos.isSeguro==0" class="pull-right text-black">{{ngDialogData.datos.Descuento}} %</span><span ng-show="ngDialogData.datos.isSeguro==1" class="pull-right text-black">{{ngDialogData.datos.DescuentoSeguro}} %</span></a></li>
                                <li><a href="#">Utilidad <span ng-show="ngDialogData.datos.isSeguro==0" class="pull-right text-black">{{ngDialogData.datos.UtilidadReal| currency}}</span><span ng-show="ngDialogData.datos.isSeguro==1" class="pull-right text-black">{{ngDialogData.datos.UtilidadReal| currency}}</span></a></li>
                                <li><a href="#">Fecha Vencimiento <span class="pull-right text-black" ng-bind="ngDialogData.datos.FechaVencimiento | date:'dd/MM/yyyy'"></span></a></li>
                            </ul>
                            <div class="col-md-12">                
                                <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-flag"></i> Estado </span> 
                                <select  ng-disabled="true"  class="form-control" ng-options="estado.Id as estado.Descripcion for estado in oFactura.estados" data-ng-model="ngDialogData.datos.Estado">
                                    
                                </select>               
                                </div>
                            </div>
                            <div class="col-md-12">                                
                                <div class="form-group input-group"> 
                                    <span class="input-group-addon"><i class="fa fa-comments"></i> Observaciones </span>                  
                                    <textarea  ng-disabled="true"  name="txtComentario" class="form-control" data-ng-model="ngDialogData.datos.Comentario" cols="90" id="observaciones"></textarea>
                                </div>
                            </div>                        
                        </div>
                                
                        </div>
                <!-- /.widget-user -->
                  </div>
                </div>
                <!-- /.col -->
                 <div class="box-footer">          
            
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cerrar</button>
        </div>
            </div>
            <!-- /.box-body -->
     
</div>

</form>




