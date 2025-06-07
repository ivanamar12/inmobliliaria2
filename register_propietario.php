<?php
session_start();
$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $nombre_usuario = $_POST['nombre_usuario']; // Nuevo campo para el nombre de usuario
    $contrasena = $_POST['contrasena'];

    require 'config/conexion.php';

    // Verificar si el nombre de usuario ya existe
    $stmt_check_usuario = $conexion->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
    $stmt_check_usuario->bind_param("s", $nombre_usuario);
    $stmt_check_usuario->execute();
    $resultado_check_usuario = $stmt_check_usuario->get_result();
    $stmt_check_usuario->close();

    if ($resultado_check_usuario->num_rows > 0) {
        $mensaje_error = "El nombre de usuario ya existe. Por favor, elige otro nombre.";
    } else {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt_usuario = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, 'propietario')");
        $stmt_usuario->bind_param("ss", $nombre_usuario, $hash);
        if (!$stmt_usuario->execute()) {
            $mensaje_error = "Error al registrar usuario: " . $stmt_usuario->error;
        } else {
            $usuario_id = $conexion->insert_id;

            $stmt_propietario = $conexion->prepare("UPDATE propietario SET usuario_id = ? WHERE correo = ?");
            $stmt_propietario->bind_param("is", $usuario_id, $correo);
            if (!$stmt_propietario->execute()) {
                $mensaje_error = "Error al actualizar propietario: " . $stmt_propietario->error;
            } else {
                header("Location: index.php?registro=ok");
                exit;
            }
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
    <title>Registro Propietario</title>
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
                        <h4>Registro Propietario</h4>
                        <?php if (!empty($mensaje_error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje_error; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" class="pt-3">
                            <div class="form-group">
                                <input type="hidden" name="correo" value="<?php echo htmlspecialchars($_SESSION['correo']); ?>">
                                <input type="text" name="nombre" class="form-control form-control-lg"
                                    placeholder="Nombre" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <input type="text" name="nombre_usuario" class="form-control form-control-lg"
                                    placeholder="Nombre de Usuario" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="contrasena" class="form-control form-control-lg"
                                    placeholder="Contraseña" required>
                            </div>
                            <div class="mt-3">
                                <button type="submit"
                                    class="btn btn-block btn-primary btn-lg font-weight-medium">Registrar</button>
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