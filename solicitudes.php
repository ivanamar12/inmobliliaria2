<?php
require_once 'config/conexion.php';

session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit;
}

// ELIMINAR SOLICITUD
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  if ($conexion->query("DELETE FROM solicitud WHERE id = $id")) {
    header("Location: solicitudes.php");
    exit();
  } else {
    echo "<pre>Error al eliminar solicitud: " . $conexion->error . "</pre>";
    exit();
  }
}

$modo_edicion = false;
$modo_ver = false;

$solicitud = [
  'id' => '',
  'fecha' => '',
  'estado' => '',
  'cliente_id' => '',
  'propiedad_id' => ''
];

// Si viene para editar
if (isset($_GET['editar'])) {
  $modo_edicion = true;
  $id = intval($_GET['editar']);
  $resultado = $conexion->query("SELECT * FROM solicitud WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $solicitud = $resultado->fetch_assoc();
  }
}

// Si viene para ver
if (isset($_GET['ver'])) {
  $modo_ver = true;
  $id = intval($_GET['ver']);
  $resultado = $conexion->query("SELECT * FROM solicitud WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $solicitud = $resultado->fetch_assoc();
  }
}

// Registrar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fecha = $_POST['fecha'];
  $estado = $_POST['estado'];
  $cliente_id = $_POST['cliente_id'];
  $propiedad_id = $_POST['propiedad_id'];

  if (isset($_POST['id']) && $_POST['id'] != '') {
    // UPDATE
    $id = intval($_POST['id']);
    $sql = "UPDATE solicitud SET fecha=?, estado=?, cliente_id=?, propiedad_id=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssiii", $fecha, $estado, $cliente_id, $propiedad_id, $id);
  } else {
    // INSERT
    $sql = "INSERT INTO solicitud (fecha, estado, cliente_id, propiedad_id) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssii", $fecha, $estado, $cliente_id, $propiedad_id);
  }

  $stmt->execute();
  $stmt->close();
  header("Location: solicitudes.php");
  exit();
}
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
  <!-- endinject -->
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
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
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
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
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0 font-weight-bold">Solocitudes</h3>
            </div>
          </div>
        </div>
        <div class="content-wrapper">
          <div class="row">
            <!-- Formulario registrar / editar solicitud -->
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">
                    <?= $modo_edicion ? 'Editar Solicitud' : ($modo_ver ? 'Ver Solicitud' : 'Registrar Solicitud') ?>
                  </h4>

                  <form method="POST" class="forms-sample">
                    <input type="hidden" name="id" value="<?= $solicitud['id'] ?>">

                    <div class="form-group">
                      <label for="fecha">Fecha</label>
                      <input type="date" class="form-control" name="fecha" value="<?= $solicitud['fecha'] ?>" <?= $modo_ver ? 'readonly' : 'required' ?>>
                    </div>

                    <div class="form-group">
                      <label for="estado">Estado</label>
                      <select class="form-control" name="estado" <?= $modo_ver ? 'disabled' : 'required' ?>>
                        <option value="pendiente" <?= $solicitud['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="aceptada" <?= $solicitud['estado'] == 'aceptada' ? 'selected' : '' ?>>Aceptada</option>
                        <option value="rechazada" <?= $solicitud['estado'] == 'rechazada' ? 'selected' : '' ?>>Rechazada</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="cliente_id">Cliente</label>
                      <select class="form-control" name="cliente_id" <?= $modo_ver ? 'disabled' : 'required' ?>>
                        <option value="">Seleccione</option>
                        <?php
                        $clientes = $conexion->query("SELECT id, nombre_completo FROM cliente");
                        while ($c = $clientes->fetch_assoc()) {
                          $selected = $c['id'] == $solicitud['cliente_id'] ? 'selected' : '';
                          echo "<option value='{$c['id']}' $selected>{$c['nombre_completo']}</option>";
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="propiedad_id">Propiedad</label>
                      <select class="form-control" name="propiedad_id" <?= $modo_ver ? 'disabled' : 'required' ?>>
                        <option value="">Seleccione</option>
                        <?php
                        $propiedades = $conexion->query("SELECT id, nombre FROM propiedad");
                        while ($p = $propiedades->fetch_assoc()) {
                          $selected = $p['id'] == $solicitud['propiedad_id'] ? 'selected' : '';
                          echo "<option value='{$p['id']}' $selected>{$p['nombre']}</option>";
                        }
                        ?>
                      </select>
                    </div>

                    <?php if ($modo_ver) : ?>
                      <a href="solicitudes.php" class="btn btn-light">Volver</a>
                    <?php else : ?>
                      <button type="submit" class="btn btn-primary mr-2"><?= $modo_edicion ? 'Actualizar' : 'Guardar' ?></button>
                      <a href="solicitudes.php" class="btn btn-light">Cancelar</a>
                    <?php endif; ?>
                  </form>

                </div>
              </div>
            </div>

            <!-- Tabla de solicitudes -->
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Lista de Solicitudes</h4>
                  <div class="table-responsive">
                    <table class="table table-striped" id="tablaSolicitudes">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Fecha</th>
                          <th>Estado</th>
                          <th>Cliente</th>
                          <th>Propiedad</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "
    SELECT s.id, s.fecha, s.estado,
           c.nombre_completo AS cliente,
           p.nombre AS propiedad
    FROM solicitud s
    JOIN cliente c ON s.cliente_id = c.id
    JOIN propiedad p ON s.propiedad_id = p.id
  ";
                        $resultado = $conexion->query($sql);

                        while ($row = $resultado->fetch_assoc()) {
                          echo '<tr>
      <td>' . $row['id'] . '</td>
      <td>' . $row['fecha'] . '</td>
      <td>' . $row['estado'] . '</td>
      <td>' . $row['cliente'] . '</td>
      <td>' . $row['propiedad'] . '</td>
      <td>
        <a href="solicitudes.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info">Ver</a>
        <a href="solicitudes.php?editar=' . $row['id'] . '" class="btn btn-sm btn-warning">Editar</a>
        <a href="solicitudes.php?eliminar=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Seguro que deseas eliminar esta solicitud?\')">Eliminar</a>
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


        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com</a> 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard </a>templates from Bootstrapdash.com</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="vendors/progressbar.js/progressbar.min.js"></script>
  <script src="vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script>
    $(document).ready(function() {
      $('#tablaSolicitudes').DataTable();
    });
  </script>
  <!-- End custom js for this page-->
</body>

</html>