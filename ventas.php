<?php
require_once 'config/conexion.php';

session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit;
}

// ELIMINAR VENTA
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  if ($conexion->query("DELETE FROM venta WHERE id = $id")) {
    header("Location: ventas.php");
    exit();
  } else {
    echo "<pre>Error al eliminar venta: " . $conexion->error . "</pre>";
    exit();
  }
}

$modo_edicion = false;
$modo_ver = false;

$venta = [
  'id' => '',
  'fecha' => '',
  'monto' => '',
  'cliente_id' => '',
  'agente_id' => ''
];

// Si viene para editar
if (isset($_GET['editar'])) {
  $modo_edicion = true;
  $id = intval($_GET['editar']);
  $resultado = $conexion->query("SELECT * FROM venta WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $venta = $resultado->fetch_assoc();
  }
}

// Si viene para ver
if (isset($_GET['ver'])) {
  $modo_ver = true;
  $id = intval($_GET['ver']);
  $resultado = $conexion->query("SELECT * FROM venta WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $venta = $resultado->fetch_assoc();
  }
}


// Registrar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fecha = $_POST['fecha'];
  $monto = $_POST['monto'];
  $cliente_id = $_POST['cliente_id'];
  $agente_id = $_POST['agente_id'];

  if (isset($_POST['id']) && $_POST['id'] != '') {
    // UPDATE
    $id = intval($_POST['id']);
    $sql = "UPDATE venta SET fecha=?, monto=?, cliente_id=?, agente_id=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdiii", $fecha, $monto, $cliente_id, $agente_id, $id);
  } else {
    // INSERT
    $sql = "INSERT INTO venta (fecha, monto, cliente_id, agente_id) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdii", $fecha, $monto, $cliente_id, $agente_id);
  }

  $stmt->execute();
  $stmt->close();
  header("Location: ventas.php");
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
              <h3 class="mb-0 font-weight-bold">Ventas</h3>
            </div>
          </div>

          <div class="content-wrapper">
            <div class="row">
              <!-- Formulario registrar / editar venta -->
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <?= $modo_edicion ? 'Editar Venta' : ($modo_ver ? 'Ver Venta' : 'Registrar Venta') ?>
                    </h4>

                    <form method="POST" class="forms-sample">
                      <input type="hidden" name="id" value="<?= $venta['id'] ?>">

                      <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" class="form-control" name="fecha" value="<?= $venta['fecha'] ?>" <?= $modo_ver ? 'readonly' : 'required' ?>>
                      </div>

                      <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" step="0.01" class="form-control" name="monto" value="<?= $venta['monto'] ?>" <?= $modo_ver ? 'readonly' : 'required' ?>>
                      </div>

                      <div class="form-group">
                        <label for="cliente_id">Cliente</label>
                        <select class="form-control" name="cliente_id" <?= $modo_ver ? 'disabled' : 'required' ?>>
                          <option value="">Seleccione</option>
                          <?php
                          $clientes = $conexion->query("SELECT id, nombre_completo FROM cliente");
                          while ($c = $clientes->fetch_assoc()) {
                            $selected = $c['id'] == $venta['cliente_id'] ? 'selected' : '';
                            echo "<option value='{$c['id']}' $selected>{$c['nombre_completo']}</option>";
                          }
                          ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="agente_id">Agente</label>
                        <select class="form-control" name="agente_id" <?= $modo_ver ? 'disabled' : 'required' ?>>
                          <option value="">Seleccione</option>
                          <?php
                          $agentes = $conexion->query("SELECT id, nombre_completo FROM agente");
                          while ($a = $agentes->fetch_assoc()) {
                            $selected = $a['id'] == $venta['agente_id'] ? 'selected' : '';
                            echo "<option value='{$a['id']}' $selected>{$a['nombre_completo']}</option>";
                          }
                          ?>
                        </select>
                      </div>

                      <?php if ($modo_ver) : ?>
                        <a href="ventas.php" class="btn btn-light">Volver</a>
                      <?php else : ?>
                        <button type="submit" class="btn btn-primary mr-2"><?= $modo_edicion ? 'Actualizar' : 'Guardar' ?></button>
                        <a href="ventas.php" class="btn btn-light">Cancelar</a>
                      <?php endif; ?>
                    </form>

                  </div>
                </div>
              </div>

              <!-- Tabla de ventas -->
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Lista de Ventas</h4>
                    <div class="table-responsive">
                      <table class="table table-striped" id="tablaVentas">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Cliente</th>
                            <th>Agente</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = "
    SELECT v.id, v.fecha, v.monto,
           c.nombre_completo AS cliente,
           a.nombre_completo AS agente
    FROM venta v
    JOIN cliente c ON v.cliente_id = c.id
    JOIN agente a ON v.agente_id = a.id
  ";
                          $resultado = $conexion->query($sql);

                          while ($row = $resultado->fetch_assoc()) {
                            echo '<tr>
      <td>' . $row['id'] . '</td>
      <td>' . $row['fecha'] . '</td>
      <td>' . $row['monto'] . '</td>
      <td>' . $row['cliente'] . '</td>
      <td>' . $row['agente'] . '</td>
      <td>
        <a href="ventas.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info">Ver</a>
        <a href="ventas.php?editar=' . $row['id'] . '" class="btn btn-sm btn-warning">Editar</a>
        <a href="ventas.php?eliminar=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Seguro que deseas eliminar esta venta?\')">Eliminar</a>
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
          $('#tablaVentas').DataTable();
        });
      </script>
</body>

</html>