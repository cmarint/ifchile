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
		    	@$Perfil = $request->Perfil;
			    @$oWhere ='';  	
			    if($Perfil==3){
			    	$oWhere = 'and u.IdPerfil = '.$Perfil;
			    } else {
			    	$oWhere = 'and u.IdPerfil != 3';
			    }

				$query= "select u.ID as ID, 
							u.NOMBRE as NOMBRE, 
        					u.USUARIO as USUARIO, 
        					u.CORREO as CORREO,
                            case 
                                when u.Estado = 1 then 'true'
                                when u.Estado = 0 then 'false'
                            end as ESTADO,
        					u.TIPOPER as TIPOPER,
        					u.RUT as RUT,
        					u.DIRECCION as DIRECCION,
        					p.DESCRIPCION as DESCRIPCION
 								from usuario u, perfil p 
 									where u.idPerfil = p.id ".$oWhere;
				$result = $mysqli->query($query);
				//$arr = array();
				if ($result)
				{
					if($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
						//array_push($arr,array("ID" => $row["ID"]));
						$arr[] =  $row;	
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
