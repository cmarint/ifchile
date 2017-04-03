<?php 
	try{
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
			    @$ID = $request->Id;  			
                

				$query="DELETE FROM facturaestado WHERE IdFactura = $ID";
				
				if($mysqli->query($query))
				{
                     
                    $query="DELETE FROM factura WHERE Id =  $ID";
                    
					if($mysqli->query($query))
				    {
                       wlog("Elimina factura $ID", $mysqli); //Logeo
                        if($mysqli->affected_rows>=1)
                            $estadoArray = array("Estado"=>true);
                        else
                            $estadoArray = array("Estado"=>false,"Error"=>"Error al Eliminar Factura");

                        echo $json_response = json_encode($estadoArray);
				    }
                    else
                    {
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
