<?php
require_once 'config/conexion.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Inicializa $rol desde la sesión
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'invitado';

$modo_edicion = false;
$modo_ver = false;

$cliente = [
    'id' => '',
    'ci' => '',
    'nombre_completo' => '',
    'telefono' => '',
    'genero' => '',
    'email' => ''
];

// Modo ver
if (isset($_GET['ver'])) {
    $modo_ver = true;
    $id = intval($_GET['ver']);
    $resultado = $conexion->query("SELECT * FROM cliente WHERE id = $id");
    if ($resultado && $resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();
        $nombre_completo = trim($cliente['nombre_completo'] ?? '');
        $partes = explode(' ', $nombre_completo);
        switch (count($partes)) {
            case 2:
                [$cliente['primer_nombre'], $cliente['primer_apellido']] = $partes;
                break;
            case 3:
                [$cliente['primer_nombre'], $cliente['primer_apellido'], $cliente['segundo_apellido']] = $partes;
                break;
            default:
                $cliente['primer_nombre']   = $partes[0] ?? '';
                $cliente['segundo_nombre']  = $partes[1] ?? '';
                $cliente['primer_apellido'] = $partes[2] ?? '';
                $cliente['segundo_apellido']= $partes[3] ?? '';
        }
    }
}

// Modo edición
elseif (isset($_GET['editar'])) {
    $modo_edicion = true;
    $id = intval($_GET['editar']);
    $resultado = $conexion->query("SELECT * FROM cliente WHERE id = $id");
    if ($resultado && $resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();
        $nombre_completo = trim($cliente['nombre_completo'] ?? '');
        $partes = explode(' ', $nombre_completo);
        switch (count($partes)) {
            case 2:
                [$cliente['primer_nombre'], $cliente['primer_apellido']] = $partes;
                break;
            case 3:
                [$cliente['primer_nombre'], $cliente['primer_apellido'], $cliente['segundo_apellido']] = $partes;
                break;
            default:
                $cliente['primer_nombre']   = $partes[0] ?? '';
                $cliente['segundo_nombre']  = $partes[1] ?? '';
                $cliente['primer_apellido'] = $partes[2] ?? '';
                $cliente['segundo_apellido']= $partes[3] ?? '';
        }
    }
}

