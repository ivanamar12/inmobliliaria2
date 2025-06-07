<?php
session_start();

// Verificamos que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Conexión a base de datos
require_once 'config/conexion.php';

// Nos aseguramos que el ID de usuario esté en la sesión (con clave 'id')
$usuarioId = $_SESSION['id'] ?? null;

if ($usuarioId) {
    // Preparamos y ejecutamos consulta para obtener cliente relacionado al usuario
    $clienteStmt = $conexion->prepare("SELECT id, nombre_completo FROM cliente WHERE usuario_id = ? LIMIT 1");
    $clienteStmt->bind_param("i", $usuarioId);
    $clienteStmt->execute();
    $cliente = $clienteStmt->get_result()->fetch_assoc();

    // Asignamos en la sesión el cliente y el nombre completo o valores por defecto
    if ($cliente) {
        $_SESSION['cliente_id'] = $cliente['id'];
        $_SESSION['nombre_cliente'] = $cliente['llllllll'];
    } else {
        $_SESSION['cliente_id'] = null;
        $_SESSION['nombre_cliente'] = 'Sin nombre';
    }

    $clienteStmt->close();
} else {
    // No hay usuario identificado, asignamos valores por defecto
    $_SESSION['cliente_id'] = null;
    $_SESSION['nombre_cliente'] = 'lllllll';
}

// Puedes usar $_SESSION['nombre_cliente'] para mostrar el nombre en tus formularios
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inmobiliaria</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="css/login-custom.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <div class="brand-logo text-center mb-4">
                                    <img src="img/logo.png" alt="Logo" style="max-width: 150px;">
                                </div>
                            </div>
                            <h1 class="display-3 text-login mb-4 font-weight-bold"
                                style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">HOME & STYLE</h1>
                            <h4>Bienvenido</h4>
                            <h6 class="font-weight-light">Inicio de sesión.</h6>
                            <form class="pt-3" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                <div class="form-group">
                                    <input type="text" name="usuario" class="form-control form-control-lg"
                                        placeholder="Nombre de usuario" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="contrasena" class="form-control form-control-lg"
                                        placeholder="Contraseña" required>
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Iniciar
                                        sesión</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    No tienes una cuenta? <a href="register.php" class="text-primary">Registrate</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- base:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
</body>
</html>