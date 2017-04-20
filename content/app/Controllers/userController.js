app.factory('userFactory', function ($http) {
    var url = 'ajax/Usuario';
    return {
        getUser: function () {
            return $http.post(url + '/getUsuarios.php',null , { loader: 'loader' });
        },
        delUser: function (user) {
            return $http.post(url + '/delUsuario.php', user, { loader: 'loader' });
        },
        addUser: function (data) {
            return $http.post(url + '/addUsuario.php', data, { loader: 'loader' });
        },
        addUserInv: function (data) {
            return $http.post(url + '/addUsuarioInv.php', data , { loader: 'loader' });
        },
        updUser: function (data) {
            return $http.post(url + '/updUsuario.php', data, { loader: 'loader' });
        },
        getPerfil: function () {
            return $http.post(url + '/getPerfil.php',null , { loader: 'loader' });
        },
        getRepresentante: function (user) {
            return $http.post(url + '/getRepresentante.php',user , { loader: 'loader' });
        },
        getSocio: function (user) {
            return $http.post(url + '/getSocio.php',user , { loader: 'loader' });
        },
        getCuenta: function (user) {
            return $http.post(url + '/getCuenta.php',user , { loader: 'loader' });
        },
        getBanco: function () {
            return $http.post(url + '/getBanco.php',null , { loader: 'loader' });
        },
        getContrasena: function (user) {
            return $http.post(url + '/getContrasena.php', user , { loader: 'loader' });
        },
        updContrasena: function (user) {
            return $http.post(url + '/updContrasena.php', user, { loader: 'loader'});
        }
    };
});

app.controller('userController', userController, ['$scope', 'userFactory', '$window']);

