app.factory('facturaFactory', function ($http) {
    var url = 'ajax/Factura';
    return {
        getfactura: function (filtroFact) {
            return $http.post(url + '/getFactura.php',filtroFact , { loader: 'loader' });
        },
         getEstados: function (filtroFact) {
            return $http.post(url + '/getEstados.php',filtroFact , { loader: 'loader' });
        },
        addfactura: function (factura) {
            return $http.post(url + '/addFactura.php', factura, { loader: 'loader' });
        },
        delfactura: function (filtroFact) {
            return $http.post(url + '/delFactura.php', filtroFact, { loader: 'loader' }); 
        }, 
         updfactura: function (factura) {
            return $http.post(url + '/updFactura.php', factura, { loader: 'loader' }); 
        },
        comprarFactura: function (factura) {
            return $http.post(url + '/payFactura.php', factura, { loader: 'loader' }); 
        },
        grabarArchivos: function (datos) {
            return $http.post(url + '/saveFiles.php', datos, { loader: 'loader' }); 
        },
        getArchivos: function (datos) {
            return $http.post(url + '/getFiles.php', datos, { loader: 'loader' }); 
        }
    };
});

app.controller('facturaController', facturaController, ['$scope', '$sce', 'facturaFactory','fileUpload','FileUploader']);