// Registro o actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ci = $_POST['ci'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];

    if (!empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conexion->prepare("UPDATE cliente SET ci=?, nombre_completo=?, telefono=?, genero=?, email=? WHERE id=?");
        $stmt->bind_param("sssssi", $ci, $nombre, $telefono, $genero, $email, $id);
    } else {
        $stmt = $conexion->prepare("INSERT INTO cliente (ci, nombre_completo, telefono, genero, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $ci, $nombre, $telefono, $genero, $email);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: clientes.php");
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
                            <h3 class="mb-0 font-weight-bold">Clientes</h3>
                        </div>
                    </div>
                    <div class="content-wrapper">
                        <div class="row">
                            <!-- Formulario para registrar / editar cliente -->
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <?= $modo_edicion ? 'Editar Cliente' : 'Registrar Cliente' ?>
                                        </h4>
                                        <form class="forms-sample" id="formCliente" method="POST" action=""
                                            <?= $modo_ver ? 'onsubmit="return false;"' : '' ?>>
                                            <!-- input ocultos -->
                                            <input type="hidden" name="nombre" id="nombre_completo"
                                                value="<?= $cliente['nombre_completo'] ?? '' ?>">
                                            <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

                                            <p class="text-muted mb-3"><span class="text-danger">*</span> Campos
                                                obligatorios</p>

                                            <div class="form-row">
                                                <!-- Cédula -->
                                                <div class="form-group col-md-4">
                                                    <label for="ci">Cédula <span class="text-danger">*</span></label>
                                                    <input type="text" id="ci" name="ci" class="form-control"
                                                        value="<?= $cliente['ci'] ?? '' ?>" required
                                                        <?= $modo_ver ? 'readonly' : '' ?> maxlength="10" 
                                                    oninput="formatearCedula(this)">
                                                    <small class="form-text text-muted">Ej: 12.345.678 (máx.
                                                        34.000.000)</small>
                                                </div>

                                                <!-- Primer Nombre -->
                                                <div class="form-group col-md-4">
                                                    <label for="primer_nombre">Primer Nombre <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="primer_nombre" class="form-control"
                                                        value="<?= $cliente['primer_nombre'] ?? '' ?>"
                                                        <?= $modo_ver ? 'readonly' : '' ?> required
                                                        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                                </div>

                                                <!-- Segundo Nombre -->
                                                <div class="form-group col-md-4">
                                                    <label for="segundo_nombre">Segundo Nombre</label>
                                                    <input type="text" id="segundo_nombre" class="form-control"
                                                        value="<?= $cliente['segundo_nombre'] ?? '' ?>"
                                                        <?= $modo_ver ? 'readonly' : '' ?>
                                                        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                                </div>

                                                <!-- Primer Apellido -->
                                                <div class="form-group col-md-4">
                                                    <label for="primer_apellido">Primer Apellido <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="primer_apellido" class="form-control"
                                                        value="<?= $cliente['primer_apellido'] ?? '' ?>"
                                                        <?= $modo_ver ? 'readonly' : '' ?> required
                                                        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                                </div>

                                                <!-- Segundo Apellido -->
                                                <div class="form-group col-md-4">
                                                    <label for="segundo_apellido">Segundo Apellido</label>
                                                    <input type="text" id="segundo_apellido" class="form-control"
                                                        value="<?= $cliente['segundo_apellido'] ?? '' ?>"
                                                        <?= $modo_ver ? 'readonly' : '' ?>
                                                        oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                                                </div>

                                                <!-- Teléfono -->
                                                <div class="form-group col-md-4">
                                                    <label for="telefono">Teléfono <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="telefono" name="telefono"
                                                        class="form-control" value="<?= $cliente['telefono'] ?? '' ?>"
                                                        maxlength="12" pattern="0(41[2466]|42[24])-\d{7}"
                                                        <?= $modo_ver ? 'readonly' : '' ?> required>
                                                    <small class="form-text text-muted">Ej.: 0412-1234567</small>
                                                </div>

                                                <!-- Género -->
                                                <div class="form-group col-md-4">
                                                    <label for="genero">Género <span
                                                            class="text-danger">*</span></label>
                                                    <select id="genero" name="genero" class="form-control"
                                                        <?= $modo_ver ? 'disabled' : '' ?> required>
                                                        <option value="">Seleccione</option>
                                                        <option value="M"
                                                            <?= $cliente['genero']=='M'   ? 'selected' : '' ?>>Masculino
                                                        </option>
                                                        <option value="F"
                                                            <?= $cliente['genero']=='F'   ? 'selected' : '' ?>>Femenino
                                                        </option>
                                                        <option value="Otro"
                                                            <?= $cliente['genero']=='Otro'? 'selected' : '' ?>>Otro
                                                        </option>
                                                    </select>
                                                </div>

                                                <!-- Email -->
                                                <div class="form-group col-md-4">
                                                    <label for="email">Correo electrónico <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" id="email" name="email" class="form-control"
                                                        value="<?= $cliente['email'] ?? '' ?>" required
                                                        <?= $modo_ver ? 'readonly' : '' ?>>
                                                </div>
                                            </div>

                                            <?php if (!$modo_ver): ?>
                                            <button type="submit" class="btn btn-primary mr-2">
                                                <?= $modo_edicion ? 'Actualizar' : 'Guardar' ?>
                                            </button>
                                            <a href="clientes.php" class="btn btn-light">Cancelar</a>
                                            <?php else: ?>
                                            <a href="clientes.php" class="btn btn-light">Volver</a>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de clientes -->
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Lista de Clientes</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="tablaClientes">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>C.I.</th>
                                                        <th>Nombre</th>
                                                        <th>Teléfono</th>
                                                        <th>Género</th>
                                                        <th>Email</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                $resultado = $conexion->query("SELECT * FROM cliente");
                                while ($row = $resultado->fetch_assoc()) {
                                    echo '<tr>
                                        <td>' . $row['id'] . '</td>
                                        <td>' . $row['ci'] . '</td>
                                        <td>' . $row['nombre_completo'] . '</td>
                                        <td>' . $row['telefono'] . '</td>
                                        <td>' . $row['genero'] . '</td>
                                        <td>' . $row['email'] . '</td>
                                        <td>
                                            <a href="clientes.php?ver=' . $row['id'] . '" class="btn btn-sm btn-info" title="Ver">
                                                <i class="typcn typcn-eye"></i></a>
                                            <a href="clientes.php?editar=' . $row['id'] . '" class="btn btn-sm btn-primary" title="Editar">
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
        $('#tablaClientes').DataTable();
    });
    </script>
    <script>
    document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-icon-only');
    });
    </script>
    <script>
    (function() {
        const buildNombreCompleto = () => {
            const partes = [
                primerNombre.value.trim(),
                segundoNombre.value.trim(),
                primerApellido.value.trim(),
                segundoApellido.value.trim()
            ].filter(Boolean).join(' ');
            nombreCompleto.value = partes;
        };

        const primerNombre = document.getElementById('primer_nombre');
        const segundoNombre = document.getElementById('segundo_nombre');
        const primerApellido = document.getElementById('primer_apellido');
        const segundoApellido = document.getElementById('segundo_apellido');
        const nombreCompleto = document.getElementById('nombre_completo');
        [primerNombre, segundoNombre, primerApellido, segundoApellido]
        .forEach(i => i.addEventListener('input', buildNombreCompleto));
        buildNombreCompleto();

        // Teléfono 0412-1234567
        const tel = document.getElementById('telefono');
        tel && tel.addEventListener('input', () => {
            let v = tel.value.replace(/\D/g, '').slice(0, 11);
            if (v.length > 4) v = v.slice(0, 4) + '-' + v.slice(4);
            tel.value = v;
        });
    })();
    </script>
    <script>
    function formatearCedula(input) {
        let valor = input.value.replace(/\D/g, '').slice(0, 8); // Solo dígitos, máx 8

        if (parseInt(valor) > 34000000) {
            valor = '34000000';
        }

        // Formatea con puntos (ej: 12345678 => 12.345.678)
        let formateado = '';
        if (valor.length <= 3) {
            formateado = valor;
        } else if (valor.length <= 6) {
            formateado = valor.slice(0, valor.length - 3) + '.' + valor.slice(-3);
        } else {
            formateado = valor.slice(0, valor.length - 6) + '.' +
                valor.slice(-6, -3) + '.' + valor.slice(-3);
        }

        input.value = formateado;
    }
    </script>
</body>
</html>