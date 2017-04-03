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
                if (array_key_exists('nombre', $request))
                {
                    $largo = sizeof($request['nombre']);
                    $query = "";
                    for ($i=0;$i<$largo;$i++)
                    {
                        $query = "INSERT INTO anexo (IdFactura, Ruta) VALUES (".$request['idFactura'].",'./uploads/".$request['nombre'][$i]."')";
                        //echo $query."<br>";
                        $mysqli->query($query);
                    }
                }
			   
              // echo sizeof($request['nombre']);
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