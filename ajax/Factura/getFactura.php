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
                /**** EXPIRAR FACTURAS QUE NO HAN SIDO COMPRADAS *****/
                $expiro = "SELECT factura.Id from factura, facturaestado 
                            WHERE factura.FechaExpiracion < CURDATE()
                            AND factura.Id = facturaestado.IdFactura
                            AND facturaestado.IdEstado = 1";
                $expiradas =$mysqli->query($expiro);
				if($expiradas)
				{
					if($expiradas->num_rows > 0) {
						while($row = $expiradas->fetch_assoc()) {
                            $expirar = "UPDATE facturaestado SET idEstado = 3 WHERE idFactura=".$row["Id"];
                            $mysqli->query($expirar);
						}

					}                
                }
                /**** EXPIRAR FACTURAS QUE NO HAN SIDO COMPRADAS *****/
                
                /**** FACTURAS MOROSAS QUE NO HAN SIDO PAGADAS *****/
                $expiro = "SELECT factura.Id from factura, facturaestado 
                            WHERE factura.FechaVencimiento < CURDATE()
                            AND factura.Id = facturaestado.IdFactura
                            AND facturaestado.IdEstado = 4";
                $expiradas =$mysqli->query($expiro);
				if($expiradas)
				{
					if($expiradas->num_rows > 0) {
						while($row = $expiradas->fetch_assoc()) {
                            $expirar = "UPDATE facturaestado SET idEstado = 6 WHERE idFactura=".$row["Id"];
                            $mysqli->query($expirar);
						}

					}                
                }
                /**** FACTURAS MOROSAS *****/
                
			    @$Estado = $request->Estado;
			    @$oWhere ='';  	
			    if($Estado == 1)
				{
					$oWhere = 'WHERE estadofactura.Id IN (1, 3)';
                    //$oWhere = 'WHERE estadofactura.Id > 1';
				}
                else if ($Estado == 0)
                {
                    $oWhere = 'WHERE estadofactura.Id = 1';
                }
			    else{$oWhere = 'WHERE estadofactura.Id IN (2, 4, 5, 6, 7, 8)';}	//Cuando estado es comprada	
			    @$query="";
                
                //echo $oWhere;
                //echo $Estado;
                
				if($Estado == 2) //Compradas
				{
					$query="SELECT factura.Id, factura.Monto, factura.Emisor, factura.Glosa, factura.Receptor, factura.Descuento, factura.UtilidadEsperada, factura.UtilidadReal, factura.FechaPublicacion, factura.FechaPago, factura.FechaVencimiento, factura.PlazoPago, factura.DiasPago, factura.FechaTransferencia,  factura.ImagenFactura,factura.DescuentoSeguro,factura.UtilidadEsperadaSeguro,factura.Comentario,factura.FechaExpiracion ,estadofactura.Id as Estado, estadofactura.Id as EstadoOld, estadofactura.Descripcion as DescripcionEstado, orden.isSeguro,orden.FechaCompra,orden.Participacion,usuario.Nombre as Usuario
					FROM factura INNER JOIN facturaestado ON factura.Id = facturaestado.IdFactura 
					INNER JOIN orden ON factura.Id = orden.IdFactura
					INNER JOIN usuario ON usuario.Id = orden.IdUsuario
					INNER JOIN estadofactura ON facturaestado.IdEstado = estadofactura.Id ".$oWhere;
                    
				}
				else{
					$query="SELECT factura.Id, factura.Monto, factura.Emisor, factura.Glosa, factura.Receptor, factura.Descuento, factura.UtilidadEsperada, factura.UtilidadReal, factura.FechaPublicacion, factura.FechaPago, factura.FechaVencimiento, factura.PlazoPago, factura.DiasPago, factura.FechaTransferencia,  factura.ImagenFactura,factura.DescuentoSeguro,factura.UtilidadEsperadaSeguro,factura.Comentario,factura.FechaExpiracion as FechaExp ,estadofactura.Id as Estado, DATEDIFF(factura.FechaExpiracion,NOW()) AS DiasExpiracion, DATEDIFF(factura.FechaVencimiento,NOW()) AS DiasVencimiento, 
                    ROUND(factura.Monto * factura.Descuento / 100 / 30 * DATEDIFF(factura.FechaVencimiento,NOW())) AS UtilidadSin,
                     ROUND(factura.Monto * factura.DescuentoSeguro / 100 / 30 * DATEDIFF(factura.FechaVencimiento,NOW())) AS UtilidadCon,
                    ROUND(factura.Monto - (factura.Monto * factura.Descuento / 100 / 30 * DATEDIFF(factura.FechaVencimiento,NOW()))) AS MontoInvertirSin,
                    ROUND(factura.Monto - (factura.Monto * factura.DescuentoSeguro / 100 / 30 * DATEDIFF(factura.FechaVencimiento,NOW()))) AS MontoInvertirCon,
                    estadofactura.Descripcion as EstadoDescripcion,
                    SUBSTRING(ImagenFactura,LENGTH(ImagenFactura)-2,3) AS Extension 
                    FROM factura INNER JOIN facturaestado ON factura.Id = facturaestado.IdFactura INNER JOIN estadofactura ON facturaestado.IdEstado = estadofactura.Id ".$oWhere;
                    
                    //$Utilidad = (($Monto * ($Descuento/100))/30)*$dias;
				}
				
                
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
