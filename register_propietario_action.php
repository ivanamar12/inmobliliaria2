<?php
require 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt_usuario = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, 'propietario')");
    $stmt_usuario->bind_param("ss", $nombre, $hash);
    $stmt_usuario->execute();

    $usuario_id = $conexion->insert_id;

    $stmt_propietario = $conexion->prepare("UPDATE propietario SET usuario_id = ? WHERE correo = ?");
    $stmt_propietario->bind_param("is", $usuario_id, $correo);
    $stmt_propietario->execute();

    header("Location: index.php?registro=ok");
    exit;
}
?>