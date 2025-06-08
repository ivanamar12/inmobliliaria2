<?php
session_start();
if (!isset($_SESSION['usuario_id'], $_SESSION['rol'])) {
    header("Location: index.php");
    exit;
}
$usuario_id = $_SESSION['usuario_id'];
$rol = $_SESSION['rol'];

require 'config/conexion.php';

// Obtener información del usuario
$stmt_usuario = $conexion->prepare("SELECT nombre_usuario, contrasena, rol FROM usuarios WHERE id = ?");
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();
$usuario = $resultado_usuario->fetch_assoc();

// Obtener información del usuario según el rol
if ($rol === 'agente') {
    $stmt_agente = $conexion->prepare("SELECT * FROM agente WHERE usuario_id = ?");
    $stmt_agente->bind_param("i", $usuario_id);
    $stmt_agente->execute();
    $resultado_agente = $stmt_agente->get_result();
    $agente = $resultado_agente->fetch_assoc();
} elseif ($rol === 'cliente') {
    $stmt_cliente = $conexion->prepare("SELECT * FROM cliente WHERE usuario_id = ?");
    $stmt_cliente->bind_param("i", $usuario_id);
    $stmt_cliente->execute();
    $resultado_cliente = $stmt_cliente->get_result();
    $cliente = $resultado_cliente->fetch_assoc();
} elseif ($rol === 'propietario') {
    $stmt_propietario = $conexion->prepare("SELECT * FROM propietario WHERE usuario_id = ?");
    $stmt_propietario->bind_param("i", $usuario_id);
    $stmt_propietario->execute();
    $resultado_propietario = $stmt_propietario->get_result();
    $propietario = $resultado_propietario->fetch_assoc();
}

// Actualizar datos del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt_update_usuario = $conexion->prepare("UPDATE usuarios SET nombre_usuario = ?, contrasena = ? WHERE id = ?");
    $stmt_update_usuario->bind_param("ssi", $nombre_usuario, $hash, $usuario_id);
    $stmt_update_usuario->execute();

    if ($rol === 'agente') {
        $stmt_update_agente = $conexion->prepare("UPDATE agente SET nombre_completo = ?, telefono = ?, email = ? WHERE usuario_id = ?");
        $stmt_update_agente->bind_param("sssi", $_POST['nombre_completo'], $_POST['telefono'], $_POST['email'], $usuario_id);
        $stmt_update_agente->execute();
    } elseif ($rol === 'cliente') {
        $stmt_update_cliente = $conexion->prepare("UPDATE cliente SET nombre_completo = ?, ci = ?, telefono = ?, genero = ?, email = ? WHERE usuario_id = ?");
        $stmt_update_cliente->bind_param("sssssi", $_POST['nombre_completo'], $_POST['ci'], $_POST['telefono'], $_POST['genero'], $_POST['email'], $usuario_id);
        $stmt_update_cliente->execute();
    } elseif ($rol === 'propietario') {
        $stmt_update_propietario = $conexion->prepare("UPDATE propietario SET nombre = ?, telefono = ?, correo = ? WHERE usuario_id = ?");
        $stmt_update_propietario->bind_param("sssi", $_POST['nombre'], $_POST['telefono'], $_POST['correo'], $usuario_id);
        $stmt_update_propietario->execute();
    }

    header("Location: perfil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perfil</title>
    <link rel="stylesheet" href="vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
</head>
<body>
    <div class="container-scroller">
        <style>
        .navbar-custom {
            background-color: #3498db;
            /* Azul suave (puedes ajustar) */
        }

        .navbar .dropdown-menu a {
            color: #333;
        }

        .navbar .dropdown-menu a:hover {
            background-color: #f2f2f2;
        }
        </style>
        <nav class="navbar navbar-expand-lg navbar-custom fixed-top w-100 d-flex flex-row">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="navbar-brand text-white pl-3 font-weight-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                    HOME & STYLE
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle text-white pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
                                <i class="typcn typcn-user-outline mr-1"></i>
                                <span class="nav-profile-name"><?= htmlspecialchars($_SESSION['usuario'] ?? 'Invitado') ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a href="logout.php" class="dropdown-item text-danger">
                                    <i class="typcn typcn-power mr-2"></i> Cerrar sesión
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
           <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <div class="d-flex sidebar-profile">
                            <div class="sidebar-profile-name">
                                <p class="sidebar-name">
                                    Inmobiliaria
                                </p>
                                <p class="sidebar-designation">
                                    Inicio
                                </p>
                            </div>
                        </div>
                        <button id="toggleSidebarBtn" class="btn btn-sm btn-outline-light ml-3">
                            <i class="typcn typcn-arrow-left-outline"></i>
                        </button>
                        <p class="sidebar-menu-title">MENÚ</p>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="typcn typcn-device-desktop menu-icon"></i>
                            <span class="menu-title">Inicio </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="typcn typcn-device-desktop menu-icon"></i>
                            <span class="menu-title">Dashboard </span>
                        </a>
                    </li>
                    <?php if ($rol === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="agentes.php">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Agentes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="clientes.php">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Clientes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="propietarios.php">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Propietarios</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($rol === 'admin' || $rol === 'agente'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="propiedades.php">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Propiedades</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="solicitudes.php">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Solicitudes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ventas.php">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Ventas</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($rol === 'propietario'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="propiedades.php">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Propiedades</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($rol === 'cliente'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="solicitudes.php">
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Solicitudes</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0 font-weight-bold">Perfil</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Información del Usuario</h4>
                                    <form method="POST" class="forms-sample" id="perfilForm">
                                        <div class="form-group">
                                            <label for="nombre_usuario">Nombre de Usuario</label>
                                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="contrasena">Contraseña</label>
                                            <input type="password" class="form-control" id="contrasena" name="contrasena" required readonly>
                                        </div>
                                        <?php if ($rol === 'agente'): ?>
                                            <div class="form-group">
                                                <label for="nombre_completo">Nombre Completo</label>
                                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?= htmlspecialchars($agente['nombre_completo']) ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Teléfono</label>
                                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($agente['telefono']) ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($agente['email']) ?>" required readonly>
                                            </div>
                                        <?php elseif ($rol === 'cliente'): ?>
                                            <div class="form-group">
                                                <label for="nombre_completo">Nombre Completo</label>
                                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?= htmlspecialchars($cliente['nombre_completo']) ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="ci">Cédula</label>
                                                <input type="text" class="form-control" id="ci" name="ci" value="<?= htmlspecialchars($cliente['ci']) ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Teléfono</label>
                                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="genero">Género</label>
                                                <input type="text" class="form-control" id="genero" name="genero" value="<?= htmlspecialchars($cliente['genero']) ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required readonly>
                                            </div>
                                        <?php elseif ($rol === 'propietario'): ?>
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($propietario['nombre']) ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Teléfono</label>
                                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($propietario['telefono']) ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="correo">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($propietario['correo']) ?>" required readonly>
                                            </div>
                                        <?php endif; ?>
                                        <button type="button" id="editarButton" class="btn btn-primary mr-2">Editar</button>
                                        <button type="submit" id="guardarButton" class="btn btn-success mr-2" style="display: none;">Guardar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com</a> 2020</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard </a>templates from Bootstrapdash.com</span>
            </div>
        </footer>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <script>
        document.getElementById('editarButton').addEventListener('click', function() {
            var inputs = document.querySelectorAll('#perfilForm input');
            inputs.forEach(function(input) {
                input.removeAttribute('readonly');
            });
            document.getElementById('guardarButton').style.display = 'inline-block';
            this.style.display = 'none';
        });
    </script>
</body>
</html>