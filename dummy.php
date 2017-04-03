<?php 
		require_once("php/conexion.php");
        $seguro = "";
        $seguro = $_GET['seguro'];
                            if ($seguro == "1") {
                                $qry = "SELECT Id, Emisor, Receptor, Monto, MontoInvertido, DescuentoSeguro, UtilidadEsperadaSeguro FROM factura WHERE Id = 9";
                            } else {
                                $qry = "SELECT Id, Emisor, Receptor, Monto, MontoInvertido, Descuento, UtilidadEsperada FROM factura WHERE Id = 9";
                            }
                            $res = $mysqli->query($qry) or die($mysqli->error.__LINE__);
                            $detalle = "<table border=\"0\" cellspacing=\"5\" cellpadding=\"2\">";
                            $montoinv = "";
                            while ($rec = mysqli_fetch_array($res, MYSQLI_NUM)) {
                                $detalle .= "<tr><th align=\"left\">Documento Nº</th><td>".$rec[0]."</td></tr>";
                                $detalle .= "<tr><th align=\"left\">Emisor</th><td>".$rec[1]."</td></tr>";
                                $detalle .= "<tr><th align=\"left\">Pagador</th><td>".$rec[2]."</td></tr>";
                                $detalle .= "<tr><th align=\"left\">Monto</th><td>$".number_format(round($rec[3]),0,',','.')."</td></tr>";
                                $detalle .= "<tr><th align=\"left\">Monto a Invertir</th><td>$".number_format(round($rec[4]),0,',','.')."</td></tr>";
                                $montoinv = round($rec[4]);
                                $detalle .= "<tr><th align=\"left\">Seguro</th><td>".("1" == $seguro ? 'SI':'NO')."</td></tr>";
                                $detalle .= "<tr><th align=\"left\">Tasa de Descuento</th><td>%".$rec[5]."</td></tr>";
                                $detalle .= "<tr><th align=\"left\">Utilidad Esperada</th><td>$".number_format(round($rec[6]),0,',','.')."</td></tr>";
                                break;
                            }
                            $detalle .= "</table>";
              
                            $título = '[MISGANANCIAS.COM] - Confirmación de Inversión';
                            $mensaje = "
                            <html>
                            <head>
                              <link rel=\"stylesheet\" type=\"text/css\" href=\"".$_SERVER['HTTP_HOST']."/innovacion/content/bootstrap/css/bootstrap.min.css\">
                              <title>Bienvenido</title>
                            </head>
                            <body>
                              <div class=\"container\">
                              <p>Mi ganancia punto com le da la bienvenida a ser parte de esta innovadora  plataforma, donde
                              podrás  invertir de una manera fácil, rápida y segura.</p>
                              <p>Usted ha comprado dicho(s) documento(s):</p>
                              <p>".$detalle."</p>
                              <p>A continuación lo contactará uno de nuestros ejecutivos.</p>
                              <p>Le recordamos que para efectuar el pago del o los documento(s), deberá cancelar el <p>
                              <p><b>MONTO A INVERTIR: $".number_format($montoinv,0,',','.')."</b></p>
                              <p>Razón Social: Mi Ganancia Punto Com</p>
                              <p>Cuenta Corriente: 97194562</p>
                              <p>Banco: Scotiabank</p>
                              <p>Rut: 76.210.356-7</p>
                              <p>Correo de confirmación: pagos@MISGANANCIAS.com</p>
                              <br>
                              <p>Gracias por confiar en nosotros, esperamos tenerlo nuevamente.</p>
                              </div>
                            </body>
                            </html>
                            ";
                            echo $mensaje; 

                           
                
?>