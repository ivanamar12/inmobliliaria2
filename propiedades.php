<?php
require_once 'config/conexion.php';

session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit;
}

// ELIMINAR PROPIEDAD
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  if ($conexion->query("DELETE FROM propiedad WHERE id = $id")) {
    header("Location: propiedades.php");
    exit();
  } else {
    echo "<pre>Error al eliminar propiedad: " . $conexion->error . "</pre>";
    exit();
  }
}

$modo_edicion = false;
$modo_ver = false;
$propiedad = [
  'id' => '',
  'nombre' => '',
  'tipo' => '',
  'precio' => '',
  'estado' => '',
  'tamanio' => '',
  'descripcion' => '',
  'propietario_id' => ''
];

// Editar propiedad
if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
  $modo_edicion = true;
  $id = intval($_GET['editar']);
  $resultado = $conexion->query("SELECT * FROM propiedad WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $propiedad = $resultado->fetch_assoc();
  }
}

// Ver propiedad
if (isset($_GET['ver']) && is_numeric($_GET['ver'])) {
  $modo_ver = true;
  $id = intval($_GET['ver']);
  $resultado = $conexion->query("SELECT * FROM propiedad WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $propiedad = $resultado->fetch_assoc();
  }
}


// Registrar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = $_POST['nombre'];
  $tipo = $_POST['tipo'];
  $precio = $_POST['precio'];
  $estado = $_POST['estado'];
  $tamanio = $_POST['tamanio'];
  $descripcion = $_POST['descripcion'];
  $propietario_id = $_POST['propietario_id'];

  if (isset($_POST['id']) && $_POST['id'] != '') {
    // UPDATE
    $id = intval($_POST['id']);
    $sql = "UPDATE propiedad SET nombre=?, tipo=?, precio=?, estado=?, tamanio=?, descripcion=?, propietario_id=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdssssi", $nombre, $tipo, $precio, $estado, $tamanio, $descripcion, $propietario_id, $id);
  } else {
    // INSERT
    $sql = "INSERT INTO propiedad (nombre, tipo, precio, estado, tamanio, descripcion, propietario_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdsssi", $nombre, $tipo, $precio, $estado, $tamanio, $descripcion, $propietario_id);
  }

  $stmt->execute();
  $stmt->close();
  header("Location: propiedades.php");
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
              <h3 class="mb-0 font-weight-bold">Propietarios</h3>
            </div>
          </div>
          <div class="content-wrapper">
            <div class="row">
              <!-- Formulario de registrar / editar propiedad -->
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <?= $modo_edicion ? 'Editar Propiedad' : ($modo_ver ? 'Ver Propiedad' : 'Registrar Propiedad') ?>
                    </h4>

                    <form method="POST" class="forms-sample">
                      <input type="hidden" name="id" value="<?= $propiedad['id'] ?>">

                      <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="<?= $propiedad['nombre'] ?>" <?= $modo_ver ? 'readonly' : 'required' ?>>
                      </div>

                      <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="text" class="form-control" name="tipo" value="<?= $propiedad['tipo'] ?>" <?= $modo_ver ? 'readonly' : 'required' ?>>
                      </div>

                      <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" step="0.01" class="form-control" name="precio" value="<?= $propiedad['precio'] ?>" <?= $modo_ver ? 'readonly' : 'required' ?>>
                      </div>

                      <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" name="estado" <?= $modo_ver ? 'disabled' : 'required' ?>>
                          <option value="disponible" <?= $propiedad['estado'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
                          <option value="vendido" <?= $propiedad['estado'] == 'vendido' ? 'selected' : '' ?>>Vendido</option>
                          <option value="reservado" <?= $propiedad['estado'] == 'reservado' ? 'selected' : '' ?>>Reservado</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="tamanio">Tamaño</label>
                        <input type="text" class="form-control" name="tamanio" value="<?= $propiedad['tamanio'] ?>" <?= $modo_ver ? 'readonly' : 'required' ?>>
                      </div>

                      <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3" <?= $modo_ver ? 'readonly' : 'required' ?>><?= $propiedad['descripcion'] ?></textarea>
                      </div>

                      <div class="form-group">
                        <label for="propietario_id">Propietario</label>
                        <select class="form-control" name="propietario_id" <?= $modo_ver ? 'disabled' : 'required' ?>>
                          <option value="">Seleccione</option>
                          <?php
                          $propietarios = $conexion->query("SELECT id, nombre FROM propietario");
                          while ($p = $propietarios->fetch_assoc()) {
                            $selected = $p['id'] == $propiedad['propietario_id'] ? 'selected' : '';
                            echo "<option value='{$p['id']}' $selected>{$p['nombre']}</option>";
                          }
                          ?>
                        </select>
                      </div>

                      <?php if ($modo_ver) : ?>
                        <a href="propiedades.php" class="btn btn-light">Volver</a>
                      <?php else : ?>
                        <button type="submit" class="btn btn-primary mr-2"><?= $modo_edicion ? 'Actualizar' : 'Guardar' ?></button>
                        <a href="propiedades.php" class="btn btn-light">Cancelar</a>
                      <?php endif; ?>
                    </form>

                  </div>
                </div>
              </div>

              <!-- Tabla de propiedades -->
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Lista de Propiedades</h4>
                    <div class="table-responsive">
                      <table class="table table-striped" id="tablaPropiedades">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Propietario</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $resultado = $conexion->query("
    SELECT p.id, p.nombre, p.tipo, p.precio, p.estado, pr.nombre AS propietario
    FROM propiedad p
    INNER JOIN propietario pr ON p.propietario_id = pr.id
  ");

                          while ($row = $resultado->fetch_assoc()) {
                            echo '<tr>
      <td>' . $row['id'] . '</td>
      <td>' . $row['nombre'] . '</td>
      <td>' . $row['tipo'] . '</td>
      <td>' . $row['precio'] . '</td>
      <td>' . $row['estado'] . '</td>
      <td>' . $row['propietario'] . '</td>
      <td>
        <a href="propiedades.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info">Ver</a>
        <a href="propiedades.php?editar=' . $row['id'] . '" class="btn btn-sm btn-warning">Editar</a>
        <a href="propiedades.php?eliminar=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Seguro que deseas eliminar esta propiedad?\')">Eliminar</a>
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
      $('#tablaPropiedades').DataTable();
    });
  </script>
</body>

</html>