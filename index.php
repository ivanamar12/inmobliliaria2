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

    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide" data-ride="carousel" data-interval="6000">
            <!-- Indicadores del Carrusel -->
            <ol class="carousel-indicators">
                <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#header-carousel" data-slide-to="1"></li>
            </ol>

            <div class="carousel-inner">
                <!-- Primera diapositiva - Imagen de ciudad con logo -->
                <div class="carousel-item active">
                    <img class="w-100" src="img/edificio.jpg" alt="Ciudad y propiedades">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-4 text-center" style="max-width: 800px;">
                            <h1 class="display-3 text-white mb-4 font-weight-bold"
                                style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">HOME & STYLE</h1>
                        </div>
                    </div>
                </div>

                <!-- Segunda diapositiva - Agentes -->
                <div class="carousel-item">
                    <img class="w-100" src="img/casa.webp" alt="Nuestros agentes inmobiliarios">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-4 text-center"
                            style="max-width: 700px; background: rgba(0, 0, 0, 0.6); border-radius: 10px;">
                            <h3 class="text-uppercase text-white mb-3">Nuestro Equipo</h3>
                            <h2 class="text-white mb-4 font-weight-bold">Marian, Catherine & Eliangy</h2>
                            <p class="lead text-white mb-0">La inmobiliaria más confiable y destacada de Venezuela</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Controles del Carrusel mejorados -->
            <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                <div class="btn btn-primary rounded-circle" style="width: 50px; height: 50px;">
                    <span class="carousel-control-prev-icon"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                <div class="btn btn-primary rounded-circle" style="width: 50px; height: 50px;">
                    <span class="carousel-control-next-icon"></span>
                </div>
            </a>
        </div>
    </div>



    <!-- Contact Info Start -->
    <div class="container-fluid contact-info mt-5 mb-4">
        <div class="container" style="padding: 0 30px;">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-secondary mb-4 mb-lg-0"
                    style="height: 100px;">
                    <div class="d-inline-flex">
                        <i class="fa fa-2x fa-map-marker-alt text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Ubicación</h5>
                            <p class="m-0 text-white">Caracas, Venezuela</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-primary mb-4 mb-lg-0"
                    style="height: 100px;">
                    <div class="d-inline-flex text-left">
                        <i class="fa fa-2x fa-envelope text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Correo Electrónico</h5>
                            <p class="m-0 text-white">home&style@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-secondary mb-4 mb-lg-0"
                    style="height: 100px;">
                    <div class="d-inline-flex text-left">
                        <i class="fa fa-2x fa-phone-alt text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Contáctanos</h5>
                            <p class="m-0 text-white">+58 412 586 437</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Info End -->


    <div class="container-fluid py-5">
        <div class="container pt-0 pt-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <img class="img-fluid" src="img/reunion.jpg" alt="">
                </div>
                <div class="col-lg-7 mt-5 mt-lg-0 pl-lg-5 d-flex flex-column align-items-center">
                    <h6 class="text-secondary text-uppercase font-weight-medium mb-3 text-center">Conoce más sobre
                        nosotros</h6>
                    <h1 class="mb-4 text-center">Gestión de Clientes (40%)</h1>
                    <h5 class="font-weight-medium font-italic mb-4 text-center">
                        Mantener un registro detallado de cada cliente, incluyendo sus compras, preferencias, y
                        cualquier retroalimentación que hayan proporcionado.
                        Este punto podría representar el 40% de los esfuerzos, ya que mantener una buena relación con
                        los clientes es crucial para cualquier negocio.
                    </h5>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>



    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container pt-0 pt-lg-4">
            <div class="row align-items-center">
                <!-- Imagen a la izquierda -->
                <div class="col-lg-5">
                    <img class="img-fluid" src="img/casa.webp" alt="Reunión sobre gestión de propiedades">
                </div>
                <!-- Texto a la derecha con tamaño uniforme -->
                <div class="col-lg-7 mt-5 mt-lg-0 pl-lg-5 d-flex flex-column align-items-center">
                    <h6 class="text-secondary text-uppercase font-weight-medium mb-3 text-center"></h6>
                    <h1 class="mb-4 text-center">Gestión de Propiedad (30%)</h1>
                    <h5 class="font-weight-medium font-italic mb-4 text-center">
                        Mantener un control efectivo de las propiedades, incluyendo su mantenimiento, administración y
                        cumplimiento de estándares de calidad.
                        Este punto podría representar el 30% de los esfuerzos, ya que garantizar la seguridad y el buen
                        estado de las instalaciones es esencial para clientes y empleados.
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 m-0 my-lg-5 pt-0 pt-lg-5 pr-lg-5">
                    <h1 class="mb-4">¿Por qué elegirnos?</h1>
                    <p>Nuestra agencia HOME & STYLE, a pesar de su reciente entrada en el competitivo mercado
                        inmobiliario, ha logrado destacarse por sus impresionantes resultados. En poco tiempo, hemos
                        consolidado una reputación de excelencia y eficacia, logrando satisfacer las necesidades de
                        nuestros clientes de manera extraordinaria.</p>
                    <div class="row">
                        <div class="col-sm-6 mb-4">

                            <h1 class="text-secondary" data-toggle="counter-up">5</h1>
                            <h5 class="font-weight-bold">Años de Experiencia</h5>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <h1 class="text-secondary" data-toggle="counter-up">95</h1>
                            <h5 class="font-weight-bold">Trabajadores Expertos</h5>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <h1 class="text-secondary" data-toggle="counter-up">357</h1>
                            <h5 class="font-weight-bold">Clientes Felices</h5>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <h1 class="text-secondary" data-toggle="counter-up">753</h1>
                            <h5 class="font-weight-bold">Propiedades Disponibles</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div
                        class="d-flex flex-column align-items-center justify-content-center bg-secondary h-100 py-5 px-3">
                        <i class="fa fa-5x fa-certificate text-white mb-5"></i>
                        <h1 class="display-1 text-white mb-3">5+</h1>
                        <h1 class="text-white m-0">Años de Experiencia</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->
    <!-- Working Process Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <h6 class="text-secondary text-uppercase text-center font-weight-medium mb-3"></h6>
            <h1 class="display-4 text-center mb-5">¿Comó Trabajamos?</h1>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4"
                            style="width: 150px; height: 150px; border-width: 15px !important;">
                            <h2 class="display-2 text-secondary m-0">1</h2>
                        </div>
                        <h3 class="font-weight-bold m-0 mt-2">Busca una casa</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4"
                            style="width: 150px; height: 150px; border-width: 15px !important;">
                            <h2 class="display-2 text-secondary m-0">2</h2>
                        </div>
                        <h3 class="font-weight-bold m-0 mt-2">La vemos</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4"
                            style="width: 150px; height: 150px; border-width: 15px !important;">
                            <h2 class="display-2 text-secondary m-0">3</h2>
                        </div>
                        <h3 class="font-weight-bold m-0 mt-2">Y si te gusta</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4"
                            style="width: 150px; height: 150px; border-width: 15px !important;">
                            <h2 class="display-2 text-secondary m-0">4</h2>
                        </div>
                        <h3 class="font-weight-bold m-0 mt-2">La negociamos para que sea tuya</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Working Process End -->


    <!-- Pricing Plan Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Renta de apartamentos</h1>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="bg-light text-center mb-2 pt-4">
                        <div class="d-inline-flex flex-column align-items-center justify-content-center bg-secondary rounded-circle shadow mt-2 mb-4"
                            style="width: 200px; height: 200px; border: 15px solid #ffffff;">
                            <h3 class="text-white">Básico</h3>
                            <h1 class="display-4 text-white mb-0">
                                <small class="align-top" style="font-size: 22px; line-height: 45px;">$</small>290<small
                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Mo</small>
                            </h1>
                        </div>
                        <div class="d-flex flex-column align-items-center py-3">
                            <p>2 habitaciones</p>
                            <p>1 Baño</p>
                            <p>1 Sala</p>
                            <p>1 Cocina</p>

                        </div>
                        <a href="" class="btn btn-secondary py-2 px-4">Signup Now</a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="bg-light text-center mb-2 pt-4">
                        <div class="d-inline-flex flex-column align-items-center justify-content-center bg-primary rounded-circle shadow mt-2 mb-4"
                            style="width: 200px; height: 200px; border: 15px solid #ffffff;">
                            <h3 class="text-white">Media</h3>
                            <h1 class="display-4 text-white mb-0">
                                <small class="align-top" style="font-size: 22px; line-height: 45px;">$</small>500<small
                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Mo</small>
                            </h1>
                        </div>
                        <div class="d-flex flex-column align-items-center py-3">
                            <p>4 habitaciones</p>
                            <p>3 baños</p>
                            <p>1 una sala interna</p>
                            <p>1 Una sala Externa</p>
                            <p>1 Una cocina</p>
                        </div>
                        <a href="" class="btn btn-primary py-2 px-4">Signup Now</a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="bg-light text-center mb-2 pt-4">
                        <div class="d-inline-flex flex-column align-items-center justify-content-center bg-secondary rounded-circle shadow mt-2 mb-4"
                            style="width: 200px; height: 200px; border: 15px solid #ffffff;">
                            <h3 class="text-white">Premium</h3>
                            <h1 class="display-4 text-white mb-0">
                                <small class="align-top" style="font-size: 22px; line-height: 35px;">$</small>950<small
                                    class="align-bottom" style="font-size: 16px; line-height: 35px;">/ Mo</small>
                            </h1>
                        </div>
                        <div class="d-flex flex-column align-items-center py-3">
                            <p>6 habitaciones</p>
                            <p>5 baños</p>
                            <p>1 una sala interna</p>
                            <p>1 Una sala Externa</p>
                            <p>1 Una cocina</p>
                            <p>1 pscina</p>
                            <p>Jacuzzi</p>
                        </div>
                        <a href="" class="btn btn-secondary py-2 px-4">Signup Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pricing Plan End -->


    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container">

            <h1 class="display-4 text-center mb-5">Nuestros Clientes</h1>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item">
                    <img class="position-relative rounded-circle bg-white shadow mx-auto" src="img/chicauno.jpg"
                        style="width: 100px; height: 100px; padding: 12px; margin-bottom: -50px; z-index: 1;" alt="">
                    <div class="bg-light text-center p-4 pt-0">
                        <h5 class="font-weight-medium mt-5">Ana Fernández</h5>
                        <p class="text-muted font-italic">CEO de una empresa</p>
                        <p class="m-0">Ha comprado 3 casas: una en la ciudad, otra en la playa, y una cabaña en el
                            bosque para escapadas tranquilas.</p>
                    </div>
                </div>
                <div class="testimonial-item">
                    <img class="position-relative rounded-circle bg-white shadow mx-auto" src="img/hombreuno.jpg"
                        style="width: 100px; height: 100px; padding: 12px; margin-bottom: -50px; z-index: 1;" alt="">
                    <div class="bg-light text-center p-4 pt-0">
                        <h5 class="font-weight-medium mt-5">Carlos Ramírez</h5>
                        <p class="text-muted font-italic">Informatico</p>
                        <p class="m-0">Ha adquirido 4 casas: dos de ellas como inversión para rentas y dos para
                            disfrutar con su familia.</p>
                    </div>
                </div>
                <div class="testimonial-item">
                    <img class="position-relative rounded-circle bg-white shadow mx-auto" src="img/chicados.jpg"
                        style="width: 100px; height: 100px; padding: 12px; margin-bottom: -50px; z-index: 1;" alt="">
                    <div class="bg-light text-center p-4 pt-0">
                        <h5 class="font-weight-medium mt-5">María López</h5>
                        <p class="text-muted font-italic">Entrenadora</p>
                        <p class="m-0">Posee 2 casas: una residencia moderna en el centro y una casa rústica en el campo
                            donde cultiva su propio jardín.</p>
                    </div>
                </div>
                <div class="testimonial-item">
                    <img class="position-relative rounded-circle bg-white shadow mx-auto" src="img/hombredos.jpg"
                        style="width: 100px; height: 100px; padding: 12px; margin-bottom: -50px; z-index: 1;" alt="">
                    <div class="bg-light text-center p-4 pt-0">
                        <h5 class="font-weight-medium mt-5">Juan Pérez </h5>
                        <p class="text-muted font-italic">Maestro</p>
                        <p class="m-0">Tiene 1 casa, un hogar acogedor lleno de recuerdos y espacio para sus aficiones.>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

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
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
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