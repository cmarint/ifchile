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
			   
				$datenow = date_create('now')->format('Y-m-d H:i:s');
                
                $FchExp = date_format(date_create(substr($request->FechaExpiracion2,0,10)), 'Y-m-d H:i:s');
                $FchVenc = date_format(date_create(substr($request->FechaVencimiento,0,10)), 'Y-m-d H:i:s');
          
				/*$FchExp = date_format(date_create_from_format('d/m/Y',  substr($request->FechaExpiracion2,0,10)), 'Y-m-d H:i:s');
					
				$FchVenc = date_format(date_create_from_format('d/m/Y', $request->FechaVencimiento), 'Y-m-d H:i:s');*/

				
				$query="INSERT INTO factura( Monto, Emisor, Glosa, Receptor, Descuento, UtilidadEsperada, UtilidadReal, FechaPublicacion, FechaPago, FechaVencimiento, PlazoPago, DiasPago, ImagenFactura,DescuentoSeguro, UtilidadEsperadaSeguro, Comentario, FechaExpiracion) VALUES ($request->Monto , '$request->Emisor' , '' , '$request->Receptor' , $request->Descuento , $request->UtilidadEsperada , null , '$datenow' , null , '$FchVenc' , null , $request->DiasPago , '$request->ImagenFactura', $request->DescuentoSeguro, $request->UtilidadEsperadaSeguro, '$request->Comentario', '$FchExp' )";
				
                
				if($mysqli->query($query))
				{
                    $ID = $mysqli->insert_id;
                    wlog("Agrega factura Monto:$request->Monto, Emisor:$request->Emisor, Pagador:$request->Receptor, Descuento:$request->Descuento, Vencimiento: $FchVenc, Dias Pago: $request->DiasPago, Descuento Seguro: $request->DescuentoSeguro, Expira: $FchExp", $mysqli); //Logeo
                    
					
					$query = "INSERT INTO facturaestado(IdFactura, IdEstado, Usuario, Fecha) VALUES ($ID,$request->Estado,'u','$datenow')";
					if($mysqli->query($query))
					{
                         //wlog("ACCION: [$query]"); //Logeo
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
