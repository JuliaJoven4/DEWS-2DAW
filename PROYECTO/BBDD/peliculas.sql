-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2022 a las 22:14:57
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `peliculas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `codigo_pelicula` int(11) NOT NULL,
  `nombre` varchar(170) NOT NULL,
  `director` varchar(50) NOT NULL,
  `genero` varchar(15) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `puntuacion` decimal(4,2) DEFAULT NULL,
  `trailer` varchar(200) DEFAULT NULL,
  `enlace` varchar(150) DEFAULT NULL,
  `num_puntuacion` int(11) DEFAULT NULL,
  `puntuacion_total` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`codigo_pelicula`, `nombre`, `director`, `genero`, `imagen`, `puntuacion`, `trailer`, `enlace`, `num_puntuacion`, `puntuacion_total`) VALUES
(1, 'EL GOLPE', 'GEORGE ROY HILL', 'COMEDIA', 'El_golpe.jpg', '0.00', NULL, NULL, 0, '0.00'),
(2, 'LOS PAJAROS', 'ALFRED HITCHOCK', 'TERROR', 'Los_pajaros.jpg', '0.00', NULL, NULL, 0, '0.00'),
(3, 'SOSPECHOSOS HABITUALES', 'BRYAN SINGER', 'SUSPENSE', 'sospechosos_habituales.jpg', '0.00', NULL, NULL, 0, '0.00'),
(4, 'PIRATAS DEL CARIBE. EN EL FIN DEL MUNDO', 'GORE VERBINSKI', 'AVENTURAS', 'piratas3.jpg', '0.00', NULL, NULL, 0, '0.00'),
(5, 'EL SEÑOR LOS DE LOS ANILLOS. LA COMUNIDAD DEL ANIL', 'PETER JACKSON', 'AVENTURAS', 'señor-anillos-1.jpg', '10.00', NULL, NULL, 1, '10.00'),
(6, 'WILLOW', 'RON HOWARD ', 'AVENTURAS', 'willow.jpg', '0.00', NULL, NULL, 0, '0.00'),
(7, 'BRAVEHEART', 'MEL GIBSON', 'AVENTURAS', 'Braveheart.jpg', '0.00', NULL, NULL, 0, '0.00'),
(8, 'ALIEN, EL OCTAVO PASAJERO', 'RIDLEY SCOTT ', 'TERROR', '', '0.00', NULL, NULL, 0, '0.00'),
(9, 'HOTEL RWANDA', 'TERRY GEORGE', 'DRAMA', '', '0.00', NULL, NULL, 0, '0.00'),
(10, 'CRASH (COLISIÓN)', 'PAUL HAGGIS', 'DRAMA', '', '0.00', NULL, NULL, 0, '0.00'),
(11, 'EL TEMIBLE BURLON', 'ROBERT SIODMAK', 'AVENTURAS', '', '0.00', NULL, NULL, 0, '0.00'),
(12, 'EL NUMERO 23', 'JOEL SCHUMACHER', 'SUSPENSE', '', '0.00', NULL, NULL, 0, '0.00'),
(13, 'BEN-HUR', 'WILLIAM WYLER ', 'DRAMA', '', '0.00', NULL, NULL, 0, '0.00'),
(14, 'SHREK 3', 'CHRIS MILLER', 'COMEDIA', '', '9.00', NULL, NULL, 1, '9.00'),
(15, 'LA LISTA DE SHINLDER ', 'STEVEN SPIELBERG', 'DRAMA', '', '0.00', NULL, NULL, 0, '0.00'),
(16, 'LA GRAN EVASION', 'JOHN STURGES', 'BELICA', '', '0.00', NULL, NULL, 0, '0.00'),
(17, 'DOCE DEL PATIBULO', 'ROBERT ALDRICH', 'BELICA', '', '0.00', NULL, NULL, 0, '0.00'),
(18, 'DOCE MONOS', 'TERRY GILLIAM', 'SUSPENSE', '', '0.00', NULL, NULL, 0, '0.00'),
(19, 'AL ESTE DEL EDEN', 'ELIA KAZAN ', 'DRAMA', '', '0.00', NULL, NULL, 0, '0.00'),
(20, 'TIBURON', 'STEVEN SPIELBERG', 'TERROR', '', '0.00', NULL, NULL, 0, '0.00'),
(21, 'MATRIX', ' LARRY Y ANDY WACHOWSKI', 'CIENCIA FICCION', '', '0.00', NULL, NULL, 0, '0.00'),
(22, 'AMERICAN HISTORY X', 'TONY KAYE', 'DRAMA', '', '0.00', NULL, NULL, 0, '0.00'),
(24, 'MONSTER', 'SS', 'AVENTURAS', '', '0.00', NULL, NULL, 0, '0.00'),
(25, '&lt;B&gt;HOLA &lt;/B&gt; ADIOS', 'ASDA', 'AVENTURAS', 'minion.jpg', '6.54', '', '', 13, '85.00'),
(27, 'EL SILENCIO DE LOS CORDEROS', 'JONATHAN DEMME', 'SUSPENSE', 'El_silencio_de_los_corderos.jpg', '10.00', 'https://www.youtube.com/embed/W6Mm8Sbe__o', 'https://www.primevideo.com/detail/The-Silence-Of-The-Lambs/0T63Q0W4RX4AJTSZSII39IRK8V', 1, '10.00'),
(44, 'V DE VENDETTA', 'JAMES MCTEIGUE', 'SUSPENSE', 'v_for_vendetta.png', '9.50', 'https://www.youtube.com/embed/IHVzzxrPt1c', 'https://ver.movistarplus.es/ficha?id=542363&origen=GGL', 6, '57.00'),
(46, 'THE AVENGERS', 'JOSS WHEEDON', 'ACCION', 'the_avengers_1.jpg', '10.00', 'https://www.youtube.com/embed/eOrNdBpGMv8', 'https://www.disneyplus.com/es-es/movies/the-avengers-los-vengadores-de-marvel-studios/2h6PcHFDbsPy', 1, '10.00'),
(47, 'EL VIAJE DE CHIHIRO', 'HAYAO MIYAZAKI', 'FANTASIA', 'Chihiro.jpg', '0.00', 'https://www.youtube.com/embed/5Fgq4Osh6XQ', 'https://www.netflix.com/es/title/60023642?source=35', 0, '0.00'),
(48, 'MONSTRUOS S.A.', 'PETE DOCTER', 'COMEDIA', 'Monstruos_SA.jpg', '0.00', 'https://www.youtube.com/embed/4GZA3jBrK00', 'https://www.disneyplus.com/es-es/movies/monstruos-sa/5vQuMGjgTZz5', 0, '0.00'),
(49, 'INSIDE OUT', 'PETE DOCTER', 'COMEDIA', 'Inside_out.jpg', '0.00', 'https://www.youtube.com/embed/ZOWV9F7LnIQ', 'https://www.disneyplus.com/es-es/movies/del-reves/uzQ2ycVDi2IE', 0, '0.00'),
(50, 'BIG HERO 6', 'CHRIS WILLIAMS', 'AVENTURAS', 'Big_Hero_6.jpg', '0.00', 'https://www.youtube.com/embed/7xidOWnzSu4', 'https://www.disneyplus.com/es-es/movies/big-hero-6/4AozFbXy3sPw', 0, '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre` varchar(25) NOT NULL,
  `clave` varchar(25) NOT NULL,
  `rol` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `clave`, `rol`) VALUES
('admin', 'admin', 'administrador'),
('Alberto22', 'albertotetuan22', 'estandar'),
('Julia22', 'juliatetuan22', 'estandar'),
('prueba1', 'prueba1', 'estandar'),
('prueba2', 'prueba2', 'estandar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`codigo_pelicula`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `codigo_pelicula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
