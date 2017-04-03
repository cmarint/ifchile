<?php include "php/navbar.php"; ?>
<div class="container" ng-controller="userController as oUser">
    <div class="row">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                          <h3><i class="fa fa-lock fa-4x"></i></h3>
                          <h2 class="text-center">Recuperar Contraseña?</h2>
                          <p>Resetee su contraseña aquí.</p>
                            <div class="panel-body">
                              
                              <form class="form">
                                <fieldset>
                                  <div class="form-group">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                      
                                      <input id="emailInput" placeholder="Correo Electronico" class="form-control" type="email" oninvalid="setCustomValidity('Ingrese un correo valido!')" onchange="try{setCustomValidity('')}catch(e){}" required ng-model="usuario.correo">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <input class="btn btn-lg btn-primary btn-block" value="Enviar" type="submit" ng-click="oUser.getContraena(usuario)">
                                  </div>
                                </fieldset>
                              </form>
                              {{mensaje}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>