<?php
$host = "localhost";
$user = "root";
$password = ""; 
$bd = "inmobiliaria";

// Crear conexión
$conexion = new mysqli($host, $user, $password, $bd);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Opcional: establecer charset
$conexion->set_charset("utf8");
?>
