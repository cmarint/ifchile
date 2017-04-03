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
			    @$Estado = $request->Estado;
                $oWhere = "";
                $Estado = $Estado * 1;
                
                switch ($Estado) {
                    case 1:
                        $oWhere = "IN (1, 3)";
                        break;
                    case 2: //Pendiente de Pago
                        $oWhere = "IN (2, 3, 4)";
                        break;
                    case 3: //Expirada
                        $oWhere = "IN (1, 3)";
                        break;
                    case 4: //Vigente
                        $oWhere = "IN (2, 3, 4, 5, 6)";
                        break;
                    case 5: //Pagada
                        $oWhere = "= 5";
                        break;
                    case 6: //Morosa
                        $oWhere = "IN (5, 6, 7, 8)";
                        break;
                    case 7: //Castigo
                        $oWhere = "IN (5, 7, 8)";
                        break;
                    case 8: //Judicial
                        $oWhere = "IN (5, 8)";
                        break;    
                    
                }
                
				$query="SELECT Id, Descripcion FROM estadofactura WHERE Id " . $oWhere;
				

				$result =$mysqli->query($query);
				if($result)
				{
					if($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
		
							$arr[] =  $row;	
						}
					}

					echo json_encode($arr);
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
