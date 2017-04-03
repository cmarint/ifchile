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
                    <input type="text" name="nombre" class="form-control" ng-required="true" ng-model="usuario.nombre">       
                </div>
            </div>
             <div class="col-md-4">
                <label>Rut (Sin puntos y con guión)</label>
                <div class="form-group has-feedback" ng-class="{'has-error':frmOp.rut.$error.rutValido}">
                   <input placeholder="9999999-9" type="text" name="rut" ng-model="usuario.rut" ng-rut class="form-control" ng-required="true">
                    <span class="glyphicon   form-control-feedback" ng-class="{'glyphicon-ok':!frmOp.rut.$error.rutValido,'glyphicon-remove':frmOp.rut.$error.rutValido}"></span>
                    
                </div>
            </div>    
             <div class="col-md-4">
                 <label>Domicilio</label>
                 <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-home"></i></span>                 
                    <input type="text" class="form-control" name="direccion" id="direccion" ng-model="usuario.direccion" ng-required="true">
                 </div>
            </div>  
        </div>
           
        <div class="row">
             <div class="col-md-4">
                <label>Usuario</label>
                <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span> 
                   <input type="text" name="usuario" class="form-control" ng-required="true" ng-model="usuario.username">
                </div>
            </div>    
             <div class="col-md-4">
                 <div class="form-group has-feedback" ng-class="{'has-error':frmOp.email.$error.email||frmOp.email.$error.required}">    
                    <label>Correo</label>         
                    <input type="email" placeholder="correo@dominio.cl" class="form-control" name="email" id="email" ng-model="usuario.email" ng-required="true">
                    <span class="glyphicon   form-control-feedback" ng-class="{'glyphicon-ok':!frmOp.email.$error.email,'glyphicon-remove':frmOp.email.$error.email||frmOp.email.$error.required}"></span>
                    <div role="alert">
                        <span class="text-danger" ng-show="frmOp.email.$error.email">
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
                    <input type="password" name="newPassword" ng-model="usuario.password" class="form-control" ng-required="true" ng-pattern="/^(?=.*?[a-z])(?=.*?[0-9]).{2,10}$/">
                   
                </div>
                 <span class="text-danger" ng-show="frmOp.newPassword.$invalid">
                            Debe contener letras y números!</span>
            </div>    
             <div class="col-md-6">
                <div class="form-group has-feedback" ng-class="{'has-error':frmOp.confirmPassword.$invalid&&!frmOp.confirmPassword.$error.required}">
                    <label>Confirmar Contraseña</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" match-password="newPassword" ng-model="password.confirm" name="confirmPassword" class="form-control" ng-required="true">
                    </div>
                    <div role="alert">
                        <span class="text-danger" ng-show="frmOp.confirmPassword.$invalid&&!frmOp.confirmPassword.$error.required">
                            Las contraseñas no coinciden</span>
                    </div>
                </div>
            </div>    
        </div>
           
        
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Representante Legal</h3>
            </div>
            <div class="panel-body">
                    <button type="button" class="btn btn-info" data-ng-click="addNewChoice()">
                     <i class=" fa fa-plus-circle"></i>
                            Agregar
                    </button>
                    <fieldset  data-ng-repeat="reps in representantes">
                      <div class="row">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <div class="form-group input-group">   
                            <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>                 
                                <input type="text" ng-model="usuario.representante.nomrep[$index]" class="form-control" name="" ng-required="true">       
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Rut (Sin puntos y con guión)</label>
                            <div class="form-group has-feedback" ng-class="{'has-error':frmOp.{{reps.id}}.$error.rutValido}">
                              <input placeholder="9999999-9" type="text" name="{{reps.id}}" ng-model="usuario.representante.rutrep[$index]" ng-rut class="form-control" ng-required="true">
                                <span class="glyphicon   form-control-feedback" ng-class="{'glyphicon-ok':!frmOp.{{reps.id}}.$error.rutValido,'glyphicon-remove':frmOp.{{reps.id}}.$error.rutValido}"></span>
                            </div>

                        </div>
                      </div>
                       <button type="button" class="btn btn-info" ng-show="$last" data-ng-click="removeChoice()">
                         <i class=" fa fa-minus-circle"></i>
                                Eliminar
                        </button> 
                    </fieldset>
                    
            </div>
        </div> <!-- Panel -->
           
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Socios</h3>
            </div>
            <div class="panel-body">
                    <button type="button" class="btn btn-info" data-ng-click="addNewSocio()">
                     <i class=" fa fa-plus-circle"></i>
                            Agregar
                    </button>
                    <fieldset  data-ng-repeat="socio in socios">
                      <div class="row">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <div class="form-group input-group">   
                            <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>                 
                                <input type="text" ng-model="usuario.socio.nomsoc[$index]" class="form-control" ng-required="true">       
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Rut (Sin puntos y con guión)</label>
                            <div class="form-group has-feedback" ng-class="{'has-error':frmOp.{{socio.id}}.$error.rutValido}">
                               <input placeholder="9999999-9" type="text" name="{{socio.id}}" ng-model="usuario.socio.rutsoc[$index]" ng-rut class="form-control" ng-required="true">
                                <span class="glyphicon   form-control-feedback" ng-class="{'glyphicon-ok':!frmOp.{{socio.id}}.$error.rutValido,'glyphicon-remove':frmOp.{{socio.id}}.$error.rutValido}"></span>
                            </div>
                        </div>
                      </div>
                       <button type="button" class="btn btn-info" ng-show="$last" data-ng-click="removeSocio()">
                         <i class=" fa fa-minus-circle"></i>
                                Eliminar
                        </button> 
                    </fieldset>
                    
            </div>
        </div> <!-- Panel -->   
        
        <div class="panel panel-info" data-ng-init="oUser.getBanco()">
            <div class="panel-heading">
                <h3 class="panel-title">Cuentas Bancarias</h3>
            </div>
            <div class="panel-body">
                <button type="button" class="btn btn-info" data-ng-click="addNewCuenta()">
                     <i class=" fa fa-plus-circle"></i>
                            Agregar
                    </button>
                    <fieldset  data-ng-repeat="cuenta in cuentas">
                       <div class="row">
                             <div class="col-md-4">
                                <label>Banco</label>
                                <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>                                 
                                    <select class="form-control" name="repeatSelect" id="repeatSelect" ng-model="usuario.cuenta.bancocuenta[$index]" ng-options="option.DESCRIPCION for option in oUser.bancos track by option.CODIGO" ng-required="true">
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <label>Cuenta</label>
                                <div class="form-group input-group">
                                   <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                    <input type="number" ng-model="usuario.cuenta.numecuenta[$index]" class="form-control" ng-required="true">
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <label>Tipo Cuenta</label>
                                <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span> 
                                    <select class="form-control" name="cuenta" ng-model="usuario.cuenta.tipocuenta[$index]" ng-required="true">
                                        <option value="CC">Corriente</option>
                                        <option value="CV">Vista</option>
                                        <option value="CA">Ahorro</option>
                                     </select>
                                </div>
                            </div>
                      </div>  
                       <button type="button" class="btn btn-info" ng-show="$last" data-ng-click="removeCuenta()">
                         <i class=" fa fa-minus-circle"></i>
                                Eliminar
                        </button> 
                    </fieldset>
            </div>
        </div>

        <div class="box-footer">
           
                 <button id="btnGrabar" type="button" class="btn btn-success" ng-click="grabarUsuarioInv(usuario)" ng-disabled="!frmOp.$valid">
                <i class=" fa fa-plus-circle"></i>
                Ingresar
            </button>
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cancelar</button>
        </div>
    </div>
</form>




