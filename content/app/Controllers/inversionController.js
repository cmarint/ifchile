app.factory('inversionFactory', function ($http) {
    var url = 'ajax/Inversion';
    return {
        getfactura: function (filtroFact) {
            return $http.post(url + '/getFactura.php',filtroFact , { loader: 'loader' });
        }
    };
});

app.controller('inversionController', inversionController, ['$scope', 'inversionFactory']);

function inversionController($scope, inversionFactory, $location,ngDialog,$filter) {
    var oInversion = this;
    oInversion.Fact = inversionFactory;



    //Lista facturas Publicadas
    oInversion.getFacturasPagadas = function () {
       setDataTable('#tblFactPagadas',{"Estado" : 5, "Accion" : 0 });
    }
    
     oInversion.getFacturasPagadasTotal = function () {
       oInversion.Fact.getfactura({"Estado" : 5, "Accion" : 1 }).success(function (data) {
           oInversion.totales = data;
       })
       .error(function (data) {
            oInversion.error = data.ExceptionMessage;

        });
     }
     
  

    oInversion.getFacturasVigentes = function () {
       setDataTableVigente('#tblFactVigentes',{"Estado" : 6, "Accion" : 0 });
    }

     oInversion.getFacturasVigentesTotal = function () {
       oInversion.Fact.getfactura({"Estado" : 6, "Accion" : 1 }).success(function (data) {
           oInversion.totales = data;
       })
       .error(function (data) {
            oInversion.error = data.ExceptionMessage;

        });
     }

    oInversion.showPopUpViewFactura = function(dataFactura, pagada)
    {
        
        ngDialog.open(
                    {
                        template: 'facturasinv_view.php',
                        plain: false,
                        data: JSON.stringify({ 'isPagada': pagada, 'datos': dataFactura }), 
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgAddFactura',
                        width:'900px'
                    });

    }
    
    oInversion.showPopUpViewFacturaComentario = function(dataFactura, pagada)
    {
        
        ngDialog.open(
                    {
                        template: 'facturascompinv_view.php',
                        plain: false,
                        data: JSON.stringify({ 'isPagada': pagada, 'datos': dataFactura }), 
                        showClose: false,
                        closeByEscape: true,
                        id: 'dgAddFactura',
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
            { "url":'ajax/Inversion/getFactura.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        { data: 'Id', "visible": true, "searchable": true },
                        { data: null, render: function (data, type, row) 
                            {

                               //return "<a href=# id='imgFactView'><img src='"+data.ImagenFactura+"' width='30' height='50' alt='Factura' class='img-rounded'></a>";
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
                               return $filter('date')(new Date(data.FechaPago),'dd-MM-yyyy');
                            }
                        },
                        { data:  null, render: function (data, type, row) 
                            {
                               return $filter('currency')(data.UtilidadReal, '$', 0);
                            }
                        }
                     ],
            "order": [[0, 'asc']]
        });
        

         $(tbl + ' tbody').on('click', 'a', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'imgFactView') {
               
                oInversion.showPopUpViewFactura(data, true);
            }
          
 
        });
    
    }
  
    function setDataTableVigente(tbl,filtro)
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
            { "url":'ajax/Inversion/getFactura.php',                        
            "dataType": "json", 
            "contentType": "application/json",
            "type":'POST',
            "data":function ( d ) {return JSON.stringify(filtro);}
            },
          "language": {"url":"//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"},
          "scrollY": "300px",
          "pagingType": "full_numbers",
          "columns": [
                        { data: 'Id', "visible": true, "searchable": true },
                        { data: null, render: function (data, type, row) 
                            {
                               //return "<a href=# id='imgFactView'><img src='"+data.ImagenFactura+"' width='30' height='50' alt='Factura' class='img-rounded'></a>";

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
                        { data: 'DescripcionEstado' },
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
                        { "targets": -1,
                             "data": null,
                             "defaultContent": "<button id='btnEditServidor'  class='btn btn-mini btn-primary'><i class='icon-pencil icon-white'></i> Seguimiento</button>",
                             "orderable": false
     
                        }
                     ],
            "order": [[0, 'asc']]
        });
        $(tbl + ' tbody').on('click', 'button', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'btnEditServidor') {
               
                oInversion.showPopUpViewFacturaComentario(data, false);
            } 
        });
        

       $(tbl + ' tbody').on('click', 'a', function () {
 
            var object = $(this);
            var data = otable.row(object.parents('tr')).data();
 
            if (object[0].id == 'imgFactView') {
               
                oInversion.showPopUpViewFactura(data, true);
            }
          
 
        });
    
    }
    
   
   

}
