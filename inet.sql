-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-08-2024 a las 04:17:08
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `categoria`, `icon`) VALUES
(1, 'tenis', '<ion-icon name=\"tennisball-sharp\"></ion-icon>'),
(2, 'padel', '<i class=\"fa-solid fa-table-tennis-paddle-ball\"></i>'),
(3, 'basketball', '<i class=\"fa-solid fa-basketball\"></i>'),
(4, 'futbol', '<ion-icon name=\"football-sharp\"></ion-icon>'),
(5, 'jockey', '<i class=\"fa-solid fa-hockey-puck\"></i>'),
(6, 'voley', '<i class=\"fa-solid fa-volleyball\"></i>'),
(7, 'ciclismo', '<i class=\"fa-solid fa-person-biking\"></i>'),
(8, 'golf', '<ion-icon name=\"golf-sharp\"></ion-icon>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historica`
--

CREATE TABLE `historica` (
  `id_historica` int(11) NOT NULL,
  `estado` enum('entregado') NOT NULL,
  `fecha_entrega` date NOT NULL,
  `productos_pedido` longtext NOT NULL,
  `precio_total` float NOT NULL,
  `metodo_pago` varchar(100) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `fk_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historica`
--

INSERT INTO `historica` (`id_historica`, `estado`, `fecha_entrega`, `productos_pedido`, `precio_total`, `metodo_pago`, `fecha_pedido`, `fk_usuario`) VALUES
(2, 'entregado', '2024-08-20', '{\"productos\":[1,2,3], \"cantidad\":[1,1,1], \"precios\":[100,200,300]}', 600, 'mercado pago', '2024-08-20', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `id_imagen` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `fk_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES
(1, 'Head'),
(2, 'Kappa'),
(3, 'Nike'),
(4, 'Adidas'),
(5, 'Puma'),
(6, 'Jaguar'),
(7, 'Wilson'),
(8, 'Topper'),
(9, 'Under Armour'),
(10, 'Cobra'),
(11, 'Reebok'),
(12, 'New Balance'),
(13, 'Umbro'),
(14, 'Fila'),
(15, 'Ascis');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `estado` enum('entregado','en camino','en preparacion') NOT NULL,
  `fecha_entrega` date NOT NULL,
  `productos_pedido` longtext NOT NULL,
  `precio_total` float NOT NULL,
  `metodo_pago` varchar(100) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `fk_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `estado`, `fecha_entrega`, `productos_pedido`, `precio_total`, `metodo_pago`, `fecha_pedido`, `fk_usuario`) VALUES
(1, 'en preparacion', '2024-10-10', '{\"productos\":[1,2,3], \"cantidad\":[1,1,1], \"precios\":[100,200,300]}', 600, 'mercado pago', '2024-08-20', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `precio` float NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `cantidad_vendidos` int(100) NOT NULL,
  `cantidad_disponible` int(100) NOT NULL,
  `fk_categoria` int(100) NOT NULL,
  `fk_marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `precio`, `descripcion`, `cantidad_vendidos`, `cantidad_disponible`, `fk_categoria`, `fk_marca`) VALUES
(1, 'Palo de golf', 80000, 'Palo de golf driver de 1 madera, 45 pulgadas, titanio, eje grafito, grip de cuero, suela estándar, corona plana, cara texturizada, borde redondeado, talón ancho y cuello delgado. Diseño aerodinámico y tecnología de estabilidad para un golpe preciso y lejano.', 0, 200, 8, 10),
(2, 'Pelota futbol', 20000, 'Pelota de fútbol profesional, tamaño 5, material sintético, cubierta de poliuretano, textura rugosa, color blanco y negro, peso 430 gramos, circunferencia 68 cm, presión 8,5 PSI, tecnología de absorción de impacto, diseño aerodinámico para un vuelo estable y preciso.', 0, 100, 4, 3),
(3, 'Pelota de basketball', 25000, 'Pelota de básquetbol oficial, tamaño 7, material de cuero sintético, color naranja y negro, peso 567 gramos, circunferencia 75 cm, textura suave, diseño de paneles hexagonales, tecnología de absorción de impacto, rebote uniforme y duradero, adecuada para juego indoor y outdoor', 0, 50, 3, 10),
(4, 'Pelota de tenis', 5000, 'Pelota de golf premium, tamaño estándar, material surlyn, color blanco, peso 46 gramos, circunferencia 42.7 mm, compresión 90, velocidad inicial alta, estabilidad en vuelo, precisión y control en impacto, diseño aerodinámico para mayor distancia y precisión, adecuada para golfistas de todos los niveles.', 0, 70, 1, 8),
(5, 'Red de voley', 35000, 'Red de voleibol profesional, material de nylon resistente, altura ajustable de 2,43 m a 2,54 m, ancho de 9,50 m, diseño de cuadrícula, tensión uniforme, sistema de sujeción rápido y seguro, cumpliendo con las normas de la FIVB, ideal para partidos oficiales y entrenamientos de alto nivel', 0, 90, 6, 4),
(6, 'Aro de Basketball', 80000, 'Aro de básquetbol profesional, material de acero inoxidable, diámetro de 45,72 cm, altura ajustable de 3,05 m, diseño robusto y resistente, red de nylon durable, sistema de sujeción seguro y rápido, cumpliendo con las normas de la NBA y FIBA, ideal para partidos oficiales y entrenamientos intensos', 0, 900, 3, 7),
(7, 'Arco de futbol', 70000, 'Arco de fútbol profesional, material de aluminio resistente, altura de 2,44 m, ancho de 7,32 m, diseño ligero y resistente, sistema de sujeción rápido y seguro, cumpliendo con las normas de la FIFA, ideal para partidos oficiales y entrenamientos de alto nivel, incluye rede de nylon resistente y duradera.', 0, 98, 4, 3),
(8, 'Palo de jockey', 98000, 'Palo de jockey profesional, material de fibra de carbono, longitud ajustable de 100 a 140 cm, peso de 240 gramos, diseño ergonómico y liviano, sistema de sujeción rápido y seguro, cumple con las normas de seguridad, ideal para jockeys de todos los niveles, incluye pomo de goma y correa de seguridad', 0, 88, 5, 5),
(9, 'Bicicleta', 800000, 'Bicicleta de montaña, ruedas de 27,5 pulgadas, marco de aluminio, suspension delantera, frenos de disco hidráulicos, cambio Shimano de 21 velocidades, llantas con neumáticos tachonados, asiento ergonómico, manubrio ajustable, ideal para terrenos accidentados y rutas de aventura.', 0, 87, 7, 12),
(10, 'Raqueta de padel', 30000, 'Raqueta de pádel profesional, material de carbono y fibra de vidrio, forma de diamante, tamaño 475 cm2, peso 355 gramos, equilibrio centrado, zona de impacto ampliada, tecnología de absorción de vibraciones, grip de EVA, sistema de sujeción rápido y seguro, ideal para jugadores de nivel avanzado y profesional.', 0, 28, 2, 2),
(11, 'Pelota de padel', 20000, 'Pelota de pádel profesional, material de goma espuma, tamaño 65 mm, peso 65 gramos, textura rugosa, rebote optimo, resistente a la abrasión, cumpliendo con las normas de la FIP, ideal para partidos oficiales y entrenamientos intensos, paquete de 3 unidades, color naranja y blanco.', 0, 99, 2, 12),
(12, 'Rueda para bicicleta', 80000, 'Rueda para bicicleta de montaña, medida 27.5 pulgadas, llanta de aluminio anodizado, aro de 32 agujeros, cubierta de goma con tachones agresivos para tracción en terrenos accidentados, sistema de cierre rápido, compatible con frenos de disco hidráulicos, resistente y duradera para rutas extremas.', 0, 22, 7, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `jerarquia` enum('cliente','vendedor') NOT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `contrasenia`, `correo`, `jerarquia`, `direccion`) VALUES
(30, 'nombre', 'apellido', '$2y$10$rdZwRHKaBU3lw3HjsODF3OaCR8SvFfyt4i.uCRoUjGot9ixzmWSzi', 'vendedor@gmail.com', 'vendedor', 'Cerrito 3966');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `historica`
--
ALTER TABLE `historica`
  ADD PRIMARY KEY (`id_historica`),
  ADD KEY `fk_pedido` (`fk_usuario`),
  ADD KEY `fk_usuario` (`fk_usuario`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `fk_producto` (`fk_producto`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_usuario` (`fk_usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_categoria` (`fk_categoria`),
  ADD KEY `fk_marca` (`fk_marca`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `historica`
--
ALTER TABLE `historica`
  MODIFY `id_historica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historica`
--
ALTER TABLE `historica`
  ADD CONSTRAINT `historica_ibfk_1` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`fk_marca`) REFERENCES `marca` (`id_marca`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
