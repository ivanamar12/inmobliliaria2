<?php
require_once 'config/conexion.php';

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit;
}

// Obtener el rol del usuario desde la sesión
$rol = $_SESSION['rol'] ?? 'invitado'; // Valor predeterminado si no está definido

$modo_edicion = false;
$modo_ver = false;

$propietario = [
  'id' => '',
  'nombre' => '',
  'telefono' => '',
  'correo' => '',
  'primer_nombre' => '',
  'segundo_nombre' => '',
  'primer_apellido' => '',
  'segundo_apellido' => ''
];

// Modo ver
if (isset($_GET['ver'])) {
  $modo_ver = true;
  $id = intval($_GET['ver']);
  $resultado = $conexion->query("SELECT * FROM propietario WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $propietario = $resultado->fetch_assoc();

    $nombre = trim($propietario['nombre'] ?? '');
    $partes = explode(' ', $nombre);

    // Inicializar vacíos
    $propietario['primer_nombre'] = '';
    $propietario['segundo_nombre'] = '';
    $propietario['primer_apellido'] = '';
    $propietario['segundo_apellido'] = '';

    switch (count($partes)) {
    case 2:
        $propietario['primer_nombre'] = $partes[0];
        $propietario['primer_apellido'] = $partes[1];
        break;
    case 3:
        $propietario['primer_nombre'] = $partes[0];
        $propietario['primer_apellido'] = $partes[1];
        $propietario['segundo_apellido'] = $partes[2];
        break;
    default: // 4 o más
        $propietario['primer_nombre'] = $partes[0];
        $propietario['segundo_nombre'] = $partes[1];
        $propietario['primer_apellido'] = $partes[2];
        $propietario['segundo_apellido'] = $partes[3];
        break;
    }
  }
}

// Modo edición
elseif (isset($_GET['editar'])) {
  $modo_edicion = true;
  $id = intval($_GET['editar']);
  $resultado = $conexion->query("SELECT * FROM propietario WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $propietario = $resultado->fetch_assoc();

    $nombre = trim($propietario['nombre'] ?? '');
    $partes = explode(' ', $nombre);

    // Inicializar vacíos
    $propietario['primer_nombre'] = '';
    $propietario['segundo_nombre'] = '';
    $propietario['primer_apellido'] = '';
    $propietario['segundo_apellido'] = '';

    switch (count($partes)) {
    case 2:
        $propietario['primer_nombre'] = $partes[0];
        $propietario['primer_apellido'] = $partes[1];
        break;
    case 3:
        $propietario['primer_nombre'] = $partes[0];
        $propietario['primer_apellido'] = $partes[1];
        $propietario['segundo_apellido'] = $partes[2];
        break;
    default: // 4 o más
        $propietario['primer_nombre'] = $partes[0];
        $propietario['segundo_nombre'] = $partes[1];
        $propietario['primer_apellido'] = $partes[2];
        $propietario['segundo_apellido'] = $partes[3];
        break;
    }
  }
}

