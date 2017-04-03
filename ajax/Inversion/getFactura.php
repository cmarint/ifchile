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
                @$Accion = $request->Accion;
			    @$oWhere ='';  	
                //print_r($request);
                
			    if($Estado==5){$oWhere = 'WHERE estadofactura.Id='.$Estado;}
			    else{$oWhere = 'WHERE estadofactura.Id IN (2, 4, 6, 7, 8)';}		
			    
                
                if ($Accion == 0) // Lista
                {
                    $str = "SELECT factura.Id, factura.Monto, factura.Emisor, factura.Glosa, factura.Receptor, factura.Descuento, factura.UtilidadEsperada, factura.UtilidadReal, factura.FechaPublicacion, factura.FechaPago, factura.FechaVencimiento, factura.PlazoPago, factura.DiasPago, factura.ImagenFactura,factura.DescuentoSeguro,factura.UtilidadEsperadaSeguro,factura.Comentario,factura.FechaExpiracion ,estadofactura.Id as Estado, estadofactura.Descripcion as DescripcionEstado, orden.isSeguro,orden.FechaCompra,orden.Participacion,usuario.Nombre as Usuario";
                } 
                else //Total 
                {
                    $str = "SELECT ROUND(SUM(factura.MontoInvertido)) as MontoTotal";
                }
                
                
                session_start();
                
                
                
				$query= $str . " FROM factura INNER JOIN facturaestado ON factura.Id = facturaestado.IdFactura 
					INNER JOIN orden ON factura.Id = orden.IdFactura
					INNER JOIN usuario ON usuario.Id = orden.IdUsuario 
					INNER JOIN estadofactura ON facturaestado.IdEstado = estadofactura.Id ". $oWhere . " AND orden.IdUsuario =".$_SESSION["user_id"];
				
                //echo $query;

				$result =$mysqli->query($query);
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
