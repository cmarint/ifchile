<?php 
	try{
		require_once("../../php/conexion.php");
		$postdata = file_get_contents("php://input");
		    $request = json_decode($postdata, true);
            //print_r($request);
		    if($request==NULL)
		    {
		    	header("HTTP/1.0 404 Not Found");
		    	echo '{"data": "Not Json Data"}';
		    }
		    else
		    {   
               
                    $query = "SELECT f.Id, f.Monto, o.FechaCompra, f.UtilidadReal, ef.Descripcion, f.MontoInvertido, u.Nombre FROM factura f, orden o, usuario u, facturaestado fe, estadofactura ef WHERE f.Id = o.IdFactura
                    AND f.Id = fe.IdFactura AND fe.IdEstado = ef.Id AND o.IdUsuario = u.Id AND u.Id = ".$request['Id'];
                
                    
                //echo $query;

				$result = $mysqli->query($query);
                
				if($result)
				{
					if($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
		
							$arr[] =  $row;	
						}

						$results = array(
            			"draw" => 1,
        				"recordsTotal" => count($arr),
        				"recordsFiltered" => count($arr),
          				"data"=>$arr);
					}
					else
					{
						$results = array(
            			"draw" => 1,
        				"recordsTotal" => count(0),
        				"recordsFiltered" => count(0),
          				"data"=>0);

					}
					
					
					echo json_encode($results);
				}
				else
				{
					 header("HTTP/1.0 404 Not Found");
		    		 echo '{"data": '+$mysqli->error+' 111}';
				}
				
			}
	
	}
	catch (Exception $e) {
	    header("HTTP/1.1 500 Internal Server Error");
	    echo '{"data": "Exception occurred: '.$e->getMessage().'"}';
}
?>
