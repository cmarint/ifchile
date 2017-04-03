<?php
try
{
	require_once("../../php/conexion.php");
	$postdata = file_get_contents("php://input");
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
		    	//echo "ID:".$request['ID'];
				$query= "SELECT DISTINCT(b.des_sbif) as BANCO, u.Cuenta as CUENTA, 
							 case 
                                when u.TipoCuenta = 'CC' then 'Cuenta Corriente'
                                when u.TipoCuenta = 'CV' then 'Cuenta Vista'
                                when u.TipoCuenta = 'CA' then 'Cuenta Ahorro'
                            end as TIPO
                            FROM usuariocuenta u, bancos b  
                                WHERE u.IdBanco = b.cod_sbif
                                    AND u.IdUsuario = ".$request;
                
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
