<?php
require 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $ci = $_POST['ci'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'] ?? '';
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'] ?? '';
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $contrasena = $_POST['contrasena'];

    $nombre_completo = trim("$primer_nombre $segundo_nombre $primer_apellido $segundo_apellido");

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar el usuario con el rol 'cliente'
    $stmt_usuario = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, 'cliente')");
    $stmt_usuario->bind_param("ss", $nombre_usuario, $hash);
    if (!$stmt_usuario->execute()) {
        echo "Error al registrar usuario: " . $stmt_usuario->error;
        exit;
    }

    $usuario_id = $conexion->insert_id;

    // Insertar el cliente con el usuario_id
    $stmt_cliente = $conexion->prepare("INSERT INTO cliente (ci, nombre_completo, telefono, genero, email, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_cliente->bind_param("sssssi", $ci, $nombre_completo, $telefono, $genero, $correo, $usuario_id);
    if (!$stmt_cliente->execute()) {
        echo "Error al registrar cliente: " . $stmt_cliente->error;
        exit;
    }

    header("Location: index.php?registro=ok");
    exit;
}
?>