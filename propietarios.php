<?php
require_once 'config/conexion.php';

session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit;
}

$modo_edicion = false;
$modo_ver = false;

$propietario = [
  'id' => '',
  'nombre' => '',
  'telefono' => '',
  'correo' => ''
];

// Modo ver
if (isset($_GET['ver'])) {
  $modo_ver = true;
  $id = intval($_GET['ver']);
  $resultado = $conexion->query("SELECT * FROM propietario WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $propietario = $resultado->fetch_assoc();
  }
}
// Modo edición
elseif (isset($_GET['editar'])) {
  $modo_edicion = true;
  $id = intval($_GET['editar']);
  $resultado = $conexion->query("SELECT * FROM propietario WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $propietario = $resultado->fetch_assoc();
  }
}


// Registrar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];
  $correo = $_POST['correo'];

  if (isset($_POST['id']) && $_POST['id'] != '') {
    // UPDATE
    $id = intval($_POST['id']);
    $sql = "UPDATE propietario SET nombre=?, telefono=?, correo=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $telefono, $correo, $id);
  } else {
    // INSERT
    $sql = "INSERT INTO propietario (nombre, telefono, correo) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
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
                    <li class="nav-item">
                        <a class="nav-link" href="agentes.php">
                            <i class="typcn typcn-document-text menu-icon"></i>
                            <span class="menu-title">Agenetes</span>
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
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <?= $modo_edicion ? 'Editar Propietario' : ($modo_ver ? 'Ver Propietario' : 'Registrar Propietario') ?>
                                        </h4>
                                        <form class="forms-sample" method="POST" action=""
                                            <?= $modo_ver ? 'onsubmit="return false;"' : '' ?>>
                                            <input type="hidden" name="id" value="<?= $propietario['id'] ?>">
                                            <p class="text-muted mb-3"><span class="text-danger">*</span> Campos
                                                obligatorios</p>
                                            <div class="form-group">
                                                <label for="nombre">Nombre completo<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nombre"
                                                    value="<?= $propietario['nombre'] ?>" required
                                                    <?= $modo_ver ? 'readonly' : '' ?>
                                                    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Teléfono<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="telefono"
                                                    value="<?= $propietario['telefono'] ?>"required
                                                    <?= $modo_ver ? 'readonly' : '' ?>
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                            <div class="form-group">
                                                <label for="correo">Correo electrónico<span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="correo"
                                                    value="<?= $propietario['correo'] ?>" required
                                                    <?= $modo_ver ? 'readonly' : '' ?>>
                                            </div>

                                            <?php if (!$modo_ver) : ?>
                                            <button type="submit"
                                                class="btn btn-primary mr-2"><?= $modo_edicion ? 'Actualizar' : 'Guardar' ?></button>
                                            <a href="propietarios.php" class="btn btn-light">Cancelar</a>
                                            <?php else : ?>
                                            <a href="propietarios.php" class="btn btn-light">Volver</a>
                                            <?php endif; ?>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de propietarios -->
                            <div class="col-lg-6 grid-margin stretch-card">
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
                                    <i class="typcn typcn-eye"></i></a>
                                    <a href="propietarios.php?editar=' . $row['id'] . '" class="btn btn-sm btn-primary" title="Editar">
                                    <i class="typcn typcn-edit"></i></a>
  
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
</body>

</html>