<form role="form" name="frmOp">
  <div class="box box-primary" ng-controller="userController as oUser" data-ng-init="oUser.getPerfiles();">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i>Editar Usuario Administrador</h3>
            </div>
       <input type="hidden" ng-model="ngDialogData.datos.ID">
       <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <label>Nombre</label>
                <div class="form-group input-group">   
                <span class="input-group-addon"><i class="fa fa-map"></i></span>                 
                    <input type="text" name="nombre" ng-model="ngDialogData.datos.NOMBRE" class="form-control" readonly ng-required="true">       
                </div>
            </div>
            <div class="col-md-4">
                 <div class="form-group has-feedback" ng-class="{'has-error':frmOp.rut.$error.rutValido}">
                    <label>Rut</label>  
                    <input type="text" ng-required="true" class="form-control" ng-rut readonly name="rut" ng-model="ngDialogData.datos.RUT">
                    <span class="glyphicon   form-control-feedback" ng-class="{'glyphicon-ok':!frmOp.rut.$error.rutValido,'glyphicon-remove':frmOp.rut.$error.rutValido}"></span>
                 </div>
            </div>   
        </div>

          <div class="row">
            <div class="col-md-4">
                <label>Usuario</label>
                <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span> 
                   <input type="text" name="usuario" readonly ng-model="ngDialogData.datos.USUARIO" class="form-control" ng-required="true">
                </div>
            </div>     
             
             <div class="col-md-4">
                 
                 <div class="form-group has-feedback" ng-class="{'has-error':frmOp.email.$error.email||frmOp.email.$error.required}">    
                    <label>Correo</label>         
                    <input type="email" class="form-control" readonly name="email" id="email" ng-model="ngDialogData.datos.CORREO" ng-required="true">
                    <span class="glyphicon   form-control-feedback" ng-class="{'glyphicon-ok':!frmOp.email.$error.email,'glyphicon-remove':frmOp.email.$error.email||frmOp.email.$error.required}"></span>
                    <div role="alert">
                        <span class="error" ng-show="frmOp.email.$error.email">
                            Correo no válido!</span>
                    </div>
                 </div>
            </div>  
            <div class="col-md-4">
                <label>Perfil</label>
                <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
                    <input type="text" ng-model="ngDialogData.datos.DESCRIPCION" class="form-control" readonly>
                </div>
            </div>
        </div>
        <div class="row">
             
             <div class="col-md-6">
                <label>Contraseña</label>
                <div class="form-group input-group">
                   <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="password" name="newPassword" ng-model="ngDialogData.datos.PASSWORD" class="form-control" ng-required="false">
                </div>
            </div>    
             <div class="col-md-6">
                <div class="form-group has-feedback" ng-class="{'has-error':frmOp.confirmPassword.$invalid&&!frmOp.confirmPassword.$error.required}">
                    <label>Confirmar Contraseña</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" match-password="newPassword" ng-model="ngDialogData.datos.CONFIRMPASSWORD" name="confirmPassword" class="form-control" ng-required="false">
                    </div>
                    <div role="alert">
                        <span class="error" ng-show="frmOp.confirmPassword.$invalid&&!frmOp.confirmPassword.$error.required">
                            Las contraseñas no coinciden</span>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row">
            <div class="col-md-12" ng-if="ngDialogData.datos.ESTADO == 'false'">
                <label>Estado</label>
                <div class="form-group input-group" ng-init="ngDialogData.datos.toggleValue = false" >
                    <toggle ng-model="ngDialogData.datos.toggleValue" ng-change="changed()" style="ios"></toggle>     
                </div>
            </div>
            <div class="col-md-12" ng-if="ngDialogData.datos.ESTADO == 'true'">
                <label>Estado</label>
                <div class="form-group input-group" ng-init="ngDialogData.datos.toggleValue = true" >
                    <toggle ng-model="ngDialogData.datos.toggleValue" ng-change="changed()" style="ios"></toggle>     
                </div>
            </div>
        </div>

        <div class="box-footer">
           
            <button id="btnGrabar" type="button" class="btn btn-success" ng-disabled="!frmOp.$valid" ng-click="actualizarUsuario(ngDialogData.datos, true)">
                <i class=" fa fa-plus-circle"></i>
                Actualizar
            </button>
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cancelar</button>
        </div>
    </div>
</form>

