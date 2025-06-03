<?php
require_once 'config/conexion.php';

// Traer propiedades de tipo "lujoso"
$sql = "
  SELECT p.*, pr.nombre AS propietario
  FROM propiedad p
  LEFT JOIN propietario pr ON p.propietario_id = pr.id
  WHERE p.tipo = 'lujosa'
";
$propiedades = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> HOME & STYLE</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/Logo.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="css/css2.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap CSS (AGREGA ESTO) -->
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
   <div class="container-fluid bg-primary py-3">
        <div class="container">
            <div class="row">
                
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="index.php" class="navbar-brand">
                    <h1 class="m-0 text-secondary"><span class="text-primary">HOME &</span>STYLE</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Inicio</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Casas</a>
                            <div class="dropdown-menu border-0 rounded-0 m-0">
                                <a href="blog.php" class="dropdown-item">Casas económicas</a>
                                <a href="single.php" class="dropdown-item">Casas de lujo</a>
                            </div>
                        </div>

                        <a href="contact.php" class="nav-item nav-link">Contáctanos</a>
                        <a href="login.php" class="nav-item nav-link">Iniciar Sesión</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Navbar End -->
    <!-- Page Header Start -->
    <div class="page-header container-fluid bg-secondary pt-2 pt-lg-5 pb-2 mb-5">
        <div class="container py-2">
            <div class="row align-items-center py-1">
                <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                    <h1 class="mb-3 mb-md-0 text-white">Casas de lujo</h1>

                    <!-- Barra de Búsqueda Integrada -->


                </div>

                <div class="col-md-6 text-center text-md-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="btn text-white" href="">Home</a>
                        <i class="fas fa-angle-right text-white px-2"></i>
                        <a class="btn text-white disabled" href="">Blog</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Estilos para la barra de búsqueda -->


    <!-- Listado de Propiedades -->
    <div class="row" style="display: flex; flex-wrap: wrap; margin: 0 -10px;">
        <?php while ($propiedad = $propiedades->fetch_assoc()): ?>
        <?php
        // Buscar primera imagen asociada
        $idProp = $propiedad['id'];
        $imgQuery = $conexion->query("SELECT ruta FROM propiedad_imagen WHERE propiedad_id = $idProp LIMIT 1");
        $img = $imgQuery->fetch_assoc();
        $rutaImagen = ($img && file_exists($img['ruta'])) ? $img['ruta'] : 'images/default.jpg';
        ?>
        <div class="col-md-4 mb-4" style="flex: 0 0 33.333%; max-width: 33.333%; padding: 0 10px;">
            <div class="bg-light h-100 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                <div class="position-relative">
                    <a href="#" class="d-block text-center mb-2">
                        <img src="<?= $rutaImagen ?>" class="img-fluid w-100" alt="Imagen propiedad"
                            style="width: 100%; height: 300px; object-fit: cover;">
                    </a>
                </div>
                <div class="p-4">
                    <small class="d-block mb-2">
                        <i class="fa fa-user text-secondary mr-1"></i>
                        Agente: <?= htmlspecialchars($propiedad['propietario'] ?? 'No asignado') ?>
                    </small>
                    <h3 class="mb-3"><?= htmlspecialchars($propiedad['nombre']) ?></h3>
                    <p class="mb-3"><?= substr($propiedad['descripcion'], 0, 100) . '...' ?></p>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><strong>Estado:</strong>
                            <span class="badge badge-success"><?= $propiedad['estado'] ?></span>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-success mb-0">$<?= number_format($propiedad['precio'], 2) ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    </div>
    </div>

</body>

</html>



<!-- Footer Final -->
<!-- Columna del Logo con texto unificado -->
<!-- Footer Start -->
<!-- Footer Start -->
<div class="container-fluid bg-primary text-white mt-5 pt-5 px-sm-3 px-md-5">
    <div class="row pt-5">
        <!-- Columna del Logo con texto unificado -->
        <div class="col-lg-4 col-md-6 mb-5">
            <a href="" class="d-block mb-3">
                <h1 class="text-secondary mb-2"><span class="text-white">HOME</span>&STYLE</h1>
            </a>
            <p class="mb-3">Busque su casa, apartamento, comercial, terreno...con nuestra inmobiliaria</p>
            <p class="mb-1"><i class="fa fa-map-marker-alt mr-2"></i>Caracas, Venezuela</p>
            <p class="mb-1"><i class="fa fa-phone-alt mr-2"></i>+58 412 586 4370</p>
            <p class="mb-4"><i class="fa fa-envelope mr-2"></i>home&style@gmail.com</p>

            <div class="d-flex justify-content-start mt-4">
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;"
                    href="#"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;"
                    href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;"
                    href="#"><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;"
                    href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <!-- Columna de Enlaces Rápidos -->
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-white mb-4">Enlaces Rápidos</h4>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Inicio</a>
                <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Contacto</a>

            </div>
        </div>



        <!-- Columna de Registro de Cliente -->

        <script>
        function validarFormulario() {
            // Validación adicional del lado del cliente
            const telefono = document.querySelector('input[name="telefono"]').value;
            if (!/^[0-9+]+$/.test(telefono)) {
                alert('El teléfono solo puede contener números y el signo +');
                return false;
            }
            return true;
        }
        </script>

        <!-- Footer End -->
        <!-- Resto del footer  -->

        <div class="container-fluid bg-dark text-white py-4 px-sm-3 px-md-5">
            <p class="m-0 text-center text-white">
                &copy; <a class="text-white font-weight-medium" href="#">HOME
                    & STYLE</a>. Todos los derechos reservados.
            </p>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

        <!-- JavaScript Libraries -->
        <!-- jQuery (primero siempre) -->
        <script src="js/jquery-3.4.1.min.js"></script>

        <!-- Popper.js (requerido por Bootstrap 4 para dropdowns) -->
        <script src="js/popper.min.js"></script>

        <!-- Bootstrap JS (después de jQuery y Popper) -->
        <script src="js/bootstrap.min.js"></script>

        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>

        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        </body>

        </html>

        </html>