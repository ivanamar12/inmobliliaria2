<?php
require_once 'config/conexion.php';

session_start();

// Asegúrate de que $_SESSION['rol'] esté definido y tenga un valor válido
if (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = 'invitado'; // Valor por defecto si no está definido
}

$rol = $_SESSION['rol'];

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
                            <h3 class="mb-0 font-weight-bold">Ventas </h3>
                        </div>
                    </div>

                    <div class="content-wrapper">
                        <div class="row">
                            <!-- Formulario de registrar / editar venta -->
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <?= $modo_edicion ? 'Editar Venta' : ($modo_ver ? 'Ver Venta' : 'Registrar Venta') ?>
                                        </h4>

                                        <form method="POST" class="forms-sample">
                                            <input type="hidden" name="id" value="<?= $venta['id'] ?>">

                                            <div class="form-row">
                                                <!-- Fecha -->
                                                <div class="form-group col-md-6">
                                                    <label for="fecha">Fecha</label>
                                                    <input type="text" class="form-control" name="fecha"
                                                        value="<?= date('Y-m-d') ?? $venta['fecha'] ?>" readonly>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="monto">Monto</label>
                                                    <input type="text" class="form-control" name="monto" id="monto"
                                                        value="<?= htmlspecialchars($venta['monto']) ?>"
                                                        <?= $modo_ver ? 'readonly' : 'required' ?>
                                                        oninput="formatMonto(this)" maxlength="12">
                                                </div>

                                                <!-- Cliente -->
                                                <div class="form-group col-md-6">
                                                    <label for="cliente_id">Cliente</label>
                                                    <select class="form-control" name="cliente_id"
                                                        <?= $modo_ver ? 'disabled' : 'required' ?>>
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

                                                <!-- Agente -->
                                                <div class="form-group col-md-6">
                                                    <label for="agente_id">Agente</label>
                                                    <select class="form-control" name="agente_id"
                                                        <?= $modo_ver ? 'disabled' : 'required' ?>>
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
                                            </div>

                                            <?php if ($modo_ver) : ?>
                                            <a href="ventas.php" class="btn btn-light">Volver</a>
                                            <?php else : ?>
                                            <button type="submit"
                                                class="btn btn-primary mr-2"><?= $modo_edicion ? 'Actualizar' : 'Guardar' ?></button>
                                            <a href="ventas.php" class="btn btn-light">Cancelar</a>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de ventas -->
                            <div class="col-12 grid-margin stretch-card">
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
                                                                <a href="ventas.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info" title="Ver">
                                                                    <i class="typcn typcn-eye"></i>
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
            <script>
            document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
                document.body.classList.toggle('sidebar-icon-only');
            });
            </script>
            <script>
            function formatMonto(input) {
                // Eliminar caracteres no numéricos, excepto la coma y el punto
                let value = input.value.replace(/[^0-9]/g, '');
                // Limitar a 12 cifras
                if (value.length > 12) {
                    value = value.slice(0, 12);
                }
                if (value.length > 9) {
                    value = value.slice(0, 9) + ',' + value.slice(9);
                }
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                input.value = value;
            }
            </script>
</body>

</html>