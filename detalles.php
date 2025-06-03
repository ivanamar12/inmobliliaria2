<!DOCTYPE html>
<html lang="en">
@include('componentes.head')
<body>
    <!-- Topbar Start -->
    @include('componentes.topbar')
    <!-- Topbar End -->
    <!-- Navbar Start -->
    @include('componentes.navbar')
    <!-- Navbar End -->
<!-- Navbar End -->
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Casa RF110</title>
<div class="container-fluid px-0">
    <div class="row no-gutters">
      <!-- Primer Propiedad - Sala -->

<!-- Galería de Imágenes - Versión Ancha -->
<div class="container-fluid mt-5 pb-2 px-0">
    <div class="container px-0">
        <h1 class="display-4 text-center mb-5">Galería de Imágenes</h1>
        <div class="row mx-0">
            <!-- Imagen 1 -->
            <div class="col-lg-4 col-md-6 mb-4 px-2">
                <div class="shadow mb-4 w-100">
                    <div class="position-relative" style="height: 350px; overflow: hidden;">
                        <img class="w-100 h-100 object-fit-cover" src="assets/img/18-Divine-Rustic-Living-Room-Designs-You-Will-Simply-Adore-7-630x420.jpg" alt="Sala">
                        <a href="#" class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none p-4" style="top: 0; left: 0; background: rgba(0, 0, 0, .4);">
                            <h4 class="text-center text-white font-weight-medium mb-3">Interior de la Sala</h4>
                            <div class="d-flex text-light">
                                <small class="mr-2"><i class="fa fa-map-marker-alt text-secondary"></i> Caracas</small>
                                <small class="mr-2"><i class="fa fa-ruler-combined text-secondary"></i> 50m²</small>
                            </div>
                        </a>
                    </div>
                    <p class="m-0 p-4">Elegante sala con acabados modernos y excelente iluminación natural.</p>
                </div>
            </div>
            <!-- Imagen 2 -->
            <div class="col-lg-4 col-md-6 mb-4 px-2">
                <div class="shadow mb-4 w-100">
                    <div class="position-relative" style="height: 350px; overflow: hidden;">
                        <img class="w-100 h-100 object-fit-cover" src="assets/img/habitaciones.png" alt="Habitación">
                        <a href="#" class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none p-4" style="top: 0; left: 0; background: rgba(0, 0, 0, .4);">
                            <h4 class="text-center text-white font-weight-medium mb-3">Habitación Principal</h4>
                            <div class="d-flex text-light">
                                <small class="mr-2"><i class="fa fa-bed text-secondary"></i> 1 cama King</small>
                                <small class="mr-2"><i class="fa fa-map-marker-alt text-secondary"></i> Valencia</small>
                            </div>
                        </a>
                    </div>
                    <p class="m-0 p-4">Habitación espaciosa con detalles elegantes y baño privado.</p>
                </div>
            </div>
            <!-- Imagen 3 -->
            <div class="col-lg-4 col-md-6 mb-4 px-2">
                <div class="shadow mb-4 w-100">
                    <div class="position-relative" style="height: 350px; overflow: hidden;">
                        <img class="w-100 h-100 object-fit-cover" src="assets/img/BAÑOS.jpg" alt="Baño">
                        <a href="#" class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none p-4" style="top: 0; left: 0; background: rgba(0, 0, 0, .4);">
                            <h4 class="text-center text-white font-weight-medium mb-3">Baño Principal</h4>
                            <div class="d-flex text-light">
                                <small class="mr-2"><i class="fa fa-water text-secondary"></i> Jacuzzi</small>
                                <small class="mr-2"><i class="fa fa-map-marker-alt text-secondary"></i> Maracaibo</small>
                            </div>
                        </a>
                    </div>
                    <p class="m-0 p-4">Baño de lujo con jacuzzi, ducha de hidromasaje y acabados modernos.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container-fluid.px-0 {
        padding-left: 0;
        padding-right: 0;
    }
    .container.px-0 {
        padding-left: 0;
        padding-right: 0;
        max-width: 95%;
    }
    .row.mx-0 {
        margin-left: -10px;
        margin-right: -10px;
    }
    .col-lg-4.px-2 {
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
 <!-- Contactar -->
 <div class="col-lg-4 mb-2">
    <div class="shadow mb-4 p-4 contact-form-container">
        <h2 class="mb-4">Contactar Agente</h2>
        
        <!-- Info del Agente -->
        <div class="agent-info mb-4 p-3 bg-light rounded">
            <h5 class="font-weight-bold">Agente responsable:</h5>
            <p class="mb-1"><i class="fas fa-user"></i> <?php echo htmlspecialchars($agente['pnombre'].' '.$agente['papellido']); ?></p>
            <p class="mb-1"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($agente['telefono']); ?></p>
            <p class="mb-0"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($agente['correo']); ?></p>
        </div>

        <!-- Formulario de Contacto -->
        <form id="contactForm" method="POST" action="procesar_contacto.php">
            <!-- Campo oculto con el ID del agente -->
            <input type="hidden" name="id_agente" value="<?php echo $agente['idagente']; ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre completo:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="number" class="form-control" id="telefono" name="telefono" required>
            </div>
            
            <div class="form-group">
                <label for="mensaje">Mensaje:</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Enviar Mensaje</button>
        </form>
    </div>
</div>

<style>
    .contact-form-container {
        border-radius: 8px;
    }
    .agent-info {
        border-left: 4px solid #007bff;
    }
    .form-group {
        margin-bottom: 1.2rem;
    }
</style>
            <!-- Detalles de la Propiedad -->
            <div class="col-lg-4 mb-4 px-3">
                <div class="shadow h-100 p-4" style="min-height: 450px;">
                    <h2 class="text-primary mb-4">Detalles de la Propiedad</h2>
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Dispositivos:</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Aire Acondicionado</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Cable</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Calentador de Agua</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Ascensores</li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Artefactos:</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Cocina</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Horno de Pared</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Horno Microondas</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Refrigerador</li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-weight-bold">Construcción:</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Pisos: Madera Flotante</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Ventanas Panorámicas</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Precio -->
            <div class="col-lg-4 mb-4 px-3">
                <div class="shadow h-100 p-4" style="min-height: 450px;">
                    <h2 class="text-primary mb-4">Precio</h2>
                    
                    <!-- Barra de Rango de Precios Interactiva -->
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Rango de Precio:</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge badge-primary p-2">$1,500</span>
                            <span class="badge badge-primary p-2">$500,000</span>
                        </div>
                        <input type="range" class="custom-range" min="1500" max="500000" step="1000" id="priceRange">
                        <div class="text-center mt-2">
                            <span id="priceValue" class="font-weight-bold">$250,750</span>
                        </div>
                    </div>
                    
                    <!-- Estado de la propiedad -->
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Detalles:</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-home text-info mr-2"></i> Propiedad Nueva</li>
                            <li class="mt-2">
                                <span class="badge badge-success p-2 mr-2">
                                    <i class="fas fa-tag mr-1"></i> En Venta
                                </span>
                                <span class="badge badge-light p-2">
                                    <i class="fas fa-tag mr-1"></i> En Renta
                                </span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Incluye -->
                    <div>
                        <h5 class="font-weight-bold">Incluye:</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Estacionamiento</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i> Trastero</li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid px-1 px-md-3 my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11 col-xxl-10">
            <div class="bg-white p-4 p-md-5 rounded shadow-sm border">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <img class="img-fluid w-100 rounded" src="img/Logo.png" alt="Especialista en propiedades vacacionales">
                    </div>
                    <div class="col-lg-7 py-4 py-lg-0 pl-lg-5">
                        <h1 class="mb-3 mb-md-4">Vacation Homes Venezuela</h1>
                        <p class="mb-3 mb-md-4 text-dark">Administramos propiedades vacacionales en las mejores zonas playeras del país. Ofrecemos servicio de rental management para inversores.</p>
                        
                        <ul class="list-unstyled mb-4 mb-md-5">
                            <li class="mb-2 mb-md-3 d-flex align-items-center">
                                <span class="border rounded-circle d-flex align-items-center justify-content-center mr-3 bg-primary text-white" style="width: 22px; height: 22px; min-width: 22px;">✓</span>
                                <h6 class="m-0">Teléfono: 0295-555-1234</h6>
                            </li>
                            <li class="mb-2 mb-md-3 d-flex align-items-center">
                                <span class="border rounded-circle d-flex align-items-center justify-content-center mr-3 bg-primary text-white" style="width: 22px; height: 22px; min-width: 22px;">✓</span>
                                <h6 class="m-0">Email: info@vacationhomesve.com</h6>
                            </li>
                            <li class="mb-2 mb-md-3 d-flex align-items-center">
                                <span class="border rounded-circle d-flex align-items-center justify-content-center mr-3 bg-primary text-white" style="width: 22px; height: 22px; min-width: 22px;">✓</span>
                                <h6 class="m-0">Oficinas: Margarita, Morrocoy y Mochima</h6>
                            </li>
                        </ul>

                        <div class="d-flex flex-wrap">
                            <div class="mr-4 mb-2">
                                <h5 class="text-primary mb-0">120+</h5>
                                <small>Propiedades administradas</small>
                            </div>
                            <div class="mr-4 mb-2">
                                <h5 class="text-primary mb-0">75%</h5>
                                <small>Ocupación promedio anual</small>
                            </div>
                            <div class="mb-2">
                                <h5 class="text-primary mb-0">7</h5>
                                <small>Años en el mercado</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Start -->
@include('componentes.footer')

</body>

</html>