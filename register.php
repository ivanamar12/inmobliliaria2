<?php
require 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = $_POST['usuario'];
  $contrasena = $_POST['contrasena'];
  $rol = $_POST['rol'];

  // Hasheamos la contraseña
  $hash = password_hash($contrasena, PASSWORD_DEFAULT);

  // Guardamos en la base de datos
  $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $usuario, $hash, $rol);

  if ($stmt->execute()) {
    header("Location:index.php?registro=ok");
    exit;
  } else {
    echo "Error al registrar: " . $stmt->error;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CelestialUI Admin</title>
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
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <h4>Nuevo usuario</h4>
            <form method="POST" class="pt-3">
              <div class="form-group">
                <input type="text" name="usuario" class="form-control form-control-lg" placeholder="Nombre de usuario" required>
              </div>
              <div class="form-group">
                <input type="password" name="contrasena" class="form-control form-control-lg" placeholder="Contraseña" required>
              </div>
              <div class="form-group">
                <select name="rol" class="form-control form-control-lg" required>
                  <option value="">Selecciona un rol</option>
                  <option value="admin">Administrador</option>
                  <option value="agente">Agente</option>
                </select>
              </div>
              <div class="mt-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium">Registrar</button>
              </div>
              <div class="text-center mt-4 font-weight-light">
                ¿Ya tienes cuenta? <a href="index.php" class="text-primary">Inicia sesión</a>
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