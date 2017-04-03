<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

?>
<?php include "php/navbar.php"; ?>
<div class="container">
<form role="form" name="frmOp">
  <div class="panel panel-primary" ng-controller="userController as oUser" data-ng-init="oUser.getPerfiles();">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-sticky-note"></i>CAMBIO DE CONTRASEÑA</h3>
            </div>
       <input type="hidden" ng-model="ngDialogData.datos.ID">
       <div class="panel-body">
        <div class="row">            
             <div class="col-md-6">
                <label>Contraseña Actual</label>
                <div class="form-group input-group">
                   <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="password" name="oldPassword" ng-model="datos.OLDPASSWORD" class="form-control" ng-required="false">
                </div>
            </div>   
        </div>
        <div class="row">            
             <div class="col-md-6">
                <label>Nueva Contraseña</label>
                <div class="form-group input-group">
                   <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="password" name="newPassword" ng-model="datos.PASSWORD" class="form-control" ng-required="false">
                </div>
            </div>   
        </div>
        <div class="row">
             <div class="col-md-6">
                <div class="form-group has-feedback" ng-class="{'has-error':frmOp.confirmPassword.$invalid&&!frmOp.confirmPassword.$error.required}">
                    <label>Confirmar Nueva Contraseña</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" match-password="newPassword" ng-model="datos.CONFIRMPASSWORD" name="confirmPassword" class="form-control" ng-required="false">
                    </div>
                    <div role="alert">
                        <span class="error" ng-show="frmOp.confirmPassword.$invalid&&!frmOp.confirmPassword.$error.required">
                            Las contraseñas no coinciden</span>
                    </div>
                </div>
            </div>    
        </div>

        <div class="panel-footer">
           
            <button id="btnGrabar" type="button" class="btn btn-success" ng-disabled="!frmOp.$valid" ng-click="oUser.updContrasena(datos)">
                <i class=" fa fa-plus-circle"></i>
                Actualizar
            </button>
            {{mensaje}}
            <!-- <button type="button" class="btn btn-primary" ng-click="closeThisDialog();">Cancelar</button> -->
        </div>
    </div>
</form>
</div>

