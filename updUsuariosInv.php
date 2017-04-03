<form name="frmOp">
<div class="box box-primary" ng-controller="userController as oUser" data-ng-init="oUser.getPerfiles();">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i>Nuevo Inversionista</h3>
            </div>
       <div class="box-body">
            <!--<h4>Tipo Persona</h4>     
            <label>
                <input type="radio" ng-model="tipoper" value="juridica"> Juridica
            </label>
            <label>
                <input type="radio" ng-model="tipoper" value="natural"> Natural
            </label> -->
        <div class="row">
            <div class="col-md-4">
                <label>Nombre o Razón Social</label>
                <div class="form-group input-group">   
                <span class="input-group-addon"><i class="fa fa-map"></i></span>                 
                    <input type="text" name="nombre" class="form-control" ng-required="true" ng-model="ngDialogData.datos.NOMBRE" readonly>       
                </div>
            </div>
             <div class="col-md-4">
                <label>Rut</label>
                <div class="form-group has-feedback" ng-class="{'has-error':frmOp.rut.$error.rutValido}">
                   <input placeholder="9999999-9" type="text" name="rut" ng-model="ngDialogData.datos.RUT" ng-rut class="form-control" ng-required="true" readonly>
                    <span class="glyphicon   form-control-feedback" ng-class="{'glyphicon-ok':!frmOp.rut.$error.rutValido,'glyphicon-remove':frmOp.rut.$error.rutValido}"></span>
                    
                </div>
            </div>    
             <div class="col-md-4">
                 <label>Domicilio</label>
                 <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-home"></i></span>                 
                    <input type="text" class="form-control" name="direccion" id="direccion" ng-model="ngDialogData.datos.DIRECCION" ng-required="true" readonly>
                 </div>
            </div>  
        </div>
           
        <div class="row">
             <div class="col-md-4">
                <label>Usuario</label>
                <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span> 
                   <input type="text" name="usuario" class="form-control" ng-required="true" ng-model="ngDialogData.datos.USUARIO" readonly>
                </div>
            </div>    
             <div class="col-md-4">
                 <div class="form-group has-feedback" ng-class="{'has-error':frmOp.email.$error.email||frmOp.email.$error.required}">    
                    <label>Correo</label>         
                    <input type="email" class="form-control" name="email" id="email" ng-model="ngDialogData.datos.CORREO" ng-required="true" readonly>
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
                    <input type="text" class="form-control" value="Inversionista" readonly>
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
           
        
        <div class="panel panel-info" data-ng-init="oUser.getRepresentante(ngDialogData.datos.ID);">
            <div class="panel-heading">
                <h3 class="panel-title">Representante Legal</h3>
            </div>
            <div class="panel-body" ng-repeat="repr in replegal.data">
                      <div class="row" >
                        <div class="col-md-6">
                            <label>Nombre</label>               
                                <input type="text" ng-model="repr.NOMBRE" class="form-control" name="" ng-required="false" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Rut</label>
                               <input type="text" name="rutrep" ng-model="repr.RUT" class="form-control" ng-required="false" readonly>

                        </div>
                      </div>
            </div>
        </div> <!-- Panel -->
           
        <div class="panel panel-info" data-ng-init="oUser.getSocio(ngDialogData.datos.ID);">
            <div class="panel-heading">
                <h3 class="panel-title">Socios</h3>
            </div>
            <div class="panel-body" ng-repeat="soc in socio.data">     
                      <div class="row">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <div class="form-group input-group">             
                                <input readonly type="text" ng-model="soc.NOMBRE" class="form-control" ng-required="true">       
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Rut</label>
                               <input readonly type="text" ng-model="soc.RUT" class="form-control" ng-required="false">
                              
                            </div>
                        </div>
                      </div>
            </div>
        </div> <!-- Panel -->   
        
        <div class="panel panel-info" data-ng-init="oUser.getCuenta(ngDialogData.datos.ID);">
            <div class="panel-heading">
                <h3 class="panel-title">Cuentas Bancarias</h3>
            </div>
            <div class="panel-body" data-ng-repeat="cta in cuentasbancarias.data">
                       <div class="row">
                             <div class="col-md-4">
                                <label>Banco</label>
                                <div class="form-group input-group">
                                    <input type="text" ng-model="cta.BANCO" class="form-control" ng-required="false" readonly>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <label>Cuenta</label>
                                <div class="form-group input-group">
                                   <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                    <input type="text" ng-model="cta.CUENTA" class="form-control" ng-required="false" readonly>
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <label>Tipo Cuenta</label>
                                <div class="form-group input-group">
                                <input type="text" ng-model="cta.TIPO" class="form-control" readonly>
                                   
                            </div>
                      </div>  
            </div>
        </div>
        
        

        <div class="box-footer">
           
                 <button id="btnGrabar" type="button" class="btn btn-success" ng-click="actualizarUsuario(ngDialogData.datos, false)" ng-disabled="!frmOp.$valid">
                <i class=" fa fa-plus-circle"></i>
                Actualizar
            </button>
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cancelar</button>
        </div>
    </div>
</form>