function facturaController($scope, $sce, facturaFactory, $location,ngDialog,$filter,fileUpload,FileUploader) {
    var ofactura = this;
    ofactura.Fact = facturaFactory;

    var savedData = {};
    $scope.archivosmultiples = {};
    $scope.imagenopdf = '';

    //Lista facturas Publicadas
    ofactura.getFacturasPublicadas = function () {
       setDataTable('#tblFactPublic',{"Estado" : 1});
    }
    
    ofactura.getFacturasPublicadasAdm = function () {
       setDataTableAdm('#tblFactPublic',{"Estado" : 1});
    }

    ofactura.getFacturasCompradas = function () {
       setDataTableCompradas('#tblFactCompradas',{"Estado" : 2});
    }

    
    
    //Agrega Factura
    ofactura.addFactura = function (factura) {
         var file = $scope.myFile;
         var uploadUrl = 'ajax/Factura/uplFactura.php';
         fileUpload.uploadFileToUrl(file, uploadUrl);
        factura.ImagenFactura = './upload/'+file.name;

//factura.FechaVencimiento = $filter('date')(factura.FechaVencimiento, 'dd/MM/yyyy');
//factura.FechaExpiracion2 = $filter('date')(factura.FechaExpiracion2, 'dd/MM/yyyy');
       ofactura.Fact.addfactura(factura).success(function (data) {
            ReloadGrilla('ajax/Factura/getFactura.php','#tblFactPublic',{"Estado" : 1});
            ngDialog.close('dgAddFactura');
        })
        .error(function (data) {
            ofactura.error = data.ExceptionMessage;

        });
      
    }

      //Elimina Factura
    ofactura.delFactura = function (factura) {
      
      ofactura.Fact.delfactura({"Id" : factura.Id}).success(function (data) {
            if(data.Estado)
              {ReloadGrilla('ajax/Factura/getFactura.php','#tblFactPublic',{"Estado" : 1})}
              else{}
        })
        .error(function (data) {
            ofactura.error = data.ExceptionMessage;

        });
      
    }

     //Actualizar Factura
    ofactura.updFactura = function (factura,estadoUpd) {
       var file = $scope.myFile;
       if(file!=null){
         var uploadUrl = 'ajax/Factura/uplFactura.php';
         fileUpload.uploadFileToUrl(file, uploadUrl);
        factura.ImagenFactura = './upload/'+file.name;
       }
        
//factura.FechaVencimiento = $filter('date')(factura.FechaVencimiento, 'dd/MM/yyyy');
//factura.FechaExpiracion2 = $filter('date')(factura.FechaExpiracion2, 'dd/MM/yyyy');

        factura.estadoUpd = estadoUpd;
       ofactura.Fact.updfactura(factura).success(function (data) {
           if(estadoUpd==1){
            ReloadGrilla('ajax/Factura/getFactura.php','#tblFactPublic',{"Estado" : estadoUpd});
           }
            else{
                 if(estadoUpd==2 || estadoUpd==3)
             ReloadGrilla('ajax/Factura/getFactura.php','#tblFactCompradas',{"Estado" : 2});
            }
            ngDialog.close('dgUpdFactura');
        })
        .error(function (data) {
            ofactura.error = data.ExceptionMessage;

        });
      
    }

    ofactura.getEstados = function (idEstado) {
        ofactura.Fact.getEstados({"Estado" : idEstado}).success(function (data) {
           ofactura.estados = data;
        })
        .error(function (data) {
            ofactura.error = data.ExceptionMessage;

        });
    }

    ofactura.uploadFile= function() {
    var file = $scope.myFile;
    console.log('file is ');
    console.dir(file);
    var uploadUrl = 'ajax/Factura/uplFactura.php';
    fileUpload.uploadFileToUrl(file, uploadUrl);
  };

  ofactura.calDiasPago=function(fchstart,fchfin,txtDiaPago)
  {
        
        var date2 = new Date($filter('date')(new Date(), 'MM-dd-yyyy'));
        var date1 = new Date($filter('date')(fchfin, 'MM-dd-yyyy'));
        var diff = date1 - date2;
        var days = diff / 1000 / 60 / 60 / 24;

       $('#'+txtDiaPago).val(parseInt(days));
       $('#'+txtDiaPago).trigger('input');
  }
  
  ofactura.calDiasPago2=function(fchstart,fchfin,txtDiaPago)
  {
        
        var date2 = new Date($filter('date')(new Date(), 'MM-dd-yyyy'));
        var date1 = new Date($filter('date')(fchfin, 'MM-dd-yyyy'));
        var diff = date1 - date2;
        var days = diff / 1000 / 60 / 60 / 24;

       return parseInt(days);
  }

   ofactura.calUtilidad=function(Monto,porcentaje,plazo,txtUtilidad)
  {
       var valor = ((Monto * porcentaje/100)/30*plazo);

       $('#'+txtUtilidad).val(Math.round(valor));
       $('#'+txtUtilidad).trigger('input');
  }
   
    ofactura.calExpiracion=function(dias)
  {
       dias = dias*1;
       var todayDate = new Date();
       var nextDate = $filter('date')(new Date().setDate(todayDate.getDate()+dias), 'yyyy-MM-dd');
       $('#fchExp3').val(nextDate);
       $('#fchExp3').trigger('input');
  }
    

    //show PopUp Add Factura
    ofactura.showPopUpAddFactura = function()
    {
        ngDialog.open(
                    {
                        template: 'facturas_add.php',
                        plain: false,
                        data: JSON.stringify({ Estado :"1"}),
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgAddFactura',
                        width:'900px'
                    });

    }
    
    //show PopUp Add Factura
    ofactura.showPopUpUpdFactura = function(dataFactura, pagada)
    {
        dataFactura.FechaExpiracion =   new Date(dataFactura.FechaExpiracion);
        ngDialog.open(
                    {
                        template: 'facturas_upd.php',
                        plain: false,
                        data: JSON.stringify({ 'isPagada': pagada, 'datos': dataFactura }), 
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgUpdFactura',
                        width:'900px'
                    });

    }
    
    ofactura.showPopUpUpdFacturaAdm = function(dataFactura, pagada)
    {
        dataFactura.FechaExpiracion =   new Date(dataFactura.FechaExpiracion);
        ngDialog.open(
                    {
                        template: 'facturas_upd_adm.php',
                        plain: false,
                        data: JSON.stringify({ 'isPagada': pagada, 'datos': dataFactura }), 
                        closeByEscape: false,
                        closeByDocument: false,
                        closeByEscape: true,
                        id: 'dgUpdFactura',
                        width:'900px'
                    });

    }
    
    

    ofactura.showPopUpViewFacturaComprada = function(dataFactura, pagada)
    {
        
        ngDialog.open(
                    {
                        template: 'facturascomp_view.php',
                        plain: false,
                        data: JSON.stringify({ 'isPagada': pagada, 'datos': dataFactura }), 
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgAddFactura',
                        width:'900px'
                    });

    }
    
    ofactura.showPopUpViewFactura = function(dataFactura, pagada)
    {
        //$scope.imagenopdf = $sce.trustAsResourceUrl(dataFactura.ImagenFactura);
        
        ngDialog.open(
                    {
                        template: 'facturas_view.php',
                        plain: false,
                        data: JSON.stringify({ 'isPagada': pagada, 'datos': dataFactura }), 
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgAddFactura',
                        width:'900px'
                    });

    }

    ofactura.showPopUpUpdFacturaComprada = function(dataFactura, pagada)
    {
        
        ngDialog.open(
                    {
                        template: 'facturascomp_upd.php',
                        plain: false,
                        data: JSON.stringify({ 'isPagada': pagada, 'datos': dataFactura }), 
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgAddFactura',
                        width:'900px'
                    });

    }
    
    ofactura.showPopUpAnexos = function(dataFactura)
    {
        
        ngDialog.open(
                    {
                        template: 'multiple.php',
                        plain: false,
                        data: JSON.stringify({ 'datos': dataFactura }), 
                        showClose: true,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgAddFactura',
                        width:'1200px'
                    });

    }

//Metodo Reload Grilla
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
    //

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
            { "url":'ajax/Factura/getFactura.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        { data: 'Id' },
                        { data: null, render: function (data, type, row) 
                            {
                               var extension = data.ImagenFactura.substring(data.ImagenFactura.length-4,data.ImagenFactura.length);
                                if (extension == ".pdf") {
                                    return "<a href=# id='imgFactView'><img src='./content/images/pdfs.png' width='30' height='40' alt='Factura' class='img-rounded'></a>";
                                } else {
                                    return "<a href=# id='imgFactView'><img src='"+data.ImagenFactura+"' width='30' height='50' alt='Factura' class='img-rounded'></a>";
                                }
                            }
                        },
                        { data: 'Emisor' },
                        { data: 'Receptor' },
                        { data:  null, render: function (data, type, row) 
                            {
                               return $filter('currency')(data.Monto, '$', 0);
                            }
                        },
                        //{ data: 'Estado'},
                        { data: null, render: function (data, type, row) 
                            {
                               return $filter('date')(new Date(data.FechaPublicacion),'dd-MM-yyyy');
                            }
                        },
                        { data: null, render: function (data, type, row) 
                            {
                               return $filter('date')(new Date(data.FechaVencimiento),'dd-MM-yyyy');
                            }
                        },
                        { data: 'EstadoDescripcion' },
                        { "targets": -1,
                             "data": null,
                             "defaultContent": "<button id='btnEditServidor'  class='btn btn-mini btn-primary'><i class='icon-pencil icon-white'></i> Editar</button>",
                             "orderable": false
     
                        },
                        { "targets": -1,
                            "data": null,
                            "defaultContent": "<button  id='btnDeleteServidor' class='btn btn-mini btn-danger'><i class='icon-remove icon-white'></i> Eliminar</button>",
                            "orderable": false
     
                        },
                        { "targets": -1,
                             "data": null,
                             "defaultContent": "<button id='btnAnexos'  class='btn btn-mini btn-warning'><i class='icon-pencil icon-white'></i> Archivos Anexos</button>",
                             "orderable": false
     
                        }
                     ],
            "order": [[0, 'asc']]
        });
        

       $(tbl + ' tbody').on('click', 'button', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'btnEditServidor') {
               
                ofactura.showPopUpUpdFactura(data, false);
            }
            else if (object[0].id == 'btnDeleteServidor') {
                   ngDialog.openConfirm(
                    {
                        template: 'html/message.html',
                        plain: false,
                        data: {'data':data,'title':'Información','message':'¿Esta seguro que desea eliminar el Registro','isConfirm':'true'},
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgDelFact'
                    })
                        .then(function (confirm) {
                            ofactura.delFactura(data);
                        }, function(reject) {
                           
                        });
                   
            }
           else {
                if (object[0].id == 'btnAnexos') {
                     ofactura.showPopUpAnexos(data);          
                }
            }
 
        });
        
        $(tbl + ' tbody').on('click', 'a', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'imgFactView') {
               
                ofactura.showPopUpViewFactura(data, true);
            }
          
 
        });
    
    }
    
    function setDataTableAdm(tbl,filtro)
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
            { "url":'ajax/Factura/getFactura.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        { data: 'Id' },
                        { data: null, render: function (data, type, row) 
                            {
                                 var extension = data.ImagenFactura.substring(data.ImagenFactura.length-4,data.ImagenFactura.length);
                                if (extension == ".pdf") {
                                    return "<a href=# id='imgFactView'><img src='./content/images/pdfs.png' width='30' height='40' alt='Factura' class='img-rounded'></a>";
                                } else {
                                    return "<a href=# id='imgFactView'><img src='"+data.ImagenFactura+"' width='30' height='50' alt='Factura' class='img-rounded'></a>";
                                }
                            }
                        },
                        { data: 'Emisor' },
                        { data: 'Receptor' },
                        { data:  null, render: function (data, type, row) 
                            {
                               return $filter('currency')(data.Monto, '$', 0);
                            }
                        },
                        //{ data: 'Estado'},
                        { data: null, render: function (data, type, row) 
                            {
                               return $filter('date')(new Date(data.FechaPublicacion),'dd-MM-yyyy');
                            }
                        },
                        { data: null, render: function (data, type, row) 
                            {
                               return $filter('date')(new Date(data.FechaVencimiento),'dd-MM-yyyy');
                            }
                        },
                        { data: 'EstadoDescripcion' },
                        { "targets": -1,
                             "data": null,
                             "defaultContent": "<button id='btnEditServidor'  class='btn btn-mini btn-primary'><i class='icon-pencil icon-white'></i> Visualizar</button>",
                             "orderable": false
     
                        }
                      
                     ],
            "order": [[0, 'asc']]
        });
        

       $(tbl + ' tbody').on('click', 'button', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'btnEditServidor') {
               
                ofactura.showPopUpUpdFacturaAdm(data, false);
            }
        });
        
        $(tbl + ' tbody').on('click', 'a', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'imgFactView') {
               
                ofactura.showPopUpViewFactura(data, true);
            }
          
 
        });
    
    }
  
    function setDataTableCompradas(tbl,filtro)
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
            { "url":'ajax/Factura/getFactura.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        { data: 'Id' },
                        { data: null, render: function (data, type, row) 
                            {
                                var extension = data.ImagenFactura.substring(data.ImagenFactura.length-4,data.ImagenFactura.length);
                                if (extension == ".pdf") {
                                    return "<a href=# id='imgFactView'><img src='./content/images/pdfs.png' width='30' height='50' alt='Factura' class='img-rounded'></a>";
                                } else {
                                    return "<a href=# id='imgFactView'><img src='"+data.ImagenFactura+"' width='30' height='50' alt='Factura' class='img-rounded'></a>";
                                }
                            }
                        },
                        { data: 'Emisor' },
                        { data: 'Receptor' },
                        { data:  null, render: function (data, type, row) 
                            {
                               return $filter('currency')(data.Monto, '$', 0);
                            }
                        },
                        //{ data: 'Estado'},
                        { data: null, render: function (data, type, row) 
                            {
                               return $filter('date')(new Date(data.FechaCompra),'dd-MM-yyyy');
                            }
                        },
                        { data: null, render: function (data, type, row) 
                            {
                               return $filter('date')(new Date(data.FechaVencimiento),'dd-MM-yyyy');
                            }
                        },
                        { data: null, render: function (data, type, row) 
                            {
                               if (!data.FechaTransferencia) {
                                   return null;
                               } else {
                                   return $filter('date')(new Date(data.FechaTransferencia),'dd-MM-yyyy');
                               }
                               
                            }
                        },
                        { data: 'Usuario' },
                        { data: 'DescripcionEstado' },
                        { "targets": -1,
                             "data": null,
                             "defaultContent": "<button id='btnEditServidor'  class='btn btn-mini btn-primary'><i class='icon-pencil icon-white'></i> Seguimiento</button>",
                             "orderable": false
     
                        },
                        { "targets": -1,
                             "data": null,
                             "defaultContent": "<button id='btnAnexos'  class='btn btn-mini btn-warning'><i class='icon-pencil icon-white'></i> Archivos Anexos</button>",
                             "orderable": false
     
                        }
                     ],
            "order": [[0, 'asc']]
        });
        

       $(tbl + ' tbody').on('click', 'button', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'btnEditServidor') {
               
                ofactura.showPopUpUpdFacturaComprada(data, true);
            }
            else {
                if (object[0].id == 'btnAnexos') {
                     ofactura.showPopUpAnexos(data);          
                }
            }
 
        });

         ///
     $(tbl + ' tbody').on('click', 'a', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'imgFactView') {
               
                ofactura.showPopUpViewFacturaComprada(data, true);
            }
          
 
        });
    
    
