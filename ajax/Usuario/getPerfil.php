<?php
//include "../include/function.php";
//session_start();
//if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
//	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
//}
try
{
	require_once("../../php/conexion.php");
	$query= "select ID, DESCRIPCION from perfil";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	//$arr = array();
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$arr[] =  $row;	
		}
	}

	echo json_encode($arr, JSON_FORCE_OBJECT);
}
catch (Exception $e) {
	    header("HTTP/1.1 500 Internal Server Error");
	    echo '{"data": "Exception occurred: '.$e->getMessage().'"}';
}
?>
