<?php
require 'config/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    // Verificar si el correo ya existe en la tabla correspondiente al rol seleccionado
    if ($rol === 'cliente') {
        $stmt = $conexion->prepare("SELECT id, nombre_completo FROM cliente WHERE email = ?");
    } elseif ($rol === 'agente') {
        $stmt = $conexion->prepare("SELECT id, nombre_completo FROM agente WHERE email = ?");
    } elseif ($rol === 'propietario') {
        $stmt = $conexion->prepare("SELECT id, nombre FROM propietario WHERE correo = ?");
    } else {
        echo "Rol no válido.";
        exit;
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close(); // Cerrar la consulta

    if ($rol === 'cliente') {
        if ($resultado->num_rows > 0) {
            echo "El correo ya está registrado como cliente.";
        } else {
            // Mostrar formulario para registrar cliente
            $_SESSION['correo'] = $correo;
            $_SESSION['rol'] = $rol;
            header("Location: register_cliente.php");
            exit;
        }
    } else {
        if ($resultado->num_rows > 0) {
            // Mostrar formulario para registrar agente o propietario
            $registro = $resultado->fetch_assoc();
            $_SESSION['correo'] = $correo;
            $_SESSION['rol'] = $rol;
            $_SESSION['nombre'] = $registro['nombre_completo'] ?? $registro['nombre'];
            if ($rol === 'agente') {
                header("Location: register_agente.php");
            } elseif ($rol === 'propietario') {
                header("Location: register_propietario.php");
            }
            exit;
        } else {
            echo "El correo no está registrado. Por favor, registre el correo primero.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <link rel="stylesheet" href="css/login-custom.css">
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <div class="brand-logo text-center mb-4">
                                <img src="img/logo.png" alt="Logo" style="max-width: 150px;">
                            </div>
                        </div>
                        <h1 class="display-3 text-login mb-4 font-weight-bold"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">HOME & STYLE</h1>
                        <h4>Nuevo usuario</h4>
                        <form method="POST" class="pt-3">
                            <div class="form-group">
                                <input type="email" name="correo" class="form-control form-control-lg"
                                    placeholder="Correo electrónico" required>
                            </div>
                            <div class="form-group">
                                <select name="rol" class="form-control form-control-lg" required>
                                    <option value="">Selecciona un rol</option>
                                    <option value="cliente">Cliente</option>
                                    <option value="agente">Agente</option>
                                    <option value="propietario">Propietario</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <button type="submit"
                                    class="btn btn-block btn-primary btn-lg font-weight-medium">Registrar</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                ¿Ya tienes cuenta? <a href="login.php" class="text-primary">Inicia sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-scroller -->
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