<?php 
	try{
		require_once("../../php/conexion.php");
		$postdata = file_get_contents("php://input");
        echo $postdata;
		if(!empty($postdata)){	

		    $request = json_decode($postdata);
		    if($request==NULL)
		    {
		    	header("HTTP/1.0 404 Not Found");
		    	echo '{"data": "Not Json Data"}';
		    }
		    else
		    {
			   @$NOMBRE = $request->nombre;
               @$perfil = $request->perfiles;
                $COUNT = 0;
                
                $query_id = "SELECT COUNT(1) as contador FROM usuario WHERE Rut = '".$request->rut."' OR Usuario = '".$request->nombreusuario."' OR Correo = '".$request->email."'";
                
                $resultado = $mysqli->query($query_id);
                while($row = $resultado->fetch_assoc()) {
                        $COUNT = $row["contador"];
                }
                
                //echo "Contador:".$COUNT;
                if ($COUNT > 0) { //El Usuario o Rut o Correo ya existe
                    header("HTTP/1.0 404 Not Found");
                    //echo '{"data": "Not Json Data"}';
                } else {
                
                    $query="INSERT INTO usuario(Tipoper,Rut,Nombre,Usuario,Correo,Estado,IdPerfil,Attemp,Password) VALUES ('A','".$request->rut."','".$request->nombre."','".$request->nombreusuario."','".$request->email."',1,".$perfil.",5,'".md5($request->password)."')";

                    if($mysqli->query($query))
                    {
                        echo $json_response = json_encode($mysqli->affected_rows);
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