// Guardar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];
  $correo = $_POST['correo'];

  if (!empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conexion->prepare("UPDATE propietario SET nombre=?, telefono=?, correo=? WHERE id=?");
    $stmt->bind_param("sssi", $nombre, $telefono, $correo, $id);
  } else {
    $stmt = $conexion->prepare("INSERT INTO propietario (nombre, telefono, correo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $telefono, $correo);
  }

  $stmt->execute();
  $stmt->close();
  header("Location: propietarios.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inmobiliaria</title>
    <link rel="stylesheet" href="vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
</head>

<body>
    <div class="container-scroller">
        <style>
        .navbar-custom {
            background-color: #3498db;
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

                <div class="navbar-brand text-white pl-3 font-weight-bold"
                    style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                    HOME & STYLE
                </div>


                <div class=" d-flex align-items-center justify-content-end">
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle text-white pl-0 pr-0" href="#" data-toggle="dropdown"
                                id="profileDropdown">
                                <i class="typcn typcn-user-outline mr-1"></i>
                                <span
                                    class="nav-profile-name"><?= htmlspecialchars($_SESSION['usuario'] ?? 'Invitado') ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                aria-labelledby="profileDropdown">
                                <a href="perfil.php" class="dropdown-item text">
                                    <i class="typcn typcn-user-outline mr-2"></i> Perfil
                                </a>
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
                            <h3 class="mb-0 font-weight-bold">Propietarios</h3>
                        </div>
                    </div>
                    <div class="content-wrapper">
                        <div class="row">
                            <!-- Formulario para registrar / editar propietario -->
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <?= $modo_edicion ? 'Editar Propietario' : ($modo_ver ? 'Ver Propietario' : 'Registrar Propietario') ?>
                                        </h4>
                                        <form class="forms-sample" method="POST" action=""
                                            <?= $modo_ver ? 'onsubmit="return false;"' : '' ?>>
                                            <input type="hidden" name="id" value="<?= $propietario['id'] ?>">

                                            <!-- ↓ lo enviamos al controlador ya concatenado -->
                                            <input type="hidden" name="nombre" id="nombre"
                                                value="<?= $propietario['nombre'] ?? '' ?>">

                                            <p class="text-muted mb-3"><span class="text-danger">*</span> Campos
                                                obligatorios</p>

                                            <div class="form-row">
                                                <!-- Primer Nombre (oblig.) -->
                                                <div class="form-group col-md-4">
                                                    <label for="primer_nombre">Primer Nombre <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="primer_nombre" class="form-control"
                                                        value="<?= $propietario['primer_nombre'] ?? '' ?>"
                                                        <?= $modo_ver ? 'readonly' : '' ?> required
                                                        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                                </div>

                                                <!-- Segundo Nombre (opcional) -->
                                                <div class="form-group col-md-4">
                                                    <label for="segundo_nombre">Segundo Nombre</label>
                                                    <input type="text" id="segundo_nombre" class="form-control"
                                                        value="<?= $propietario['segundo_nombre'] ?? '' ?>"
                                                        <?= $modo_ver ? 'readonly' : '' ?>
                                                        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                                </div>

                                                <!-- Primer Apellido (oblig.) -->
                                                <div class="form-group col-md-4">
                                                    <label for="primer_apellido">Primer Apellido <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="primer_apellido" class="form-control"
                                                        value="<?= $propietario['primer_apellido'] ?? '' ?>"
                                                        <?= $modo_ver ? 'readonly' : '' ?> required
                                                        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                                </div>

                                                <!-- Segundo Apellido (opcional) -->
                                                <div class="form-group col-md-4">
                                                    <label for="segundo_apellido">Segundo Apellido</label>
                                                    <input type="text" id="segundo_apellido" class="form-control"
                                                        value="<?= $propietario['segundo_apellido'] ?? '' ?>"
                                                        <?= $modo_ver ? 'readonly' : '' ?>
                                                        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                                </div>

                                                <!-- Teléfono (oblig.) -->
                                                <div class="form-group col-md-4">
                                                    <label for="telefono">Teléfono <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="telefono" name="telefono"
                                                        class="form-control"
                                                        value="<?= $propietario['telefono'] ?? '' ?>" maxlength="12"
                                                        pattern="0(41[2466]|42[24])-\d{7}"
                                                        <?= $modo_ver ? 'readonly' : '' ?> required>
                                                    <small class="form-text text-muted">Ej.: 0412-1234567</small>
                                                </div>

                                                <!-- Email -->
                                                <div class="form-group col-md-4">
                                                    <label for="correo">Correo electrónico <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" id="correo" name="correo" class="form-control"
                                                        value="<?= $propietario['correo'] ?? '' ?>" required
                                                        <?= $modo_ver ? 'readonly' : '' ?>>
                                                </div>
                                            </div>

                                            <?php if (!$modo_ver) : ?>
                                            <button type="submit" class="btn btn-primary mr-2">
                                                <?= $modo_edicion ? 'Actualizar' : 'Guardar' ?>
                                            </button>
                                            <a href="propietarios.php" class="btn btn-light">Cancelar</a>
                                            <?php else : ?>
                                            <a href="propietarios.php" class="btn btn-light">Volver</a>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de propietarios -->
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Lista de Propietarios</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="tablaPropietarios">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre</th>
                                                        <th>Teléfono</th>
                                                        <th>Correo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                $resultado = $conexion->query("SELECT * FROM propietario");
                                while ($row = $resultado->fetch_assoc()) {
                                    echo '<tr>
                                            <td>' . $row['id'] . '</td>
                                            <td>' . $row['nombre'] . '</td>
                                            <td>' . $row['telefono'] . '</td>
                                            <td>' . $row['correo'] . '</td>
                                            <td>
                                                <a href="propietarios.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info" title="Ver">
                                                    <i class="typcn typcn-eye"></i>
                                                </a>
                                                <a href="propietarios.php?editar=' . $row['id'] . '" class="btn btn-sm btn-primary" title="Editar">
                                                    <i class="typcn typcn-edit"></i>
                                                </a>
                                            </td>
                                        </tr>';
                                }
                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © <a
                                href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com</a> 2020</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Free <a
                                href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard </a>templates
                            from Bootstrapdash.com</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <script src="vendors/progressbar.js/progressbar.min.js"></script>
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script>
    $(document).ready(function() {
        $('#tablaPropietarios').DataTable();
    });
    </script>
    <script>
    document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-icon-only');
    });
    </script>
    <script>
    document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-icon-only');
    });

    (function() {
        const buildNombreCompleto = () => {
            const partes = [
                document.getElementById('primer_nombre').value.trim(),
                document.getElementById('segundo_nombre').value.trim(),
                document.getElementById('primer_apellido').value.trim(),
                document.getElementById('segundo_apellido').value.trim()
            ].filter(Boolean);
            document.getElementById('nombre').value = partes.join(' ');
        };

        ['primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido']
        .forEach(id => document.getElementById(id).addEventListener('input', buildNombreCompleto));

        buildNombreCompleto();

        const tel = document.getElementById('telefono');
        tel.addEventListener('input', () => {
            let v = tel.value.replace(/\D/g, '').slice(0, 11);
            if (v.length > 4) v = v.slice(0, 4) + '-' + v.slice(4);
            tel.value = v;
        });
    })();
    </script>
</body>

</html>