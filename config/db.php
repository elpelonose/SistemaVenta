<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tienda_db";

$conexion = new mysqli($host, $user, $pass, $db);
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>