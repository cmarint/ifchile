<?php 
	try{
		require_once("../../php/conexion.php");
		$postdata = file_get_contents("php://input");
		    $request = json_decode($postdata);
		    if($request==NULL)
		    {
		    	header("HTTP/1.0 404 Not Found");
		    	echo '{"data": "Not Json Data"}';
		    }
		    else
		    {   
            
                    $query = "SELECT count(1) as Cantidad  FROM usuario WHERE IdPerfil = 3
                    UNION ALL
                    SELECT count(DISTINCT usuario.Id) as Cantidad  FROM usuario INNER JOIN orden ON usuario.Id = orden.IdUsuario WHERE usuario.IdPerfil = 3
                    UNION ALL
                    SELECT count(DISTINCT usuario.Id) as Cantidad FROM usuario WHERE usuario.Id NOT IN (SELECT orden.IdUsuario FROM orden) AND usuario.IdPerfil = 3";
				
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
