<?php 
	try{
		require_once("../../php/conexion.php");
		$postdata = file_get_contents("php://input");
        //echo $postdata;
		if(!empty($postdata)){	

		    $request = json_decode($postdata, true);
		    if($request==NULL)
		    {
		    	header("HTTP/1.0 404 Not Found");
		    	echo '{"data": "Not Json Data"}';
		    }
		    else
		    {
                
                $COUNT = 0;
                
                $query_id = "SELECT COUNT(1) as contador FROM usuario WHERE Rut = '".$request['rut']."' OR Usuario = '".$request['username']."' OR Correo = '".$request['email']."'";
                
                $resultado = $mysqli->query($query_id);
                while($row = $resultado->fetch_assoc()) {
                        $COUNT = $row["contador"];
                }
                
                if ($COUNT > 0) { //El Usuario o Rut o Correo ya existe
                    echo "Ya existe";
                    header("HTTP/1.0 404 Not Found");
                    echo '{"data": "Not Json Data"}';
                } else {
                
                                    $query="INSERT INTO usuario(Tipoper,Rut,Nombre,Usuario,Correo,Estado,IdPerfil,Attemp,Password, Direccion) VALUES ('A','".$request['rut']."','".$request['nombre']."','".$request['username']."','".$request['email']."',1,3,5,'".md5($request['password'])."','".$request['direccion']."')";
                                    
                                    $datenow = date_create('now')->format('Y-m-d H:i:s');
                                    
                                    $para = $request['email'];
                                    $titulo = '[MISGANANCIAS.COM] - Bienvenida';
                                    $mensaje= "
                                     <html>
                                        <head>
                                          <link rel=\"stylesheet\" type=\"text/css\" href=\"".$_SERVER['HTTP_HOST']."/ifchile/content/bootstrap/css/bootstrap.min.css\">
                                          <title>Bienvenido</title>
                                        </head>
                                        <body>
                                        <p>MisGanancias.com le da la m&aacute;s cordial bienvenida a su plataforma de inversi&oacute;n y le</p> <p>invita a disfrutar de las mejores alternativas de inversi&oacute;n que tenemos disponibles para</p> 
                                        <p>nuestros inversionistas. Le informamos que con fecha ".$datenow.", fue creado</p>
                                        <p>su usuario de acceso a nuestra plataforma con los siguientes datos:</p>
                                        <table border=\"0\" cellspacing=\"5\" cellpadding=\"2\">
                                        <tr><th>Nombre o Raz&oacute;n Social:</th><td>".$request['nombre']."</td></tr>
                                        <tr><th>RUT:</th><td>".$request['rut']."</td></tr>
                                        <tr><th>Usuario:</th><td>".$request['username']."</td></tr>
                                        <tr><th>Clave de acceso:</th><td>".$request['password']."</td></tr>
                                        </table>
                                        <p>En los pr&oacute;ximos minutos un ejecutivo de inversi&oacute;n lo contactar&aacute; para resolver</p> <p>cualquier inquietud y lo acompa&ntilde;ar&aacute; a conocer nuestra plataforma de inversi&oacute;n.</p>
                                        <br>
                                        <p>Le saluda atentamente, MisGanancias.com.</p>    
                                        </body>
                                    </html>
                                    ";
                                    
                                    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                                    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                    $cabeceras .= 'From: Info MISGANANCIAS.COM <contacto@MISGANANCIAS.com>' . "\r\n";
                                    
                                    $querymail = "SELECT Correo FROM usuario WHERE IdPerfil IN (1, 2)";
                                    $resultmail = $mysqli->query($querymail) or die($mysqli->error.__LINE__);
                                    $correos = "";
                                    while ($r = mysqli_fetch_array($resultmail, MYSQLI_NUM)) {
                                        $correos .= 'Cc: '.$r[0]. "\r\n";
                                    }
                                    $cabeceras .= $correos;
                            
                                    mail($para, $titulo, $mensaje, $cabeceras);
                    
                    

                                    if($mysqli->query($query))
                                    {
                                        $query2 = "SELECT id FROM usuario WHERE Usuario = '".$request['username']."' AND Correo='".$request['email']."'";

                                        $resultado = $mysqli->query($query2);
                                        while($row = $resultado->fetch_assoc()) {
                                            $IDUSUARIO = $row["id"];
                                        }  
                                        //echo $json_response = json_encode($mysqli->affected_rows);
                                        if (array_key_exists('representante', $request))
                                        {
                                            $largo_rep = sizeof($request['representante']['nomrep']);
                                            $query_rep = "";
                                            for ($i=0;$i<$largo_rep;$i++)
                                            {
                                                $query_rep = "INSERT INTO representante (Rut, Nombre, IdUsuario) VALUES ('".$request['representante']['rutrep'][$i]."','".$request['representante']['nomrep'][$i]."',".$IDUSUARIO.")";
                                                $mysqli->query($query_rep);
                                            }
                                        }

                                        if (array_key_exists('socio', $request)) 
                                        { 
                                            $largo_soc = sizeof($request['socio']['nomsoc']);
                                            $query_soc = "";
                                            for ($i=0;$i<$largo_soc;$i++)
                                            {
                                                $query_soc = "INSERT INTO socio (Rut, Nombre, IdUsuario) VALUES ('".$request['socio']['rutsoc'][$i]."','".$request['socio']['nomsoc'][$i]."',".$IDUSUARIO.")";
                                                $mysqli->query($query_soc);
                                            }
                                        }

                                        if (array_key_exists('cuenta', $request)) 
                                        { 
                                            $largo_cta = sizeof($request['cuenta']['bancocuenta']);
                                            $query_cta = "";
                                            for ($i=0;$i<$largo_cta;$i++)
                                            {
                                                $query_cta = "INSERT INTO usuariocuenta (IdBanco, IdUsuario, TipoCuenta, Cuenta) VALUES ('".$request['cuenta']['bancocuenta'][$i]['CODIGO']."',".$IDUSUARIO.",'".$request['cuenta']['tipocuenta'][$i]."','".$request['cuenta']['numecuenta'][$i]."')";
                                                $mysqli->query($query_cta);
                                            }
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
            echo "Sin data";
		    header("HTTP/1.0 404 Not Found");
		    echo '{"data": "Empty PostData"}';
		}
	}
	catch (Exception $e) {
	    header("HTTP/1.1 500 Internal Server Error");
	    echo '{"data": "Exception occurred: '.$e->getMessage().'"}';
}
?>
