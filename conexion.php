<?php

$host = "localhost";
$usuario = "root";
$clave = "root";
$base_de_datos = "weather";

$conn = new mysqli($host, $usuario, $clave, $base_de_datos);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>
