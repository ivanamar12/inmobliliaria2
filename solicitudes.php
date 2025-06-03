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
                                            <input type="date" class="form-control" name="fecha"
                                                value="<?= $solicitud['fecha'] ?>"
                                                <?= $modo_ver ? 'readonly' : 'required' ?>>
                                        </div>

                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                            <select class="form-control" name="estado"
                                                <?= $modo_ver ? 'disabled' : 'required' ?>>
                                                <option value="pendiente"
                                                    <?= $solicitud['estado'] == 'pendiente' ? 'selected' : '' ?>>
                                                    Pendiente</option>
                                                <option value="aceptada"
                                                    <?= $solicitud['estado'] == 'aceptada' ? 'selected' : '' ?>>Aceptada
                                                </option>
                                                <option value="rechazada"
                                                    <?= $solicitud['estado'] == 'rechazada' ? 'selected' : '' ?>>
                                                    Rechazada</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cliente_id">Cliente</label>
                                            <select class="form-control" name="cliente_id"
                                                <?= $modo_ver ? 'disabled' : 'required' ?>>
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
                                            <select class="form-control" name="propiedad_id"
                                                <?= $modo_ver ? 'disabled' : 'required' ?>>
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
                                        <button type="submit"
                                            class="btn btn-primary mr-2"><?= $modo_edicion ? 'Actualizar' : 'Guardar' ?></button>
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
        <a href="solicitudes.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info" title="Ver">
  <i class="typcn typcn-eye"></i>
</a>
        <a href="solicitudes.php?editar=' . $row['id'] . '" class="btn btn-sm btn-primary" title="Editar">
  <i class="typcn typcn-edit"></i>
</a></td>
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
                        <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © <a
                                href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com</a> 2020</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Free <a
                                href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard </a>templates
                            from Bootstrapdash.com</span>
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
    <script>
    document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-icon-only');
    });
    </script>
    <!-- End custom js for this page-->
</body>

</html>