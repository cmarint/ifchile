<?php
/*$DB_HOST="localhost";
$DB_USER="capitali_wp514";
$DB_PASS="(F3S7Z1p@p";
$DB_NAME="capitali_wp514";
*/

$DB_HOST = 'localhost';
$DB_USER = 'usr_inno';
$DB_PASS = 'usr_inno';
$DB_NAME = 'efactoring';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");


function wlog ($accion, $db)
{
    if (!isset($_SESSION["user_id"])) {
        session_start();
    }
    
    $usuario = $_SESSION["user_id"];
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = $_SERVER['REQUEST_URI'];
    
    $query = "INSERT INTO log (Fecha, IdUsuario, Ip, Url, Accion) VALUES (NOW(),".$usuario.",'".$ip."','".$url."','[".$accion."]')";
    
    //echo "<pre>".$query."</pre>";
    $result = $db->query($query) or die($db->error.__LINE__);
}
?>