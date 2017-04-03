
<div class="box  box-success" ng-controller="facturaController as oFactura" data-ng-init="oFactura.getEstados(0)">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i> Información Factura</h3>
            </div>
        <!-- /.box-header -->
            <div class="box-body no-padding">
             
                <div class="col-md-12 col-sm-12 bg-gray" >
                    <a href="{{ngDialogData.datos.ImagenFactura}}"  target="_blank" ng-show="{{ngDialogData.datos.ImagenFactura.substring(ngDialogData.datos.ImagenFactura.length-4,ngDialogData.datos.ImagenFactura.length) === '.pdf'}}">{{ngDialogData.datos.ImagenFactura.substring(9,ngDialogData.datos.ImagenFactura.length)}}</a>

    
                    <img src="{{ngDialogData.datos.ImagenFactura}}" ng-init="zoomWidth = 380;imgStyle = {width:'380px'}" ng-style="imgStyle" 
ng-mouse-wheel-up="zoomWidth = zoomWidth + 20; imgStyle.width = zoomWidth +'px'; "  
ng-mouse-wheel-down="zoomWidth = zoomWidth - 20;imgStyle.width = zoomWidth  +'px'; " ng-show="{{ngDialogData.datos.ImagenFactura.substring(ngDialogData.datos.ImagenFactura.length-4,ngDialogData.datos.ImagenFactura.length) !== '.pdf'}}"/>
                  
                  <!-- <img id="view" src="{{ngDialogData.datos.ImagenFactura}}"  width='380' height='500' alt="" class="img-responsive center-block"/> -->
                 
                </div>
               
                 
            </div>
                <div class="box-footer">          
                    <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cerrar</button>
                   
                 </div>
            <!-- /.box-body -->
     
</div>




