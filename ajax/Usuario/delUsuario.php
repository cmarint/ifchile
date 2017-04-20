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

			   @$ID = $request->ID;


                $COUNT = 0;
                $qordenes = "SELECT COUNT(1) as contador FROM orden WHERE IdUsuario = $ID";
                $resultado = $mysqli->query($qordenes);
                while($row = $resultado->fetch_assoc()) {
                        $COUNT = $row["contador"];
                }

                if ($COUNT <= 0) {
                    $query="delete from usuario where id=$ID";
                    if($mysqli->query($query))
                    {
                        echo $json_response = json_encode($mysqli->affected_rows);
                    }
                    else
                    {
                         header("HTTP/1.0 404 Not Found");
                         echo '{"data": '+$mysqli->error+'}';
                    }
                } else {
                    header("HTTP/1.0 404 Not Found");
                    echo '{"data": "Usuario tiene ordenes existentes"}';
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