function userController($scope, userFactory, $location, ngDialog, $filter, $window) {
    var oUser = this;
    oUser.Fact = userFactory;
  
    oUser.getUsuarios = function () {
        setDataTable('#tblUsuarios', {"Perfil" : 1});
        setDataTableInv('#tblUsuariosInv', {"Perfil" : 3});
    }


    //Elimina
    oUser.delUsuario = function (usuario, origen) {
        oUser.Fact.delUser(usuario).success(function (data) {
            
            
            
            if (origen == 'Adm') {
                ReloadGrilla('ajax/Usuario/getUsuarios.php','#tblUsuarios',{"Perfil" : 1})
            } else {
                ReloadGrilla('ajax/Usuario/getUsuarios.php','#tblUsuariosInv',{"Perfil" : 3})
            }
            
            //oUser.getUsuarios();
        })
        .error(function (data) {


             ngDialog.openConfirm(
                    {
                        template: 'html/message.html',
                        plain: false,
                        data: {'data':data,'title':'Alerta','message':'No es posible eliminar Inversionista con Operaciones.'},
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgAlerta'
                    });
            oUser.error = data.ExceptionMessage;

        });
    }
    
     oUser.getRepresentante = function (usuario) {
        oUser.Fact.getRepresentante(usuario).success(function (data) {
            $scope.replegal = data;
            
        })
        .error(function (data) {
            oUser.error = data.ExceptionMessage;

        });
    }
     
    oUser.getSocio = function (usuario) {
        oUser.Fact.getSocio(usuario).success(function (data) {
            $scope.socio = data;
            
        })
        .error(function (data) {
            oUser.error = data.ExceptionMessage;

        });
    }
    
    oUser.getCuenta = function (usuario) {
        oUser.Fact.getCuenta(usuario).success(function (data) {
            $scope.cuentasbancarias = data;
            
        })
        .error(function (data) {
            oUser.error = data.ExceptionMessage;

        });
    }
    
    oUser.getContraena = function (usuario) {
        oUser.Fact.getContrasena(usuario).success(function (data) {
            $scope.mensaje = "Se ha enviado un correo con la nueva contraseña.";
        })
        .error(function (data) {
            oUser.error = data.ExceptionMessage;
        })
    }
    
    oUser.updContrasena = function (usuario) {
        oUser.Fact.updContrasena(usuario).success(function (data) {
            $scope.mensaje = data.data;
        })
        .error(function (data) {
            oUser.error = data.ExceptionMessage;
           // $scope.mensaje = data;
        })
    }
    
    function ReloadGrilla(url,tableId,filtro) {

      $.post(url, JSON.stringify(filtro), function (json) {
            table = $(tableId).dataTable();
            oSettings = table.fnSettings();

            table.fnClearTable(this);
            json =JSON.parse(json);
            for (var i = 0; i < json.data.length; i++) {
                table.oApi._fnAddData(oSettings, json.data[i]);
            }

            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            table.fnDraw();
        });
    }
    
    $scope.grabarUsuario = function(usuario) {
       oUser.Fact.addUser(usuario).success(function (data) {
           ReloadGrilla('ajax/Usuario/getUsuarios.php','#tblUsuarios',{"Perfil" : 1});
           ngDialog.close();         
       })
       .error(function (data){
         ngDialog.openConfirm(
                    {
                        template: 'html/message.html',
                        plain: false,
                        data: {'data':data,'title':'Alerta','message':'Usuario, Rut o Email ya Existe. No ha sido posible crearlo nuevamente.'},
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgAlerta'
                    });
          oUser.error = data.ExceptionMessage;          
       })
           
    };
    
    $scope.actualizarUsuario = function(usuario, admin) {
       oUser.Fact.updUser(usuario).success(function (data) {
           if (admin) {
                ReloadGrilla('ajax/Usuario/getUsuarios.php','#tblUsuarios',{"Perfil" : 1});
           } else {
               ReloadGrilla('ajax/Usuario/getUsuarios.php','#tblUsuariosInv',{"Perfil" : 3});
           }
           ngDialog.close();         
       })
       .error(function (data){
           oUser.error = data.ExceptionMessage;
       })
           
    };
    
    $scope.grabarUsuarioInv = function(usuario) {   
       oUser.Fact.addUserInv(usuario).success(function (data) {
           ReloadGrilla('ajax/Usuario/getUsuarios.php','#tblUsuariosInv',{"Perfil" : 3});
           ngDialog.close();
       })
       .error(function (data){
           //$window.alert("Usuario, Rut o Email ya Existe. No ha sido posible crearlo.");
           ngDialog.openConfirm(
                    {
                        template: 'html/message.html',
                        plain: false,
                        data: {'data':data,'title':'Alerta','message':'Usuario, Rut o Email ya Existe. No ha sido posible crearlo nuevamente.'},
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgAlerta'
                    });
           oUser.error = data.ExceptionMessage;
           
           //MensajeError();       
       })
           
    };
  
    
/*** REPRESENTANTES LEGALES *****/    
  $scope.representantes = [{id: 'reps1'}];
  
  $scope.addNewChoice = function() {
    if ($scope.representantes.length < 2) {
        var newItemNo = $scope.representantes.length+1;
        $scope.representantes.push({'id':'reps'+newItemNo });
    }
  };
    
  $scope.removeChoice = function() {
    var lastItem = $scope.representantes.length-1;
    $scope.representantes.splice(lastItem);
  };
 /*** FIN REPRESENTANTES LEGALES *****/   
    
    
/*** SOCIOS *****/    
  $scope.socios = [{id: 'socio1'}];
  
  $scope.addNewSocio = function() {
    if ($scope.socios.length < 4) {
        var newItemNo = $scope.socios.length+1;
        $scope.socios.push({'id':'socio'+newItemNo});
    }
  };
    
  $scope.removeSocio = function() {
    var lastItem = $scope.socios.length-1;
    $scope.socios.splice(lastItem);
  };
 /*** FIN SOCIOS *****/   

    
    
/*** BANCOS *****/    
  $scope.cuentas = [{id: 'usuario1'}];
  
  $scope.addNewCuenta = function() {
    if ($scope.cuentas.length < 4) {
        var newItemNo = $scope.cuentas.length+1;
        $scope.cuentas.push({'id':'usuario'+newItemNo});
    }
  };
    
  $scope.removeCuenta = function() {
    var lastItem = $scope.cuentas.length-1;
    $scope.cuentas.splice(lastItem);
  };
 /*** FIN BANCOS *****/   
    
    
    //Lista Perfiles
    oUser.getPerfiles = function () {
        oUser.Fact.getPerfil().success(function (data) {
           oUser.perfiles = data;
        })
        .error(function (data) {
            oUser.error = data.ExceptionMessage;

        });
    }
    
    oUser.getBanco = function () {
        oUser.Fact.getBanco().success(function (data) {
           oUser.bancos = data;
        })
        .error(function (data) {
            oUser.error = data.ExceptionMessage;

        });
    }


    oUser.showPopUpAddUsuario = function()
    {
        ngDialog.open(
                    {
                        template: 'addUsuarios.php',
                        plain: false,
                        data: null,
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgAddUsuario',
                        width:'900px'
                    });

    }

    oUser.showPopUpAddUsuarioInv = function()
    {
        ngDialog.open(
                    {
                        template: 'addUsuariosInv.php',
                        plain: false,
                        data: null,
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgAddUsuario',
                        width:'900px'
                    });

    }

    oUser.showPopUpUpdUsuario = function(data)
    {
        ngDialog.open(
                    {
                        template: 'updUsuarios.php',
                        plain: false,
                        data: JSON.stringify({ 'isEdit': true, 'datos': data }),
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgUpdUsuario',
                        width:'900px'
                    });

    }
    
    oUser.showPopUpUpdUsuarioInv = function(data)
    {
        ngDialog.open(
                    {
                        template: 'updUsuariosInv.php',
                        plain: false,
                        data: JSON.stringify({ 'isEdit': true, 'datos': data }),
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgUpdUsuario',
                        width:'900px'
                    });

    }

    
    function setDataTable(tbl,filtro)
    {        
      
       var otable =  $(tbl).DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true,
          "ajax": 
            { "url":'ajax/Usuario/getUsuarios.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        { data: 'ID', "visible": false, "searchable": false },
                        { data: 'NOMBRE' },
                        { data: 'USUARIO' },
                        { data: 'CORREO'},
                        { data: 'DESCRIPCION'},
                        { data: 'ESTADO'},
                        { "targets": -1,
                             "data": null,
                             "defaultContent": "<button id='btnEditServidor'  class='btn btn-mini btn-primary'><i class='icon-pencil icon-white'></i> Editar</button>",
                             "orderable": false
     
                        },
                        { "targets": -1,
                            "data": null,
                            "defaultContent": "<button  id='btnDeleteServidor' class='btn btn-mini btn-danger'><i class='icon-remove icon-white'></i> Eliminar</button>",
                            "orderable": false
     
                        }
                     ],
            "order": [[0, 'asc']]
        });

       $(tbl + ' tbody').on('click', 'button', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'btnEditServidor') {
               
                oUser.showPopUpUpdUsuario(data);
            }
            else {
                if (object[0].id == 'btnDeleteServidor') {
                   ngDialog.openConfirm(
                    {
                        template: 'html/message.html',
                        plain: false,
                        data: {'data':data,'title':'Información','message':'¿Esta seguro que desea eliminar el Registro','isConfirm':'true'},
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgDelUser'
                    })
                        .then(function (confirm) {
                            oUser.delUsuario(data, 'Adm');
                            $state.reload();
                        }, function(reject) {
                           
                        });
                   
                }
            }
 
        });
    
    }
  
    
    function setDataTableInv(tbl,filtro)
    {        
      
       var otable =  $(tbl).DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true,
          "ajax": 
            { "url":'ajax/Usuario/getUsuarios.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        { data: 'ID', "visible": false, "searchable": false },
                        { data: 'NOMBRE' },
                        { data: 'USUARIO' },
                        { data: 'CORREO'},
                        { data: 'DESCRIPCION'},
                        { data: 'ESTADO'},
                        { "targets": -1,
                             "data": null,
                             "defaultContent": "<button id='btnEditServidor'  class='btn btn-mini btn-primary'><i class='icon-pencil icon-white'></i> Editar</button>",
                             "orderable": false
     
                        },
                        { "targets": -1,
                            "data": null,
                            "defaultContent": "<button  id='btnDeleteServidor' class='btn btn-mini btn-danger'><i class='icon-remove icon-white'></i> Eliminar</button>",
                            "orderable": false
     
                        }
                     ],
            "order": [[0, 'asc']]
        });

       $(tbl + ' tbody').on('click', 'button', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'btnEditServidor') {
               
                oUser.showPopUpUpdUsuarioInv(data);
            }
            else {
                if (object[0].id == 'btnDeleteServidor') {
                   ngDialog.openConfirm(
                    {
                        template: 'html/message.html',
                        plain: false,
                        data: {'data':data,'title':'Información','message':'¿Esta seguro que desea eliminar el Registro','isConfirm':'true'},
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgDelUser'
                    })
                        .then(function (confirm) {
                            oUser.delUsuario(data, 'Inv');
                            $state.reload();
                        }, function(reject) {
                           
                        });
                   
                }
            }
 
        });
    
    }
  

}
