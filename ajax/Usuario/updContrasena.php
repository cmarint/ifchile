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
                session_start();
                $passwordsel = null;
                $id = $_SESSION["user_id"];
                $oldpassword = $request['OLDPASSWORD'];
                $password = $request['PASSWORD'];
                if (array_key_exists('PASSWORD', $request)) {
                    $query="SELECT Password FROM usuario where id = ". $id;
                    if($result = $mysqli->query($query))
				    {
                        while($row = $result->fetch_assoc()) {
                            $arr[] = $row;
				            $passwordsel = $row['Password'];	
                            break;
						}
                        if ($passwordsel == md5($oldpassword)) {
                            $query2 = "UPDATE usuario SET Password = '" . md5($password) . "' WHERE Id=" . $id;
                            if ($result = $mysqli->query($query2)) {
                                $resulta = array(
                                "draw" => 1,
                                "recordsTotal" => count($arr),
                                "recordsFiltered" => count($arr),
                                "data"=>"Contraseña actualizada");
                                echo json_encode($resulta);
                            } else {
                                header("HTTP/1.0 404 Not Found");
		    		            echo '{"data": '+$mysqli->error+'}';
                            }
                            
  
                        } else {
                             $resulta = array(
            			     "draw" => 1,
        				     "recordsTotal" => count(0),
        				     "recordsFiltered" => count(0),
          				     "data"=>"No fue posible actualizar la contraseña");
                            echo json_encode($resulta);
                        }
					   
				    }
				    else
				    {
					   header("HTTP/1.0 404 Not Found");
		    		   echo '{"data": '+$mysqli->error+'}';
				    }   
                } else {
                    header("HTTP/1.0 404 Not Found");
		    		echo '{"data": informacion no enviada }';
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