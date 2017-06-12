
<form name="frmOp">
<div class="box  box-success" ng-controller="facturaController as oFactura">

            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i> Información Factura</h3>
                <!-- <code>datos: {{ngDialogData.datos}} conseguro: {{ ngDialogData.seguro }}</code> -->
            </div>
        <!-- /.box-header -->
            <div ng-hide="showme" class="alert alert-danger" role="alert">Usted está a un paso de realizar una operación de inversión.</div>
            <div class="box-body no-padding">
             
                <div class="col-md-5 col-sm-6 bg-gray" >
                    <a href="{{ngDialogData.datos.ImagenFactura}}"  target="_blank" ng-show="{{ngDialogData.datos.ImagenFactura.substring(ngDialogData.datos.ImagenFactura.length-4,ngDialogData.datos.ImagenFactura.length) === '.pdf'}}">{{ngDialogData.datos.ImagenFactura.substring(9,ngDialogData.datos.ImagenFactura.length)}}</a>

                    <img src="{{ngDialogData.datos.ImagenFactura}}" ng-init="zoomWidth = 380;imgStyle = {width:'380px'}" ng-style="imgStyle"
ng-mouse-wheel-up="zoomWidth = zoomWidth + 20; imgStyle.width = zoomWidth +'px'; "
ng-mouse-wheel-down="zoomWidth = zoomWidth - 20;imgStyle.width = zoomWidth  +'px'; " ng-show="{{ngDialogData.datos.ImagenFactura.substring(ngDialogData.datos.ImagenFactura.length-4,ngDialogData.datos.ImagenFactura.length) !== '.pdf'}}"/>
                  
                   <!--img src='{{ ngDialogData.datos.ImagenFactura }}'  width='380' height='600' alt="" class="img-responsive center-block" / -->
                 
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
                            <h4 class="widget-user-desc">Emisor : {{ngDialogData.datos.Emisor}} <span ng-show="ngDialogData.seguro==1" class="pull-right text-black"><i class="fa fa-lock"></i> Con Seguro</span><span ng-show="ngDialogData.seguro==0" class="pull-right text-black"><i class="fa fa-unlock"></i> Sin Seguro</span></h4>
                            <h5 class="widget-user-desc"> <span class="pull-right text-black"><i class="fa fa-user"></i> {{ngDialogData.datos.Usuario}}</span></h5>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="#">Id<span class="pull-right text-black">{{ngDialogData.datos.Id}}</span></a></li>
                                <li><a href="#">Monto Factura<span class="pull-right text-black">{{ngDialogData.datos.Monto| currency: $ : 0}}</span></a></li>
                                <!-- <li><a href="#">Pagador <span class="pull-right text-black">{{ngDialogData.datos.Receptor}}</span></a></li> -->
                                <li><a href="#">Monto a Invertir <span ng-show="ngDialogData.seguro==0" class="pull-right text-black">{{ ngDialogData.datos.Monto - ngDialogData.datos.UtilidadSin | currency: $ : 0}}</span><span ng-show="ngDialogData.seguro==1" class="pull-right text-black">{{ ngDialogData.datos.Monto - ngDialogData.datos.UtilidadCon | currency: $: 0}}</span></a></li>
                                <li><a href="#">Tasa <span ng-show="ngDialogData.seguro==0" class="pull-right text-black">{{ngDialogData.datos.Descuento | number }} %</span><span ng-show="ngDialogData.seguro==1" class="pull-right text-black">{{ngDialogData.datos.DescuentoSeguro | number }} %</span></a></li>
                                <li><a href="#">Utilidad <span ng-show="ngDialogData.seguro==0" class="pull-right text-black">{{ngDialogData.datos.UtilidadSin | number: 0}}</span><span ng-show="ngDialogData.seguro==1" class="pull-right text-black">{{ngDialogData.datos.UtilidadCon | number: 0}}</span></a></li>
                                
                                <li><a href="#">Fecha Vencimiento <span class="pull-right text-black" ng-bind="formatDate(ngDialogData.datos.FechaVencimiento) | date:'dd/MM/yyyy'"></span></a></li>
                           
                   
                            </ul>
                            <div class="col-md-12">                                
                                <div class="form-group input-group"> 
                                    <span class="input-group-addon"><i class="fa fa-comments"></i> Observaciones </span>                  
                                    <textarea  ng-disabled="true"  name="txtComentario" class="form-control" data-ng-model="ngDialogData.datos.Comentario" cols="90" id="observaciones"></textarea>
                                </div>
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
            <br>
            <div class="alert alert-success" ng-show="showme" role="alert">Ha realizado una operación de inversión. Se ha enviado un comprobante a su dirección de correo electrónico.</div>
            <div class="alert alert-danger" ng-show="showme2" role="alert">Problemas con la Factura, No es posible concretar la operación.</div>
            <!-- /.box-body -->
             <div class="box-footer">          
                    <button type="button" class="btn btn-success" ng-click="oFactura.comprarFactura(ngDialogData.datos, ngDialogData.seguro);" ng-hide="showme" ng-disabled="botonAceptar">Aceptar</button>
                    <button type="button" class="btn btn-primary" ng-click="oFactura.CierraCompra();">Cerrar</button>
            </div>
     
</div>

</form>




