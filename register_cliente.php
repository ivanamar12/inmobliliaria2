<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: register.php");
    exit;
}
$correo = $_SESSION['correo'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro Cliente</title>
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
                        <h4>Registro Cliente</h4>
                        <form method="POST" class="pt-3" action="register_cliente_action.php">
                            <div class="form-group">
                                <input type="hidden" name="correo" value="<?php echo $correo; ?>">
                                <input type="text" name="ci" class="form-control form-control-lg"
                                    placeholder="Cédula" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="nombre_usuario" class="form-control form-control-lg"
                                    placeholder="Nombre de Usuario" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="primer_nombre" class="form-control form-control-lg"
                                    placeholder="Primer Nombre" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="segundo_nombre" class="form-control form-control-lg"
                                    placeholder="Segundo Nombre" optional>
                            </div>
                            <div class="form-group">
                                <input type="text" name="primer_apellido" class="form-control form-control-lg"
                                    placeholder="Primer Apellido" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="segundo_apellido" class="form-control form-control-lg"
                                    placeholder="Segundo Apellido" optional>
                            </div>
                            <div class="form-group">
                                <input type="text" name="telefono" class="form-control form-control-lg"
                                    placeholder="Teléfono" required>
                            </div>
                            <div class="form-group">
                                <select name="genero" class="form-control form-control-lg" required>
                                    <option value="">Seleccione Género</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
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
    <script>
        (function() {
            const buildNombreCompleto = () => {
                const partes = [
                    document.getElementById('primer_nombre').value.trim(),
                    document.getElementById('segundo_nombre').value.trim(),
                    document.getElementById('primer_apellido').value.trim(),
                    document.getElementById('segundo_apellido').value.trim()
                ].filter(Boolean).join(' ');
                document.getElementById('nombre_completo').value = partes;
            };

            document.getElementById('primer_nombre').addEventListener('input', buildNombreCompleto);
            document.getElementById('segundo_nombre').addEventListener('input', buildNombreCompleto);
            document.getElementById('primer_apellido').addEventListener('input', buildNombreCompleto);
            document.getElementById('segundo_apellido').addEventListener('input', buildNombreCompleto);
        })();
    </script>
</body>
</html>