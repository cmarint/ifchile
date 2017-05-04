app.factory('reporteFactory', function ($http) {
    var url = 'ajax/Reportes';
    return {
        getpanelfacturas: function (filtroFact) {
            return $http.post(url + '/getPanelFacturas.php',filtroFact , { loader: 'loader' });
        },
        getfacturas: function (filtroFact) {
            return $http.post(url + '/getFacturas.php',filtroFact , { loader: 'loader' });
        },
        getpanelinversionistas: function (filtroFact) {
            return $http.post(url + '/getPanelInversionista.php',filtroFact , { loader: 'loader' });
        },
        getinversionistas: function (filtroFact) {
            return $http.post(url + '/getInversionistas.php',filtroFact , { loader: 'loader' });
        },
        getlog: function (filtroFact) {
            return $http.post(url + '/getLog.php',filtroFact , { loader: 'loader' });
        }
    }
});

app.controller('reporteController', reporteController, ['$scope', 'reporteFactory']);

function reporteController($scope, reporteFactory,ngDialog,$location, $filter, $window, $http) {
    var oreporte = this;
    oreporte.Fact = reporteFactory;

    oreporte.getPanelFacturas = function () {
        oreporte.Fact.getpanelfacturas({'Estado': 0}).success(function (data) {
           oreporte.datos = data;
        })
        .error(function (data) {
            oreporte.error = data.ExceptionMessage;

        });
    }
    
    oreporte.getPanelInversionistas = function () {
        oreporte.Fact.getpanelinversionistas({'Estado': 0}).success(function (data) {
           oreporte.datos = data;
        })
        .error(function (data) {
            oreporte.error = data.ExceptionMessage;

        });
    }
    
    oreporte.getFacturas = function (idEstado) {
        oreporte.Fact.getfacturas({"Estado" : idEstado}).success(function (data) {
           oreporte.datos = data;
        })
        .error(function (data) {
            oreporte.error = data.ExceptionMessage;

        });
    }
    
   
    
    oreporte.getFacturasPublicadas = function (idEstado) {
       setDataTable('#tblFactPublic',{"Estado" : idEstado});
    }
    
     oreporte.getFacturasCompradas = function (idEstado) {
       setDataTableCompradas('#tblFactPublic',{"Estado" : idEstado});
    }
     
    oreporte.getFacturasPagadas = function (idEstado) {
       setDataTablePagadas('#tblFactPublic',{"Estado" : idEstado});
    }

    oreporte.getInversionistas = function (idEstado) {
       setDataTableInversion('#tblInversion',{"Estado" : idEstado},idEstado);
    }
    
    oreporte.getLog = function (idEstado) {
       setDataTableLog('#tblLog',{"Estado" : idEstado});
    }
    
    
    
    oreporte.showPopUpUpdFactura = function(dataFactura, pagada)
    {
        dataFactura.FechaExpiracion =   new Date(dataFactura.FechaExpiracion);
        ngDialog.open(
                    {
                        template: 'facturas_upd.php',
                        plain: false,
                        data: JSON.stringify({ 'isPagada': pagada, 'datos': dataFactura }), 
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgUpdFactura',
                        width:'900px'
                    });

    }
    
    oreporte.showDetalleInversionista = function(datainversion)
    {

        $window.location.href='getInversionistaExcelDetalle.php?ID='+datainversion.Id;
       
    }
    
    oreporte.getInversionistaDetalle = function (Id) {
        setDetalleInversion('#tblInversionDetalle',{ 'Id': Id });
    }
    
    function setDataTable(tbl,filtro)
    {        
       var otable =  $(tbl).DataTable({
          "dom": "Bfrtip",
          "buttons": ['csv', 'excel', 'pdf'],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true,
          "ajax": 
            { "url":'ajax/Reportes/getFacturas.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        /*{ data: null, render: function (data, type, row) 
                            {  
                                return "<a href=# id='btnEditServidor'>"+data.Id+"</a>";
                            }
                        },*/
                        { data: 'Id' },
                        { data: 'Emisor' },
                        { data: 'Receptor' },
                        { data:  null, render: function (data, type, row) 
                            {
                               //return $filter('currency')(data.Monto, '$', 0);
                               //return data.Monto * 1;
                               return $filter('number')(data.Monto*1, 2);
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
                        { data: 'DescripcionEstado' }
                     ],
            "order": [[0, 'asc']]
        });
        
        $(tbl + ' tbody').on('click', 'a', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'btnEditServidor') {
               
                oreporte.showPopUpUpdFactura(data, false);
            }

 
        });
    }
    
    function setDataTableInversion(tbl,filtro, flag)
    {        
       var otable =  $(tbl).DataTable({
          "dom": "Bfrtip",
          "buttons": ['csv', 'excel', 'pdf'],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true,
          "ajax": 
            { "url":'ajax/Reportes/getInversionistas.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        { data: null, render: function (data, type, row) 
                            {  
                                if (flag == "1"){
                                    return "<a href=# id='btnDetalle'>"+data.Nombre+"</a>";
                                } else {
                                    return data.Nombre;
                                }
                                    
                            }
                        },
                      //  { data: 'Nombre' },
                        { data: 'Usuario' },
                        { data: 'Rut' },
                        { data: 'Direccion' },
                        { data: 'Correo' }
                     ],
            "order": [[0, 'asc']]
        });
        
         $(tbl + ' tbody').on('click', 'a', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'btnDetalle') {
               
                oreporte.showDetalleInversionista(data, false);
            }

 
        });
    }

    
    function setDetalleInversion(tbl,filtro)
    {        
       var otable =  $(tbl).DataTable({
          "dom": "Bfrtip",
          "buttons": ['csv', 'excel', 'pdf'],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true,
          "ajax": 
            { "url":'ajax/Reportes/getInverionistaDetalle.php',                        
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
                        { data:  null, render: function (data, type, row) 
                            {
                               return $filter('currency')(data.Monto, '$', 0);
                            }
                        },
                         { data:  null, render: function (data, type, row) 
                            {
                               return $filter('currency')(data.MontoInvertido, '$', 0);
                            }
                        },
                        { data: null, render: function (data, type, row) 
                            {
                               return $filter('date')(new Date(data.FechaCompra),'dd-MM-yyyy');
                            }
                        },
                        { data:  null, render: function (data, type, row) 
                            {
                               return $filter('currency')(data.UtilidadReal, '$', 0);
                            }
                        },
                        { data: 'Descripcion' },
                        { data: 'Nombre' }
                     ],
            "order": [[0, 'asc']]
        });
    }
    
    
    
    function setDataTableCompradas(tbl,filtro)
    {        
       var otable =  $(tbl).DataTable({
          "dom": "Bfrtip",
          "buttons": ['csv', 'excel', 'pdf'],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true,
          "ajax": 
            { "url":'ajax/Reportes/getFacturas.php',                        
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
                        { data: 'Emisor' },
                        { data: 'Receptor' },
                        { data:  null, render: function (data, type, row) 
                            {
                               return $filter('number')(data.Monto*1, 2);
                               //return data.Monto*1;
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
                        { data: null, render: function (data, type, row) 
                            {
                               return $filter('date')(new Date(data.FechaCompra),'dd-MM-yyyy');
                            }
                        },
                        { data: 'DescripcionEstado' },
                        { data: 'Usuario' }
                     ],
            "order": [[0, 'asc']]
        });
    }

    function setDataTablePagadas(tbl,filtro)
    {
       var otable =  $(tbl).DataTable({
          "dom": "Bfrtip",
          "buttons": ['csv', 'excel', 'pdf'],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true,
          "ajax":
            { "url":'ajax/Reportes/getFacturas.php',
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
                        { data: 'Emisor' },
                        { data: 'Receptor' },
                        { data:  null, render: function (data, type, row)
                            {
                               return $filter('number')(data.Monto*1, 2);
                               //return data.Monto*1;
                            }
                        },
                        { data:  null, render: function (data, type, row)
                            {
                               return $filter('number')(data.UtilidadReal*1, 2);
                            }
                        },
                        { data:  null, render: function (data, type, row)
                            {
                               if (data.isSeguro == 1) {
                                   return $filter('number')(data.DescuentoSeguro*1, 2);
                               } else {
                                   return $filter('number')(data.Descuento*1, 2);
                               }


                            }
                        },
                        { data:  null, render: function (data, type, row)
                            {
                               if (data.isSeguro == 1) {
                                   return $filter('number')(data.UtilidadEsperadaSeguro*1, 2);
                               } else {
                                   return $filter('number')(data.UtilidadEsperada*1, 2);
                               }


                            }
                        },
                        { data:  null, render: function (data, type, row)
                            {
                               //return $filter('currency')(data.Monto, '$', 0);
                               return $filter('number')(data.TasaMora*1, 2);

                            }
                        },
                        { data:  null, render: function (data, type, row)
                            {
                               return $filter('number')(data.MontoMora*1, 2);
                            }
                        },
                        /*{ data: null, render: function (data, type, row)
                            {
                               return $filter('date')(new Date(data.FechaPublicacion),'dd-MM-yyyy');
                            }
                        },*/
                        { data: null, render: function (data, type, row)
                            {
                               return $filter('date')(new Date(data.FechaVencimiento),'dd-MM-yyyy');
                            }
                        },
                        { data: null, render: function (data, type, row)
                            {
                               return $filter('date')(new Date(data.FechaCompra),'dd-MM-yyyy');
                            }
                        },
                        //{ data: 'DescripcionEstado' },
                        { data: 'Usuario' }
                     ],
            "order": [[0, 'asc']]
        });
    }

    
    function setDataTableLog(tbl,filtro)
    {        
       var otable =  $(tbl).DataTable({
          "dom": "Bfrtip",
          "buttons": ['csv', 'excel', 'pdf'],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true,
          "ajax": 
            { "url":'ajax/Reportes/getLog.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        
                        //{ data: 'Id' },
                        //{ data: null, render: function (data, type, row) 
                        //    {
                        //       return $filter('date')(new Date(data.Fecha),'dd-MM-yyyy');
                        //    }
                        //},


                        { data: 'Fecha' },
                       // { data: 'Ip' },
                        { data: 'Nombre' },
                        { data: null, render: function (data, type, row) 
                            {
                               return "<pre><code>"+data.Accion+"</code></pre>";
                            }
                        }
                     ],
            "order": [[0, 'des']]
        });
        
       
    }

   
}
