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
			    @$oWhere ='';  	
                
                if($Estado == 0)
				{
					$oWhere = '';
                    //$oWhere = 'WHERE estadofactura.Id > 1';
				}
			    elseif(($Estado == 1) || ($Estado == 2) || ($Estado == 3) || ($Estado == 4) || ($Estado == 5) || ($Estado == 6) || ($Estado == 7) || ($Estado == 8))
				{
					$oWhere = 'WHERE estadofactura.Id='.$Estado;
                    //$oWhere = 'WHERE estadofactura.Id > 1';
				}
                elseif($Estado == 4678)
                {
                    $oWhere = 'WHERE estadofactura.Id IN (4, 6, 7, 8)';
                }
			    @$query="";
                
                //echo $oWhere;
                //echo $Estado;
                
				if(($Estado == 2) || ($Estado == 5) || ($Estado == 4) || ($Estado == 6) || ($Estado == 7) || ($Estado == 8) || ($Estado == 4678)) //Todas Compradas
				{
					$query="SELECT factura.Id, factura.Monto, factura.Emisor, factura.Glosa, factura.Receptor, factura.Descuento, factura.UtilidadEsperada, factura.UtilidadReal, factura.FechaPublicacion, factura.FechaPago, factura.FechaVencimiento, factura.PlazoPago, factura.DiasPago, factura.ImagenFactura,factura.DescuentoSeguro,factura.UtilidadEsperadaSeguro,factura.Comentario,factura.FechaExpiracion ,estadofactura.Id as Estado, estadofactura.Descripcion as DescripcionEstado, orden.isSeguro,orden.FechaCompra as FechaCompra,orden.Participacion, usuario.Correo as Usuario,
                    factura.MontoMora, factura.TasaMora
					FROM factura INNER JOIN facturaestado ON factura.Id = facturaestado.IdFactura 
					INNER JOIN orden ON factura.Id = orden.IdFactura
					INNER JOIN usuario ON usuario.Id = orden.IdUsuario
					INNER JOIN estadofactura ON facturaestado.IdEstado = estadofactura.Id ".$oWhere;
                    
				}
				else{
					$query="SELECT factura.Id, factura.Monto, factura.Emisor, factura.Glosa, factura.Receptor, factura.Descuento, factura.UtilidadEsperada, factura.UtilidadReal, factura.FechaPublicacion, factura.FechaPago, factura.FechaVencimiento, factura.PlazoPago, factura.DiasPago, estadofactura.Descripcion as DescripcionEstado,  factura.ImagenFactura,factura.DescuentoSeguro,factura.UtilidadEsperadaSeguro,factura.Comentario,factura.FechaExpiracion as FechaExp ,estadofactura.Id as Estado  FROM factura INNER JOIN facturaestado ON factura.Id = facturaestado.IdFactura INNER JOIN estadofactura ON facturaestado.IdEstado = estadofactura.Id ".$oWhere;
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
