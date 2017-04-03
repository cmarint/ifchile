<?php 
	try{
		require_once("../../php/conexion.php");
		$postdata = file_get_contents("php://input");
        echo $postdata;
		if(!empty($postdata)){	

		    $request = json_decode($postdata, true);
		    if($request==NULL)
		    {
		    	header("HTTP/1.0 404 Not Found");
		    	echo '{"data": "Not Json Data"}';
		    }
		    else
		    {
			   
                //print_r($request);
                session_start();
                $usr_mail = null;
                $usr_mail = $_SESSION["user_mail"];
                $contador = 0;
                $queryvalida = "SELECT count(1) FROM facturaestado WHERE IdFactura =".$request['factura']['Id']." AND IdEstado = 1";
                $result = $mysqli->query($queryvalida) or die($mysqli->error.__LINE__);
			    while ($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
				    $contador=$r[0];
				    break;
			    }
                
                if ($contador == 0) {
                    header("HTTP/1.0 404 Not Found"); 
                    echo "<script>alert('Factura No disponible');</script>";
                    echo '{"data": '+$mysqli->error+'}';
                }
                else
                {
                    $query = "INSERT INTO orden (IdUsuario, IdFactura, Participacion, FechaCompra, isSeguro)
                            VALUES (".$_SESSION["user_id"].",".$request['factura']['Id'].",99.9, NOW(), ".$request['seguro'].")";
                //echo $query;
                if($mysqli->query($query))
                {
                    $query2 = "UPDATE facturaestado SET IdEstado=2, Usuario='".$_SESSION["user_nombre"]."', Fecha= NOW() WHERE IdFactura = ".$request['factura']['Id'];
                    
                    if ($request['seguro'] == "1") {
                        $query3 = "UPDATE factura SET UtilidadReal = (Monto * DescuentoSeguro / 100 / 30 * DATEDIFF(FechaVencimiento,NOW())),
                        UtilidadEsperadaSeguro = (Monto * DescuentoSeguro / 100 / 30 * DATEDIFF(FechaVencimiento,NOW())),
                        UtilidadEsperada = (Monto * Descuento / 100 / 30 * DATEDIFF(FechaVencimiento,NOW())),
                        MontoInvertido = Monto - (Monto * DescuentoSeguro / 100 / 30 * DATEDIFF(FechaVencimiento,NOW()))
                        WHERE Id = ".$request['factura']['Id'];
                    } else {
                        $query3 = "UPDATE factura SET UtilidadReal = (Monto * Descuento / 100 / 30 * DATEDIFF(FechaVencimiento,NOW())),
                        UtilidadEsperadaSeguro = (Monto * DescuentoSeguro / 100 / 30 * DATEDIFF(FechaVencimiento,NOW())),
                        UtilidadEsperada = (Monto * Descuento / 100 / 30 * DATEDIFF(FechaVencimiento,NOW())),
                        MontoInvertido = Monto - (Monto * Descuento / 100 / 30 * DATEDIFF(FechaVencimiento,NOW()))
                        WHERE Id = ".$request['factura']['Id'];
                    }
                    
                    if($mysqli->query($query2))
                    {
                            $mysqli->query($query3);
                            if ($request['seguro'] == "1") {
                                $qry = "SELECT Id, Emisor, Receptor, Monto, MontoInvertido, DescuentoSeguro, UtilidadEsperadaSeguro FROM factura WHERE Id =".$request['factura']['Id'];
                            } else {
                                $qry = "SELECT Id, Emisor, Receptor, Monto, MontoInvertido, Descuento, UtilidadEsperada FROM factura WHERE Id =".$request['factura']['Id'];
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
                                $detalle .= "<tr><th align=\"left\">Seguro</th><td>".("1" == $request['seguro'] ? 'SI':'NO')."</td></tr>";
                                $detalle .= "<tr><th align=\"left\">Tasa de Descuento</th><td>%".$rec[5]."</td></tr>";
                                $detalle .= "<tr><th align=\"left\">Utilidad Esperada</th><td>$".number_format(round($rec[6]),0,',','.')."</td></tr>";
                                break;
                            }
                            $detalle .= "</table>";
                            
                            $para  = $usr_mail;
                            $titulo = '[MISGANANCIAS.COM] - Confirmacion de Inversion';
                            $mensaje = "
                            <html>
                            <head>
                              <link rel=\"stylesheet\" type=\"text/css\" href=\"".$_SERVER['HTTP_HOST']."/ifchile/content/bootstrap/css/bootstrap.min.css\">
                              <title>Bienvenido</title>
                            </head>
                            <body>
                              <p>Mi ganancia punto com le da la bienvenida a ser parte de esta innovadora  plataforma, donde</p>
                              <p>podrás  invertir de una manera f&aacute;cil, r&aacute;pida y segura.</p>
                              <p>Usted ha comprado dicho(s) documento(s):</p>
                              <p>".$detalle."</p>
                              <p>A continuaci&oacute;n lo contactar&aacute; uno de nuestros ejecutivos.</p>
                              <p>Le recordamos que para efectuar el pago del o los documento(s), deberá cancelar el <p>
                              <p><b>MONTO A INVERTIR: $".number_format($montoinv,0,',','.')."</b></p>
                              <p>Razón Social: Mi Ganancia Punto Com</p>
                              <p>Cuenta Corriente: 97194562</p>
                              <p>Banco: Scotiabank</p>
                              <p>Rut: 76.210.356-7</p>
                              <p>Correo de confirmaci&oacute;n: pagos@MISGANANCIAS.com</p>
                              <br>
                              <p>Gracias por confiar en nosotros, esperamos tenerlo nuevamente.</p>
                            </body>
                            </html>
                            ";
                            //echo $mensaje; 

                            // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                            // Cabeceras adicionales
                            /*$cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";*/
                            $cabeceras .= 'From: Info MISGANANCIAS.COM <contacto@MISGANANCIAS.com>' . "\r\n";
                            $querymail = "SELECT Correo FROM usuario WHERE IdPerfil IN (1, 2)";
                            $resultmail = $mysqli->query($querymail) or die($mysqli->error.__LINE__);
                            $correos = "";
                            while ($r = mysqli_fetch_array($resultmail, MYSQLI_NUM)) {
                                $correos .= 'Cc: '.$r[0]. "\r\n";
                            }
                            $cabeceras .= $correos;
                            /*
                            $cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
                            $cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";*/
                            //$cabeceras .= 'Cc: palma.fanjul@gmail.com' . "\r\n";
                            // Enviarlo
                            mail($para, $titulo, $mensaje, $cabeceras);
                        
                        
                        echo $json_response = json_encode($mysqli->affected_rows);
                    } else {
                        header("HTTP/1.0 404 Not Found");
                        echo '{"data": '+$mysqli->error+'}';
                    }
                }
                else
                {
                    header("HTTP/1.0 404 Not Found");
                    echo '{"data": '+$mysqli->error+'}';
                }
                }
			}
		}
		else{
		    header("HTTP/1.0 404 Not Found");
		    echo '{"data": "Empty PostData"}';
		}
	}
	catch (Exception $e) {
	    header("HTTP/1.1 500 Internal Server Error");
	    echo '{"data": "Exception occurred: '.$e->getMessage().'"}';
}
?>