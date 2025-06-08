<?php
session_start();
if (!isset($_SESSION['usuario_id'], $_SESSION['rol'])) {
    header("Location: index.php");
    exit;
}
$usuario_id = $_SESSION['usuario_id'];
$rol = $_SESSION['rol'];

require_once 'config/conexion.php';

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

// MODO VER
if (isset($_GET['ver'])) {
  $modo_ver = true;
  $id = intval($_GET['ver']);
  $resultado = $conexion->query("SELECT * FROM propiedad WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $propiedad = $resultado->fetch_assoc();
  }
}

// MODO EDICIÓN
elseif (isset($_GET['editar'])) {
  $modo_edicion = true;
  $id = intval($_GET['editar']);
  $resultado = $conexion->query("SELECT * FROM propiedad WHERE id = $id");
  if ($resultado && $resultado->num_rows > 0) {
    $propiedad = $resultado->fetch_assoc();
  }
}

// REGISTRAR O ACTUALIZAR
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$modo_ver) {
  $nombre = $_POST['nombre'];
  $tipo = $_POST['tipo'];
  $precio = $_POST['precio'];
  $estado = $_POST['estado'];
  $tamanio = $_POST['tamanio'];
  $descripcion = $_POST['descripcion'];
  $propietario_id = $_POST['propietario_id'];

  if (empty($_POST['id'])) {
    // INSERTAR
    $stmt = $conexion->prepare("INSERT INTO propiedad (nombre, tipo, precio, estado, tamanio, descripcion, propietario_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsssi", $nombre, $tipo, $precio, $estado, $tamanio, $descripcion, $propietario_id);
    $stmt->execute();
    $propiedad_id = $stmt->insert_id;
  } else {
    // ACTUALIZAR
    $propiedad_id = intval($_POST['id']);
    $stmt = $conexion->prepare("UPDATE propiedad SET nombre=?, tipo=?, precio=?, estado=?, tamanio=?, descripcion=?, propietario_id=? WHERE id=?");
    $stmt->bind_param("ssdsssii", $nombre, $tipo, $precio, $estado, $tamanio, $descripcion, $propietario_id, $propiedad_id);
    $stmt->execute();
  }

  $stmt->close();

  // CARGAR IMÁGENES SI EXISTEN
  if (!empty($_FILES['imagenes']['name'][0])) {
    $carpeta = 'uploads/propiedades/' . $propiedad_id . '/';
    if (!is_dir($carpeta)) {
      mkdir($carpeta, 0777, true);
    }

    foreach ($_FILES['imagenes']['tmp_name'] as $k => $tmp) {
      if ($_FILES['imagenes']['error'][$k] === UPLOAD_ERR_OK) {
        $nombreFinal = uniqid() . '-' . basename($_FILES['imagenes']['name'][$k]);
        $destino = $carpeta . $nombreFinal;

        if (move_uploaded_file($tmp, $destino)) {
          $conexion->query("INSERT INTO propiedad_imagen (propiedad_id, ruta) VALUES ($propiedad_id, '$destino')");
        }
      }
    }
  }

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
                            <h3 class="mb-0 font-weight-bold">Propiedades</h3>
                        </div>
                    </div>
                    <div class="content-wrapper">
    <div class="row">
        <!-- Formulario de registrar / editar propiedad -->
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <?= $modo_edicion ? 'Editar Propiedad' : ($modo_ver ? 'Ver Propiedad' : 'Registrar Propiedad') ?>
                    </h4>

                    <form method="POST" enctype="multipart/form-data" action="">
                        <input type="hidden" name="id" value="<?= $propiedad['id'] ?>">

                        <p class="text-muted mb-3"><span class="text-danger">*</span> Campos obligatorios</p>

                        <div class="form-row">
                            <!-- Nombre -->
                            <div class="form-group col-md-4">
                                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre"
                                    value="<?= $propiedad['nombre'] ?>" required
                                    <?= $modo_ver ? 'readonly' : '' ?>
                                    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                            </div>

                            <!-- Tipo -->
                            <div class="form-group col-md-4">
                                <label for="tipo">Tipo <span class="text-danger">*</span></label>
                                <select class="form-control" name="tipo" required
                                    <?= $modo_ver ? 'disabled' : '' ?>>
                                    <option value="economica"
                                        <?= $propiedad['tipo'] == 'economica' ? 'selected' : '' ?>>
                                        Económica</option>
                                    <option value="lujo"
                                        <?= $propiedad['tipo'] == 'lujo' ? 'selected' : '' ?>>
                                        Lujo</option>
                                </select>
                            </div>

                            <!-- Precio -->
                            <div class="form-group col-md-4">
                                <label for="precio">Precio <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" name="precio"
                                    value="<?= $propiedad['precio'] ?>" required
                                    <?= $modo_ver ? 'readonly' : '' ?>
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>

                            <!-- Estado -->
                            <div class="form-group col-md-4">
                                <label for="estado">Estado <span class="text-danger">*</span></label>
                                <select class="form-control" name="estado" required
                                    <?= $modo_ver ? 'disabled' : '' ?>>
                                    <option value="disponible"
                                        <?= $propiedad['estado'] == 'disponible' ? 'selected' : '' ?>>
                                        Disponible</option>
                                    <option value="vendido"
                                        <?= $propiedad['estado'] == 'vendido' ? 'selected' : '' ?>>
                                        Vendido</option>
                                    <option value="reservado"
                                        <?= $propiedad['estado'] == 'reservado' ? 'selected' : '' ?>>
                                        Reservado</option>
                                </select>
                            </div>

                            <!-- Tamaño -->
                            <div class="form-group col-md-4">
                                <label for="tamanio">Tamaño <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tamanio"
                                    value="<?= $propiedad['tamanio'] ?>" required
                                    <?= $modo_ver ? 'readonly' : '' ?>>
                            </div>

                            <!-- Descripción -->
                            <div class="form-group col-md-4">
                                <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="descripcion" rows="3" required
                                    <?= $modo_ver ? 'readonly' : '' ?>><?= $propiedad['descripcion'] ?></textarea>
                            </div>

                            <!-- Propietario -->
                            <div class="form-group col-md-6">
                                <label for="propietario_id">Propietario <span class="text-danger">*</span></label>
                                <select class="form-control" name="propietario_id" required
                                    <?= $modo_ver ? 'disabled' : '' ?>>
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

                            <!-- Imágenes -->
                            <div class="form-group col-md-6">
                                <label>Imágenes (puedes seleccionar varias)</label>
                                <input type="file" name="imagenes[]" class="form-control" multiple
                                    <?= $modo_ver ? 'disabled' : '' ?>>
                            </div>
                        </div>

                        <?php if ($modo_ver): ?>
                        <a href="propiedades.php" class="btn btn-light">Volver</a>
                        <?php else: ?>
                        <button type="submit"
                            class="btn btn-primary mr-2"><?= $modo_edicion ? 'Actualizar' : 'Guardar' ?></button>
                        <a href="propiedades.php" class="btn btn-light">Cancelar</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabla de propiedades -->
        <div class="col-12 grid-margin stretch-card">
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
                                            <a href="propiedades.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info" title="Ver">
                                                <i class="typcn typcn-eye"></i>
                                            </a>
                                            <a href="propiedades.php?editar=' . $row['id'] . '" class="btn btn-sm btn-primary" title="Editar">
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
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © <a
                    href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com</a> 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Free <a
                    href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard </a>templates from
                Bootstrapdash.com</span>
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
    <script>
    document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-icon-only');
    });
    </script>
</body>

</html>