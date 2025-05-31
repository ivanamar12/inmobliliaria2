<?php
require_once 'config/conexion.php';

session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit;
}

// ELIMINAR AGENTE
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  if ($conexion->query("DELETE FROM agente WHERE id = $id")) {
    header("Location: agentes.php");
    exit();
  } else {
    echo "<pre>Error al eliminar agente: " . $conexion->error . "</pre>";
    exit();
  }
}

$modo_edicion = false;
$modo_ver = false;

$agente = [
  'id' => '',
  'nombre_completo' => '',
  'telefono' => '',
  'email' => ''
];

// Modo ver
if (isset($_GET['ver'])) {
  $modo_ver = true;
  $id = intval($_GET['ver']);
  $resultado = $conexion->query("SELECT * FROM agente WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $agente = $resultado->fetch_assoc();
  }
}
// Modo edición
elseif (isset($_GET['editar'])) {
  $modo_edicion = true;
  $id = intval($_GET['editar']);
  $resultado = $conexion->query("SELECT * FROM agente WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $agente = $resultado->fetch_assoc();
  }
}

// Guardar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];
  $email = $_POST['email'];

  if (!empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conexion->prepare("UPDATE agente SET nombre_completo=?, telefono=?, email=? WHERE id=?");
    $stmt->bind_param("sssi", $nombre, $telefono, $email, $id);
  } else {
    $stmt = $conexion->prepare("INSERT INTO agente (nombre_completo, telefono, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $telefono, $email);
  }

  $stmt->execute();
  $stmt->close();
  header("Location: agentes.php");
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
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
              <i class="typcn typcn-user-outline mr-0"></i>
              <span class="nav-profile-name">Evan Morales</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="typcn typcn-cog text-primary"></i>
                Settings
              </a>
              <a href="logout.php" class="btn btn-danger">Cerrar sesión
                <i class="typcn typcn-power text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
      <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close typcn typcn-delete-outline"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options" id="sidebar-light-theme">
            <div class="img-ss rounded-circle bg-light border mr-3"></div>
            Light
          </div>
          <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border mr-3"></div>
            Dark
          </div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles primary"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default border"></div>
          </div>
        </div>
      </div>
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
              <h3 class="mb-0 font-weight-bold">Agentes</h3>
            </div>
          </div>
          <div class="content-wrapper">
            <div class="row">
              <!-- Formulario para registrar o editar agente -->
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"><?= $modo_edicion ? 'Editar Agente' : 'Registrar Agente' ?></h4>
                    <form class="forms-sample" method="POST" action="" <?= $modo_ver ? 'onsubmit="return false;"' : '' ?>>
                      <input type="hidden" name="id" value="<?= $agente['id'] ?>">

                      <div class="form-group">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" class="form-control" name="nombre" value="<?= $agente['nombre_completo'] ?>" required <?= $modo_ver ? 'readonly' : '' ?>>
                      </div>

                      <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" value="<?= $agente['telefono'] ?>" required <?= $modo_ver ? 'readonly' : '' ?>>
                      </div>

                      <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" name="email" value="<?= $agente['email'] ?>" required <?= $modo_ver ? 'readonly' : '' ?>>
                      </div>

                      <?php if (!$modo_ver) : ?>
                        <button type="submit" class="btn btn-primary mr-2"><?= $modo_edicion ? 'Actualizar' : 'Guardar' ?></button>
                        <a href="agentes.php" class="btn btn-light">Cancelar</a>
                      <?php else : ?>
                        <a href="agentes.php" class="btn btn-light">Volver</a>
                      <?php endif; ?>
                    </form>

                  </div>
                </div>
              </div>

              <!-- Tabla de agentes -->
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Lista de Agentes</h4>
                    <div class="table-responsive">
                      <table class="table table-striped" id="tablaAgentes">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $resultado = $conexion->query("SELECT * FROM agente");
                          while ($row = $resultado->fetch_assoc()) {
                            echo '<tr>
          <td>' . $row['id'] . '</td>
          <td>' . $row['nombre_completo'] . '</td>
          <td>' . $row['telefono'] . '</td>
          <td>' . $row['email'] . '</td>
          <td>
            <a href="agentes.php?editar=' . $row['id'] . '" class="btn btn-sm btn-warning">Editar</a>
            <a href="agentes.php?eliminar=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Seguro que deseas eliminar este agente?\')">Eliminar</a>
            <a href="agentes.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info">Ver</a>
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
            <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com</a> 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard </a>templates from Bootstrapdash.com</span>
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
      $('#tablaAgentes').DataTable();
    });
  </script>
</body>

</html>