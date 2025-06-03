
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
    <!-- Page Header Start -->
    <div class="page-header container-fluid bg-secondary pt-2 pt-lg-5 pb-2 mb-5">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-md-6 text-center text-md-left">
                    <h1 class="mb-4 mb-md-0 text-white">About Us</h1>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="btn text-white" href="">Home</a>
                        <i class="fas fa-angle-right text-white"></i>
                        <a class="btn text-white disabled" href="">About Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header Start -->
</br>
    <h2>INGRESOS</h2>
    <title>Cuadro de Ingresos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>01/02/2025 - 05/02/2025</th>
                <th>Apartamentos</th>
                <th>Buscar</th>
                <th>+ Agregar Ingresos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Fecha</td>
                <td>Monto</td>
                <td>Inmuebles</td>
                <td>Acciones</td>
            </tr>
            <tr>
                <td>03/02/2025</td>
                <td>$110.000</td>
                <td>Propiedad A</td>
                <td> + - </td>
            </tr>
            <tr>
                <td>04/02/2025</td>
                <td>$105.000</td>
                <td>Propiedad B</td>
                <td> + - </td>
            </tr>
            <tr>
                <td>05/02/2025</td>
                <td>$90.000</td>
                <td>Propiedad C</td>
                <td> + - </td>
            </tr>
            <tr>
                <td>TOTAL DE INGRESOS</td>
                <td>$315.000</td>
            </tr>
            <tr>
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</br>
    <h2>GASTOS</h2>
    <title>Cuadro de Gastos </title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Buscar por nombre</th>
                <th>Buscar</th>
                <th></th>
                <th>+ Agregar gasto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Fecha</td>
                <td>Categoría</td>
                <td>Monto</td>
                <td>Acciones</td>
            </tr>
            <tr>
                <td>03/02/2025</td>
                <td>Adquisición  de propiedades</td>
                <td>$800.000</td>
                <td> + - </td>
            </tr>
            <tr>
                <td>04/02/2025</td>
                <td>Mantenimiento y reparación</td>
                <td>$550.000</td>
                <td> + - </td>
            </tr>
            <tr>
                <td>05/02/2025</td>
                <td>Administrativos</td>
                <td>$250.000</td>
                <td> + - </td>
            </tr>
            <tr>
                <td>05/02/2025</td>
                <td>Impuestos y seguros</td>
                <td>$300.000</td>
                <td>+-</td>
            </tr>
            <tr>
                <td>TOTAL DE GASTOS</td>
                <td></td>
                <td>$1.900.000</td>
                
            </tr>
        </tbody>
    </table>
</body>
</html>
</br>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</br>
    <h2>RENTABILIDAD</h2>
    <title>Cuadro Sobre la Evaluación de Rentabilidad</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Buscar por nombre</th>
                <th>Buscar</th>
                <th>+ Agregar Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>concepto</td>
                <td>Monto</td>
                <td>Acciones</td>
            </tr>
            <tr>
                <td>Ingresos Totales</td>
                <td>$2.040.000</td>
                <td> + - </td>
            </tr>
            <tr>
                <td>Gastos Totales</td>
                <td>$1.900.000</td>
                <td> + - </td>
            </tr>
            <tr>
                <td>Utilidad Bruta</td>
                <td>$140.000</td>
                
            </tr>
                <td>Rentabilidad sobre  Ingresos (ROI)</td>
                <td>6.86%</td>
                
            </tr>
            
        </tbody>
    </table>
</body>
</html>
