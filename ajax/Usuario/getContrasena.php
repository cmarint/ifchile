<?php
try
{
	require_once("../../php/conexion.php");
	$postdata = file_get_contents("php://input");
	if(!empty($postdata)){	

		    $request = json_decode($postdata);
		    if($request==NULL)
		    {
		    	header("HTTP/1.0 404 Not Found");
		    	echo '{"data": "Not Json Data"}';
		    }
		    else
		    {

				$query= "select u.ID as ID, 
							u.NOMBRE as NOMBRE, 
        					u.USUARIO as USUARIO, 
        					u.CORREO as CORREO,
        					u.RUT as RUT,
        					u.DIRECCION as DIRECCION
 								from usuario u 
 									where u.CORREO = '".$request->correo."'";
				$result = $mysqli->query($query);
                
                //print_r($result);
                $id = "";
                $nombre = "";
                $rut = "";
                $correo = "";
				if ($result)
				{
					if($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
						$arr[] =  $row;
                        $nombre = $row['NOMBRE'];
                        $rut = $row['RUT'];
                        $correo = $row['CORREO'];   
                        $id = $row['ID'];
						}
                        $nueva = strtoupper(substr($nombre,0,3).substr($rut,0,3));
                        //echo $nueva;
                        $query2 = "UPDATE usuario SET Password = '".md5($nueva)."' WHERE ID =". $id;
                        if ($mysqli->query($query2)){
                            $para  = $correo;
                            $título = '[IFCHILE] - Confirmación de Inversión';
                            $mensaje = "
                            <html>
                            <head>
                              <title>IFCHILE - Recuperación de Contraseña</title>
                            </head>
                            <body>
                              <p>La nueva contraseña es:".$nueva."</p>
                            </body>
                            </html>
                            ";

                            // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                            // Cabeceras adicionales
                            /*$cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";*/
                            $cabeceras .= 'From: Ventas IFChile <soporte@ifchile.com>' . "\r\n";
                            mail($para, $título, $mensaje, $cabeceras);

                        } 
                        
					}
                    
					$results = array(
            			"draw" => 1,
        				"recordsTotal" => count($arr),
        				"recordsFiltered" => count($arr),
          				"data"=>$arr);

					echo json_encode($results);
				} else {
					header("HTTP/1.0 404 Not Found");
		    		 echo '{"data": '+$mysqli->error+'}';
				}
			}
	} else {
		    header("HTTP/1.0 404 Not Found");
		    echo '{"data": "Empty PostData"}';
	}
}	
	catch (Exception $e) {
	    header("HTTP/1.1 500 Internal Server Error");
	    echo '{"data": "Exception occurred: '.$e->getMessage().'"}';
}

?>
