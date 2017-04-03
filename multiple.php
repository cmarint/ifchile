<?php
/*session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}
include "php/navbar.php"; */ ?>

        <div class="container" ng-controller="facturaController as oFactura" nv-file-drop="" uploader="uploader" filters="queueLimit, customFilter">
            <h3>Archivos Cargados</h3>
            <div ng-init="oFactura.getFiles(ngDialogData.datos.Id)" class="well well-sm pre-scrollable" style="width: 300px; height: 150px; color: navy; overflow-y : scroll;">
                
                <div ng-repeat="item in oFactura.archivos">
                    <a href="{{item.Ruta}}"><i class="fa fa-file" aria-hidden="true"></i> {{ item.Ruta.substring(10,item.Ruta.length) }}</a>
                </div>
            </div>
            
            <div class="row">

                <div class="col-md-3">

                    <h3>Seleccionar Archivos</h3>

                    <div ng-show="uploader.isHTML5">
                        <!-- 3. nv-file-over uploader="link" over-class="className" -->
                        <div class="well my-drop-zone" nv-file-over="" uploader="uploader">
                            Arrastre sus archivos a esta zona.
                        </div>
                    </div>

                    <!-- Example: nv-file-select="" uploader="{Object}" options="{Object}" filters="{String}" -->
                    Multiple
                    <input type="file" nv-file-select="" uploader="uploader" multiple  /><br/>
                </div>

                <div class="col-md-9" style="margin-bottom: 40px">

                    <h3>Cola de Archivos</h3>
                    <p>Cantidad: {{ uploader.queue.length }}</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50%">Nombre</th>
                                <th ng-show="uploader.isHTML5">Tamaño</th>
                                <th ng-show="uploader.isHTML5">Progreso</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in uploader.queue">
                                <td><strong>{{ item.file.name }}</strong></td>
                                <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
                                <td ng-show="uploader.isHTML5">
                                    <div class="progress" style="margin-bottom: 0;">
                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
                                    <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
                                    <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
                                </td>
                                <td nowrap>
                                    <!--<button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                        <span class="glyphicon glyphicon-upload"></span> Subir
                                    </button>
                                    <button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
                                        <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                                    </button>-->
                                    <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                        <span class="glyphicon glyphicon-trash"></span> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div ng-repeat="item in uploader.queue">
                        <input type="hidden" ng-model="ngDialogData.nombrearchivo[$index]" ng-init="ngDialogData.nombrearchivo.nombre[$index]=item.file.name" class="form-control" ng-required="true">
                    </div>
                        <input type="hidden" ng-model="ngDialogData.nombrearchivo.idFactura" ng-init="ngDialogData.nombrearchivo.idFactura=ngDialogData.datos.Id" class="form-control" ng-required="true">
                    <div>
                        <div>
                            Progreso:
                            <div class="progress" style="">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-s" ng-click="uploader.uploadAll();grabarArchivos(ngDialogData.nombrearchivo);" ng-disabled="!uploader.getNotUploadedItems().length">
                            <span class="glyphicon glyphicon-upload"></span> Subir todos
                        </button>
                        <button type="button" class="btn btn-warning btn-s" ng-click="uploader.cancelAll()" ng-disabled="!uploader.isUploading">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar todos
                        </button>
                        <button type="button" class="btn btn-danger btn-s" ng-click="uploader.clearQueue()" ng-disabled="!uploader.queue.length">
                            <span class="glyphicon glyphicon-trash"></span> Eliminar todos
                        </button>
                    </div>

                </div>

            </div>

        </div>

