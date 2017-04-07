<?php

if(!empty($_GET)){
	if(isset($_GET["username"]) &&isset($_GET["password"])){
		if($_GET["username"]!=""&&$_GET["password"]!=""){
			require_once("conexion.php");
            $get_username = $_GET["username"];
            $get_password = md5($_GET["password"]);
            
			$user_id=null;
			$user_nombre = null;
			$user_rol=null;
            $user_mail=null;
            $id = null;
            $attemp = null;
			$sql1= "select Id, Attemp from usuario where (usuario=\"$get_username\" or correo=\"$get_username\") and estado=1";

            
			$result = $mysqli->query($sql1) or die($mysqli->error.__LINE__);
			while ($r = mysqli_fetch_array($result, MYSQLI_NUM)) {
				$id=$r[0];
				$attemp=$r[1];
				break;
			}
			if($id==null){
                echo "<div class=\"alert alert-danger\"><strong>Usuario No Existe o está Inactivo</strong></div>";
			}else{
                $user_id=null;
                $sql2= "select u.ID, u.NOMBRE, p.DESCRIPCION, u.idPerfil, u.Correo from usuario u, perfil p where (u.usuario=\"$get_username\" or u.correo=\"$get_username\") and u.password='".$get_password."' and u.estado=1 and u.idPerfil = p.id";
                
                 $result2 = $mysqli->query($sql2) or die($mysqli->error.__LINE__);
			     while ($r = mysqli_fetch_array($result2, MYSQLI_NUM)) {
                    $user_id=$r[0];
                    $user_nombre=$r[1];
                    $user_rol=$r[2];
                    $user_idPerfil=$r[3];
                    $user_mail=$r[4];
                    break;
			     }
                
                 if ($user_id==null) {
                     $attemp--;
                     if ($attemp >= 0) {
                        $sql3 = "update usuario set attemp = " . $attemp . " where Id=$id";           
                        echo "<div class=\"alert alert-danger\"><strong>Error:</strong>Contraseña Inválida. Le quedan (". $attemp . ") Intentos</div>";
                     } else {
                        $sql3 = "update usuario set estado=0 where Id=$id";
                        echo "<div class=\"alert alert-danger\"><strong>Error:</strong>Contraseña Inválida. Por seguridad el usuario ha sido bloqueado.<br>Contacte al Administrador.</div>";
                     }
                     $result3=$mysqli->query($sql3) or die($mysqli->error.__LINE__);
                 } else {
                     $sql3 = "update usuario set attemp = 5 where Id=$id";
                     $result3=$mysqli->query($sql3) or die($mysqli->error.__LINE__);
                            session_start();
                            $_SESSION["user_id"]=$user_id;
                            $_SESSION["rol"]=$user_rol;
                            $_SESSION["user_nombre"]=$user_nombre;
                            $_SESSION["idPerfil"]=$user_idPerfil;
                            $_SESSION["user_mail"]=$user_mail;
                            $_SESSION["loggedin"] = time();
                            if ($user_idPerfil == 3) {
                                echo "OK3";
                            }
                            elseif ($user_idPerfil == 2) {
                                echo "OK2";
                            } else {
                                //echo "<script>window.location='../reporte.php';</script>";
                                echo "OK1";
                            }
                 } // else
			} // else
		}
	}
} else {
    echo "Error GET";
}



?>
