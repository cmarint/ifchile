<?php 
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$inactive = 60*10; // Set timeout period in seconds
if (isset($_SESSION['loggedin'])) {
    $session_life = time() - $_SESSION['loggedin'];
    if ($session_life > $inactive) {
        session_destroy();
        //print "<script>window.location='../login.php';</script>";
        header("Location: login.php");
    }
}
$_SESSION['loggedin'] = time();
?>
<html ng-app="app_eFactoring">
  <head>
    <title>MISGANANCIAS.COM</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" type="text/css" href="content/bootstrap/css/bootstrap.min.css">
      <!-- DataTables -->
      <link rel="stylesheet" href="content/plugins/datatables/dataTables.bootstrap.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">  
      <link rel="stylesheet" type="text/css" href="content/angular/css/ngDialog.css">
      <link rel="stylesheet" type="text/css" href="content/angular/css/ngDialog-theme-default.css">
     <!-- <link rel="stylesheet" type="text/css" href="content/angular/css/ngDialog-theme-plain.css"> -->
      <link rel="stylesheet" type="text/css" href="content/angular/css/ngLoader.css">
      <link rel="stylesheet" type="text/css" href="content/plugins/datepicker/datepicker3.css">
      <link rel="stylesheet" href="content/bootstrap/css/AdminLTE.min.css"> 
      <link href="content/angular/css/angular-bootstrap-toggle.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
      



      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script type="text/javascript" src="content/bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="content/plugins/datepicker/bootstrap-datepicker.js"></script>


      <script src="https://code.highcharts.com/highcharts.js"></script>
      <script src="https://code.highcharts.com/modules/data.js"></script>
      <script src="https://code.highcharts.com/modules/exporting.js"></script>

      <!-- DataTables -->
      <script type="text/javascript" src="content/plugins/datatables/jquery.dataTables.min.js"></script>
      
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
      <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
      <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
      
      <script type="text/javascript" src="content/plugins/datatables/dataTables.bootstrap.min.js"></script>
      <script type="text/javascript" src="content/angular/angular.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.6.2/angular-locale_es-cl.js"></script>
      <script type="text/javascript" src="content/angular/angular-sanitize.js"></script>
      <script type="text/javascript" src="content/angular/angular-dialog.js"></script>
      <script type="text/javascript" src="content/angular/angular-http-loader.js"></script>
      <script type="text/javascript" src="content/angular/angular-password.min.js"></script>     
      <script type="text/javascript" src="content/angular/angular-rut.js"></script>  
      <script type="text/javascript" src="content/angular/angular-comparedate.js"></script> 
      <!-- File Upload Anexos -->
      <script src="http://nervgh.github.io/js/es5-shim.min.js"></script>
      <script src="http://nervgh.github.io/js/es5-sham.min.js"></script>
      <!--<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script> -->
      <script src="content/console-sham.js"></script>
      <script src="content/angular/angular-file-upload.min.js"></script>
      <script src="js/log4js.js"></script>
      
      <!-- Fin fileUpload -->
      
      <script type="text/javascript" src="content/app/app.js"></script>
          <script type="text/javascript" src="content/app/Controllers/reporteController.js"></script>
      <script type="text/javascript" src="content/app/Controllers/userController.js"></script>
      <script type="text/javascript" src="content/app/Controllers/facturaController.js"></script>
      <script type="text/javascript" src="content/app/Controllers/inversionController.js"></script>
      <script type="text/javascript" src="content/app/Controllers/uploadController.js"></script>
  
      <script src="content/angular/angular-bootstrap-toggle.min.js"></script>
      <style>
            .my-drop-zone { border: dotted 3px lightgray; }
            .nv-file-over { border: dotted 3px red; } /* Default class applied to drop zones on over */
            .another-file-over-class { border: dotted 3px green; }

            html, body { height: 100%; }
     </style>

      
      
  </head>
  <body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <?php if(!isset($_SESSION["user_id"])):?>
      <a class="navbar-brand" href="index.php">MISGANANCIAS.COM</a>
    <?php else: ?>
      <p class="navbar-brand">MISGANANCIAS.COM</p>
    <?php endif; ?>
    </div>
      <ul class="nav navbar-nav">
    <?php if(!isset($_SESSION["user_id"])):?>
       <li><a href="./login.php">ENTRAR</a></li>
      <?php else: 
           if($_SESSION["idPerfil"]==3):
      ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">MIS FACTURAS
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="facturasInversionista.php">Históricas / Pagadas</a></li>
                  <li><a href="facturasVigentes.php">Cartera Vigente / Morosa</a></li>
                </ul>
              </li>
              <li><a href="./getCatalogo.php">INVERTIR</a></li>
      <?php elseif ($_SESSION["idPerfil"]==1):?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">MIS FACTURAS
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="facturas_pub.php">Facturas Publicadas y Expiradas</a></li>
                  <li><a href="facturas_com.php">Facturas Compradas</a></li>
                </ul>
              </li>
             <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">REPORTES
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="getFacturasReport.php">Reporte Facturas</a></li> 
                  <li><a href="getInversionistaReport.php">Reporte Inversionistas</a></li>
                  <li><a href="getLogReport.php">Reporte de Auditoría</a></li>
                </ul>
              </li>
              
              <li><a href="./getUsuarios.php">USUARIOS</a></li>
   <?php   else: ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">MIS FACTURAS
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Facturas Publicadas y Expiradas</a></li>
                  <!-- <li><a href="#">Facturas Compradas</a></li> -->
                </ul>
              </li>
      
      <?php endif; ?>
      </ul>          
      <ul class="nav navbar-nav navbar-right">
        <li><p class="navbar-text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $_SESSION["user_nombre"]; ?> (<?php echo $_SESSION["rol"]; ?>)</p></li>
        <li><a href="getCambioContrasena.php">CAMBIAR CONTRASEÑA</a></li>
        <li><a href="./php/logout.php">SALIR</a></li>
      </ul>
      <?php endif; ?>
    
  </div>
</nav>