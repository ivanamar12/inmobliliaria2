SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `Acceso` (
  `ID_Acceso` int(11) NOT NULL,
  `Nombre_Usuario` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Agente`
--

CREATE TABLE `Agente` (
  `ID_Agente` int(11) NOT NULL,
  `Nombre_Completo` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cliente`
--

CREATE TABLE `Cliente` (
  `ID_Cliente` int(11) NOT NULL,
  `CI` varchar(45) DEFAULT NULL,
  `Nombre_Completo` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `Genero` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Propiedad`
--

CREATE TABLE `Propiedad` (
  `ID_propiedad` int(11) NOT NULL,
  `Nombre` varchar(45) DEFAULT NULL,
  `Tipo` varchar(45) DEFAULT NULL,
  `Precio` varchar(45) DEFAULT NULL,
  `Estado` varchar(45) DEFAULT NULL,
  `Tamanio` varchar(45) DEFAULT NULL,
  `Descripcion` varchar(45) DEFAULT NULL,
  `Propiedad_ID_Propiedad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Propiedad_has_Solicitudes`
--

CREATE TABLE `Propiedad_has_Solicitudes` (
  `Propiedad_ID_propiedad` int(11) NOT NULL,
  `Solicitudes_ID_Solicitudes` int(11) NOT NULL,
  `Solicitudes_ID_cliente` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Propietario`
--

CREATE TABLE `Propietario` (
  `ID_Propiedad` int(11) NOT NULL,
  `Nombre` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `Correo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Solicitudes`
--

CREATE TABLE `Solicitudes` (
  `ID_Solicitudes` int(11) NOT NULL,
  `Fecha_solicitud` varchar(45) DEFAULT NULL,
  `Estado` varchar(45) DEFAULT NULL,
  `ID_cliente` varchar(45) DEFAULT NULL,
  `ID_producto` varchar(45) DEFAULT NULL,
  `Solicitudescol` varchar(45) DEFAULT NULL,
  `Cliente_ID_Cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Venta`
--

CREATE TABLE `Venta` (
  `ID_Venta` int(11) NOT NULL,
  `Fechal` varchar(45) DEFAULT NULL,
  `Monto` varchar(45) DEFAULT NULL,
  `ID_Cliente` varchar(45) DEFAULT NULL,
  `ID_Agente` varchar(45) DEFAULT NULL,
  `Agente_ID_Agente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Acceso`
--
ALTER TABLE `Acceso`
  ADD PRIMARY KEY (`ID_Acceso`);

--
-- Indices de la tabla `Agente`
--
ALTER TABLE `Agente`
  ADD PRIMARY KEY (`ID_Agente`);

--
-- Indices de la tabla `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indices de la tabla `Propiedad`
--
ALTER TABLE `Propiedad`
  ADD PRIMARY KEY (`ID_propiedad`);

--
-- Indices de la tabla `Propiedad_has_Solicitudes`
--
ALTER TABLE `Propiedad_has_Solicitudes`
  ADD PRIMARY KEY (`Propiedad_ID_propiedad`,`Solicitudes_ID_Solicitudes`),
  ADD KEY `Solicitudes_ID_Solicitudes` (`Solicitudes_ID_Solicitudes`);

--
-- Indices de la tabla `Propietario`
--
ALTER TABLE `Propietario`
  ADD PRIMARY KEY (`ID_Propiedad`);

--
-- Indices de la tabla `Solicitudes`
--
ALTER TABLE `Solicitudes`
  ADD PRIMARY KEY (`ID_Solicitudes`),
  ADD KEY `Cliente_ID_Cliente` (`Cliente_ID_Cliente`);

--
-- Indices de la tabla `Venta`
--
ALTER TABLE `Venta`
  ADD PRIMARY KEY (`ID_Venta`),
  ADD KEY `Agente_ID_Agente` (`Agente_ID_Agente`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Propiedad_has_Solicitudes`
--
ALTER TABLE `Propiedad_has_Solicitudes`
  ADD CONSTRAINT `Propiedad_has_Solicitudes_ibfk_1` FOREIGN KEY (`Propiedad_ID_propiedad`) REFERENCES `Propiedad` (`ID_propiedad`),
  ADD CONSTRAINT `Propiedad_has_Solicitudes_ibfk_2` FOREIGN KEY (`Solicitudes_ID_Solicitudes`) REFERENCES `Solicitudes` (`ID_Solicitudes`);

--
-- Filtros para la tabla `Solicitudes`
--
ALTER TABLE `Solicitudes`
  ADD CONSTRAINT `Solicitudes_ibfk_1` FOREIGN KEY (`Cliente_ID_Cliente`) REFERENCES `Cliente` (`ID_Cliente`);

--
-- Filtros para la tabla `Venta`
--
ALTER TABLE `Venta`
  ADD CONSTRAINT `Venta_ibfk_1` FOREIGN KEY (`Agente_ID_Agente`) REFERENCES `Agente` (`ID_Agente`);
COMMIT;
