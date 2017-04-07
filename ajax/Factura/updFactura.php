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
                
			    @$ID = $request->ID;  		
				$datenow = date_create('now')->format('Y-m-d H:i:s');
                
                $datetime1 = new DateTime($request->FechaVencimiento);
                $datetime2 = new DateTime();
                $interval = $datetime1->diff($datetime2);
                $dias = $interval->d;
                $Monto = $request->Monto;
                if (array_key_exists('isSeguro', $request))
                {
                    $isSeguro = $request->isSeguro;
                    if ($isSeguro == 0) {
                        $Descuento = $request->Descuento;
                    } else {
                        $Descuento = $request->DescuentoSeguro;
                    }
                     $Utilidad = 0;
                
                    $Utilidad = (($Monto * ($Descuento/100))/30)*$dias;
                }
                
                
               
                    
				if( $request->estadoUpd ==1)//Update desde Publicadas
				{
					$FchExp = date_format(date_create(substr($request->FechaExp,0,10)), 'Y-m-d H:i:s');
                    $FchVenc = date_format(date_create(substr($request->FechaVencimiento,0,10)), 'Y-m-d H:i:s');
                    
					//$FchExp = date_format(date_create_from_format('d/m/Y',  $request->FechaExpiracion), 'Y-m-d H:i:s');			
                    //$FchVenc = date_format(date_create_from_format('d/m/Y', $request->FechaVencimiento), 'Y-m-d H:i:s');	

					$query="UPDATE factura SET Monto='$request->Monto',Emisor='$request->Emisor',Glosa='$request->Glosa',Receptor='$request->Receptor',Descuento=$request->Descuento,UtilidadEsperada=$request->UtilidadEsperada,UtilidadReal=null,FechaPago=null,FechaVencimiento='$FchVenc',PlazoPago=null,DiasPago=$request->DiasPago,ImagenFactura='$request->ImagenFactura',DescuentoSeguro=$request->DescuentoSeguro,UtilidadEsperadaSeguro=$request->UtilidadEsperadaSeguro,Comentario='$request->Comentario',FechaExpiracion='$FchExp' WHERE Id= $request->Id";
                    
                    //Datos de logeo
                    $accion = "Actualiza Factura $request->I, Monto=$request->Monto,Emisor=$request->Emisor,Glosa=$request->Glosa,Receptor=$request->Receptor,Descuento=$request->Descuento,UtilidadEsperada=$request->UtilidadEsperada,UtilidadReal=null,FechaPago=null,FechaVencimiento=$FchVenc,PlazoPago=null,DiasPago=$request->DiasPago,ImagenFactura=$request->ImagenFactura,DescuentoSeguro=$request->DescuentoSeguro,UtilidadEsperadaSeguro=$request->UtilidadEsperadaSeguro,Comentario=$request->Comentario,FechaExpiracion=$FchExp";
				}
				else
				{
					if(($request->estadoUpd ==2)||($request->estadoUpd ==3))//Update desde Compradas
					{
						$query="UPDATE factura SET Comentario='$request->Comentario' WHERE Id= $request->Id";
				        $accion = "Actualiza factura $request->Id, Comentario=$request->Comentario";
					} 
                    
                    
				}


				if($mysqli->query($query))
				{
					wlog($accion, $mysqli); //Logeo
					$query = "Update facturaestado set IdEstado= $request->Estado,Usuario= 'u', Fecha='$datenow' WHERE IdFactura= $request->Id";
                    
					if($mysqli->query($query))
					{
                        wlog("Actualiza estado de factura $request->Id, IdEstado= $request->Estado", $mysqli); //Logeo
                        if ($request->Estado == 3) {
                            $query2 = "DELETE FROM orden WHERE IdFactura = $request->Id";
                            //echo $query2;
                            if($mysqli->query($query2))
					        {
                                echo $json_response = json_encode($mysqli->affected_rows);
                            } else {
                                header("HTTP/1.0 404 Not Found");
		    			       echo '{"data": '+$mysqli->error+'}';
                            }
                        }
                        elseif ($request->Estado == 4) {
                             $query2 = "UPDATE factura SET FechaTransferencia = NOW(),
                                        UtilidadEsperadaSeguro = (Monto * DescuentoSeguro / 100 / 30 * DATEDIFF(FechaVencimiento,NOW())),
                                        UtilidadEsperada = (Monto * Descuento / 100 / 30 * DATEDIFF(FechaVencimiento,NOW()))  WHERE Id= $request->Id";
                             if($mysqli->query($query2))
					        {
                                echo $json_response = json_encode($mysqli->affected_rows);
                            } else {
                                header("HTTP/1.0 404 Not Found");
		    			       echo '{"data": '+$mysqli->error+'}';
                            }
                        }
                        elseif ($request->Estado == 5) {
                            if ($request->estadoUpd == 3) { //Si está en mora y pasa a "Pagada"
                                $query2 = "UPDATE factura SET FechaPago = NOW(),TasaMora = $request->TasaMora, 
                                UtilidadReal = ((Monto * $Descuento / 100 / 30 * DATEDIFF(FechaVencimiento,(SELECT FechaCompra FROM orden WHERE IdFactura=$request->Id))) + (Monto * $request->TasaMora / 100 / 30 * DATEDIFF(NOW(), FechaVencimiento))),
                                MontoMora = (Monto * $request->TasaMora / 100 / 30 * DATEDIFF(NOW(), FechaVencimiento))
                                WHERE Id= $request->Id";
                            } else {
                                $query2 = "UPDATE factura SET FechaPago = NOW(),UtilidadReal = (Monto * $Descuento / 100 / 30 * DATEDIFF(FechaVencimiento,(SELECT FechaCompra FROM orden WHERE IdFactura=$request->Id))) WHERE Id= $request->Id";   
                            }
                                //echo "Query: [".$query2."]";                            //echo $query2;
                            if($mysqli->query($query2))
					        {
                                echo $json_response = json_encode($mysqli->affected_rows);
                            } else {
                                header("HTTP/1.0 404 Not Found");
		    			       echo '{"data": '+$mysqli->error+'}';
                            }
                        }
						
					}
					else
						{ 
							header("HTTP/1.0 404 Not Found");
		    			    echo '{"data": '+$mysqli->error+'}';
						}
				}
				else
				{
                    //echo $mysqli->error;
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
