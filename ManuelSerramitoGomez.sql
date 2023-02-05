-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: dbXdebug
-- Tiempo de generación: 04-02-2023 a las 14:17:14
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Tarefa4.7`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `usuario` varchar(50) NOT NULL,
  `idProducto` int NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `valoracion` int DEFAULT NULL,
  `dataCreacion` datetime NOT NULL,
  `dataModeracion` datetime DEFAULT NULL,
  `moderado` enum('si','non') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `familia` varchar(50) NOT NULL,
  `imaxe` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nome`, `descripcion`, `familia`, `imaxe`) VALUES
(1, 'Pantalon Cargo Jogger', 'Pantal&oacute;n cargo estilo jogger con goma el&aacute;stica en cintura y bajos, cierre de cord&oacute;n y bolsillos con tapeta en los laterales.', 'Pantalones', 'pantalon-cargo.jpg'),
(3, 'Sudadera Capucha Grafico Bordado', 'Sudadera con capucha y gráfico delantero bordado, bolsillo canguro y de manga larga.', 'Sudaderas', 'sudadera-grafico-bordado.jpg'),
(5, 'Jeans Super Skinny Azul Oscuro', 'Jeans super skinny fit en color azul oscuro, diseño de cinco bolsillos, cintura con trabillas, cierre de botón y cremallera y en tejido ligeramente elástico.', 'Pantalones', 'jeans-skinny-azul-oscuro.jpg'),
(6, 'Chaqueta Bolsillo Canguro', 'Chaqueta con bolsillo tipo canguro, detalle de etiqueta tejida en frontal, con capucha, forro interior acolchado y cierre de cremallera en el pecho. Disponible en varios colores.', 'Chaquetas', 'chaqueta-bolsillo-canguro.jpg'),
(7, 'Sudadera One Piece Capucha', 'Sudadera licencia One Piece con capucha con cordones ajustables y print en pecho, espalda y mangas.', 'Sudaderas', 'sudadera-one-piece.jpg'),
(8, 'Pantalon Jogger Cargo Basico Colores', 'Pantalón jogger básico de corte cargo disponible en varios tonos, con bolsillos de tapeta en la pernera, cintura elástica con cordón y confeccionado en algodón.', 'Pantalones', 'pantalon-jogger-cargo.jpg'),
(9, 'Sudadera Dragon Ball Azul Marino', 'Sudadera licencia Dragon Ball en azul marino con gráfico en contraste, capucha con cordón y de manga larga.', 'Sudaderas', 'sudadera-dragon-ball.jpg'),
(10, 'Cazadora Bomber Basica', 'Cazadora bomber básica con bolsillos, detalle de rib en cuello y bajo, forro interior acolchado, cierre de cremallera y de manga larga.', 'Chaquetas', 'cazadora-bomber.jpg'),
(11, 'Zapatillas Casual Basic', 'Zapatillas casual disponibles en varios colores. Cierre mediante cordones. Suela en contraste de color. Altura de la suela 3 cm.', 'Calzado', 'zapatillas-casual-basic.jpg'),
(12, 'Jeans Carrot Fit Negros', 'Jeans carrot fit básicos en color negro, con diseño de cinco bolsillos, cintura con trabillas y cierre de cremallera y botón.', 'Pantalones', 'jeans-carrot-negros.jpg'),
(13, 'Camiseta Nirvana', 'Camiseta licencia Nirvana de manga corta y cuello redondo con detalle de print en contraste.', 'Camisetas', 'camiseta-nirvana.jpg'),
(14, 'Camiseta One Piece Luffy', 'Camiseta licencia One Piece con ilustración de Luffy, de manga corta, con cuello redondo y en algodón.', 'Camisetas', 'camiseta-one-piece.jpg'),
(15, 'Sudadera Basica Capucha', 'Sudadera básica con capucha con cordones ajustables, bolsillo tipo canguro y detalle de rib en bajo y puños.', 'Sudaderas', 'sudadera-basica.jpg'),
(16, 'Jeans Wide Leg Algodon', 'Jeans wide leg disponibles en varios colores, con diseño de cinco bolsillos, cintura con trabillas, cierre de cremallera y botón y en tejido 100% algodón.', 'Pantalones', 'jeans-wide.jpg'),
(17, 'Sudadera Rocky Balboa Gris', 'Sudadera licencia Rocky Balboa de color gris con bolsillo canguro, capucha con cordón y de manga larga.', 'Sudaderas', 'sudadera-rocky.jpg'),
(18, 'Sudadera Capucha Street Art', 'Sudadera con capucha con cordones ajustables, de manga larga, y con detalle de print Street Art.', 'Sudaderas', 'sudadera-street-art.jpg'),
(19, 'Sobrecamisa Manga Larga', 'Sobrecamisa de manga larga y cuello clásico con detalle de bolsillos con tapeta y cierre de botones.', 'Camisas', 'sobrecamisa.jpg'),
(20, 'Chaqueta Pana Cuello Borreguillo', 'Chaqueta de pana trucker con cuello de borreguillo, bolsillos delanteros, cierre de botones y de manga larga.', 'Chaquetas', 'chaqueta-pana.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nome` varchar(50) NOT NULL,
  `contrasinal` varchar(260) NOT NULL,
  `nomeCompleto` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `data` datetime NOT NULL,
  `rol` enum('usuario','moderador','administrador') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nome`, `contrasinal`, `nomeCompleto`, `email`, `data`, `rol`) VALUES
('administrador', '$2y$10$iYKIMoli4Xjxv299yQaF0OMtvp5bliU7AjRnXG/Z4ch3gLufgzUhS', 'administrador', 'administrador@gmail.com', '2023-02-04 14:13:05', 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`usuario`,`idProducto`,`dataCreacion`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nome`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
