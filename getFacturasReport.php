<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
  print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}
?>
<?php require("php/navbar.php"); ?> 

<div class="container" ng-controller="reporteController as oReporte" data-ng-init="oReporte.getPanelFacturas()">
    
     <section class="content">
        
      <h1>Reporte Facturas</h1>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ oReporte.datos.data[0].Cantidad }} ({{ oReporte.datos.data[0].Monto | currency: $ : 0 }})</h3>
              <p>Total de Facturas</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="getFacturasExcelTotal.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
  
      </div>

      <div class="row">
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ oReporte.datos.data[1].Cantidad }}</h3>
                <h4>({{ oReporte.datos.data[1].Monto | currency: $ : 0 }})</h4>

              <p>Publicadas</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelPub.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ oReporte.datos.data[5].Cantidad }}</h3>
                <h4>({{ oReporte.datos.data[5].Monto | currency: $ : 0 }})</h4>

              <p>Expiradas</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelExp.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ oReporte.datos.data[2].Cantidad }}</h3>
              <h4>({{ oReporte.datos.data[2].Monto | currency: $ : 0 }})</h4>

              <p>Pendientes de Pago</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelCom.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

               
        
        <div class="col-lg-4 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ oReporte.datos.data[4].Cantidad }}</h3>
                <h4>({{ oReporte.datos.data[4].Monto | currency: $ : 0 }})</h4>
              <p>Vigentes / Morosas</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelMor.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ oReporte.datos.data[3].Cantidad }}</h3>
                <h4>({{ oReporte.datos.data[3].Monto | currency: $ : 0 }})</h4>
              <p>Pagadas Históricas</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelPag.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
          
      </div> <!-- ROW -->
    <div class="row">
        <div class="col-lg-4 col-xs-4">
        </div>
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ oReporte.datos.data[6].Cantidad }}</h3>
              <h4>({{ oReporte.datos.data[6].Monto | currency: $ : 0 }})</h4>
              <p>Vigentes</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelVig.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ oReporte.datos.data[7].Cantidad }}</h3>
                <h4>({{ oReporte.datos.data[7].Monto | currency: $ : 0 }})</h4>
              <p>Morosas</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelMorM.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ oReporte.datos.data[8].Cantidad }}</h3>
                <h4>({{ oReporte.datos.data[8].Monto | currency: $ : 0 }})</h4>
              <p>Castigadas</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelMorC.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ oReporte.datos.data[9].Cantidad }}</h3>
                <h4>({{ oReporte.datos.data[9].Monto | currency: $ : 0 }})</h4>
              <p>Judiciales</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="getFacturasExcelMorJ.php" class="small-box-footer">
              Más Información <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        
         </div>
    </section>
    <!-- /.content -->
</div>


