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
			   //@ID = $request->ID;
               //echo $request->PASSWORD;
                $activo = 0;
                if ($request['toggleValue']) {
                    $activo = 1;
                }
                
                if (array_key_exists('PASSWORD', $request)) {
                    $query="UPDATE usuario set Attemp=5, Estado = ".$activo.", Password = '".md5($request['PASSWORD'])."' where id = ". $request['ID'];
                } else {
                     $query="UPDATE usuario set Attemp=5, Estado = ".$activo." where id = ". $request['ID'];
                }
				echo "[".$query."]";
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