////
    
    }

    $scope.formatDate = function(date){
          var dateOut = new Date(date);
          return dateOut;
    }
    
    ofactura.getCatalogo = function () {
        ofactura.Fact.getfactura({"Estado" : 0}).success(function (data) {
           ofactura.catalogo = data;
        })
        .error(function (data) {
            ofactura.error = data.ExceptionMessage;

        });
    }    
    
    ofactura.showPopUpViewFacturaPorComprar = function(dataFactura, seguro)
    {
        var conSeguro = 0;
        if (seguro) { conSeguro=1; }
        ngDialog.open(
                    {
                        template: 'getFacturaPorComprar.php',
                        plain: false,
                        data: JSON.stringify({ 'seguro': conSeguro, 'datos': dataFactura }), 
                        showClose: false,
                        closeByEscape: false,
                        closeByDocument: false,
                        id: 'dgPayFactura',
                        width:'900px'
                    });

    }
    
    ofactura.comprarFactura = function (dataFactura, seguro)
    {
        ofactura.Fact.comprarFactura({'factura':dataFactura, 'seguro': seguro}).success(function (data) {
            //ngDialog.close('dgPayFactura');
            //location.reload();
            //ofactura.getCatalogo();
            $scope.showme = true;
            
        })
        .error(function (data) {
           $scope.showme2 = true;
           ofactura.error = data.ExcetionMessage; 
        });
        
    }
    
    ofactura.CierraCompra = function () {
        ngDialog.close('dgPayFactura');
        location.reload();
    }
    
    ofactura.validaDias = function(valor) {
        var dias = valor * 1;
        if (dias > 10) {
            return 10;
        } else {
            return dias - 1;
        }
    }
       
     var uploader = $scope.uploader = new FileUploader({
            url: 'upload.php'
        });

        // FILTERS
      
        // a sync filter
        uploader.filters.push({
            name: 'syncFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                console.log('syncFilter');
                return this.queue.length < 10;
            }
        });
      
        // an async filter
        uploader.filters.push({
            name: 'asyncFilter',
            fn: function(item /*{File|FileLikeObject}*/, options, deferred) {
                console.log('asyncFilter');
                setTimeout(deferred.resolve, 1e3);
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };

        //console.info('uploader', uploader);
    
        
    
        $scope.grabarArchivos = function(datos) {
            ofactura.Fact.grabarArchivos(datos).success(function (data) {
                console.info('grabarArchivos', datos);
            })
            .error(function (data) {
                ofactura.error = data.ExceptionMessage;

            });
        }
        
        ofactura.getFiles = function (id) {
        ofactura.Fact.getArchivos({"idFactura" : id}).success(function (data) {
           ofactura.archivos = data;
        })
        .error(function (data) {
            ofactura.error = data.ExceptionMessage;

        });
    }
   
}
