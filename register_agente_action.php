<?php
require 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $nombre_completo = $_POST['nombre_completo'];
    $contrasena = $_POST['contrasena'];

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt_usuario = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, 'agente')");
    $stmt_usuario->bind_param("ss", $nombre_completo, $hash);
    $stmt_usuario->execute();

    $usuario_id = $conexion->insert_id;

    $stmt_agente = $conexion->prepare("UPDATE agente SET usuario_id = ? WHERE email = ?");
    $stmt_agente->bind_param("is", $usuario_id, $correo);
    $stmt_agente->execute();

    header("Location: index.php?registro=ok");
    exit;
}
?>