<form role="form" name="frmOp" ng-submit="submit()" ng-controller="userController as oUser">
  <div class="box box-primary" data-ng-init="oUser.getPerfiles();">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i>Nuevo Usuario Administrador</h3>
            </div>
      <div>{{ oUser.error }}</div>
       <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <label>Nombre</label>
                <div class="form-group input-group">   
                <span class="input-group-addon"><i class="fa fa-map"></i></span>                 
                    <input type="text" name="nombre" ng-model="usuario.nombre" class="form-control" ng-required="true">       
                </div>
            </div>
            <div class="col-md-4">
                 <div class="form-group has-feedback" ng-class="{'has-error':frmOp.rut.$error.rutValido}">
                    <label>Rut (Sin puntos y con guión)</label>  
                    <input type="text" placeholder="9999999-9" ng-required="true" class="form-control" ng-rut name="rut" ng-model="usuario.rut">
                    <span class="glyphicon   form-control-feedback" ng-class="{'glyphicon-ok':!frmOp.rut.$error.rutValido,'glyphicon-remove':frmOp.rut.$error.rutValido}"></span>
                 </div>
            </div>   
        </div>

          <div class="row">
            <div class="col-md-4">
                <label>Usuario</label>
                <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span> 
                   <input type="text" name="usuario" ng-model="usuario.nombreusuario" class="form-control" ng-required="true">
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
                    <select class="form-control btn-info" data-style="btn-info" ng-model="usuario.perfiles">
                        <option value="1">Superadministrador</option>
                        <option value="2">Administrador</option>
                    </select>
                </div>
               
            </div>
        </div>
        <div class="row">
             <div class="col-md-6">
                <label>Contraseña</label>
                <div class="form-group input-group">
                   <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="password" name="newPassword" id="newPassword" ng-model="usuario.password" class="form-control" ng-required="true" ng-pattern="/^(?=.*?[a-z])(?=.*?[0-9]).{2,10}$/">
                     
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
        </div>

        <div class="box-footer">
           
            <button id="btnGrabar" type="button" class="btn btn-success" ng-click="grabarUsuario(usuario)" ng-disabled="!frmOp.$valid">
                <i class=" fa fa-plus-circle"></i>
                Ingresar
            </button>
            <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cancelar</button>
        </div>
    </div>
</form>
<script>
  /*$(function() {
    $('#perfil').bootstrapToggle();
    $('#perfiles').val("2");
  })*/
</script>
<script>
  /*$(function() {
    $('#perfil').change(function() {
        if ($(this).prop('checked')) {
            $('#perfiles').val("1");
            $scope.usuario.perfiles = "1";
        } else {
            $('#perfiles').val("2");
            $scope.usuario.perfiles = "1";
        }
    })
  })*/
</script>
<script>
    /*function Perfil(flag) {
        document.getElementsByName('perfiles').value = flag;
        alert(document.getElementsByName('perfiles').value);
    }*/
</script>





