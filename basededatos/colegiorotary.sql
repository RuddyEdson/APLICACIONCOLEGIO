-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2021 a las 13:45:48
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `colegiorotary`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_administrativo`
--

CREATE TABLE `tb_administrativo` (
  `id_Admin` int(15) NOT NULL,
  `CI_Admin` varchar(20) NOT NULL,
  `RDA` int(25) NOT NULL,
  `nombre_Completo` varchar(100) NOT NULL,
  `fcha_nacimiento` date NOT NULL,
  `LugarNac` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `cargo` varchar(15) NOT NULL,
  `celular` int(10) NOT NULL,
  `telefono` int(10) NOT NULL,
  `email` text NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_administrativo`
--

INSERT INTO `tb_administrativo` (`id_Admin`, `CI_Admin`, `RDA`, `nombre_Completo`, `fcha_nacimiento`, `LugarNac`, `direccion`, `cargo`, `celular`, `telefono`, `email`, `estado`) VALUES
(1, '4921457', 4345045, 'HUGO CALLE MARINEZ', '1090-11-06', 'LA PAZ PROV. OMASUYO CANTON HUATAJATA', 'CORONEL VALDEZ VILLA PABON #1675', 'DIRECTOR', 71960547, 2210157, 'CALLE@GMAIL.COM', 'AC'),
(2, '1004751', 424545, 'CARLOS VARGAS FARIAS', '1086-01-06', 'COCHABAMBA QUILLACOLLO', 'CORONEL VALDEZ VILLA PABON #1675', 'REGENTE', 71960547, 2210157, 'ALCAZAR@GMAIL.COM', 'AC'),
(3, '8921457', 4345045, 'RICARDO CALLE MARINEZ', '1090-11-06', 'LA PAZ PROV. OMASUYO CANTON HUATAJATA', 'CORONEL VALDEZ VILLA PABON #1675', 'DIRECTOR', 71960547, 2210157, 'CALLE@GMAIL.COM', 'AC'),
(4, '8921457', 4345045, 'PEDRO CALLE MARINEZ', '1090-11-06', 'LA PAZ PROV. OMASUYO CANTON HUATAJATA', 'CORONEL VALDEZ VILLA PABON #1675', 'DIRECTOR', 71960547, 2210157, 'CALLE@GMAIL.COM', 'AC'),
(5, '82458457', 4345045, 'PEDRO CALLE MARINEZ', '1090-11-06', 'LA PAZ PROV. OMASUYO CANTON HUATAJATA', 'CORONEL VALDEZ VILLA PABON #1675', 'DIRECTOR', 71960547, 2210157, 'CALLE@GMAIL.COM', 'AC'),
(6, '82458457', 4345045, 'PEDRO CALLE MARINEZ', '1090-11-06', 'LA PAZ PROV. OMASUYO CANTON HUATAJATA', 'CORONEL VALDEZ VILLA PABON #1675', 'DIRECTOR', 71960547, 2210157, 'CALLE@GMAIL.COM', 'AC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_alumno`
--

CREATE TABLE `tb_alumno` (
  `id_usuario` int(15) NOT NULL,
  `id_estudiante` int(15) NOT NULL,
  `id_curso` int(15) NOT NULL,
  `id_calendario` int(30) NOT NULL,
  `id_apoderado` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_apoderado`
--

CREATE TABLE `tb_apoderado` (
  `cod_apoderado` int(15) NOT NULL,
  `Nombre_completo` varchar(100) NOT NULL,
  `C.I.` varchar(20) NOT NULL,
  `fcha_nacimineto` date NOT NULL,
  `lugar / nac` varchar(75) NOT NULL,
  `direccion_act` text NOT NULL,
  `barrio` varchar(70) NOT NULL,
  `parentesco` varchar(20) NOT NULL,
  `celular` int(10) NOT NULL,
  `telefono` int(10) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_apoderado`
--

INSERT INTO `tb_apoderado` (`cod_apoderado`, `Nombre_completo`, `C.I.`, `fcha_nacimineto`, `lugar / nac`, `direccion_act`, `barrio`, `parentesco`, `celular`, `telefono`, `email`) VALUES
(1, 'Mary Huayna Yucra', '4789654', '1985-03-27', 'La Paz - Murillo - nuestra señora de La paz', 'villa adela z. paraiso II c. ismael montes #1675 - El Alto', 'ParaisoII', 'madre', 7774589, 2210458, 'mary@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_aula`
--

CREATE TABLE `tb_aula` (
  `id_aula` int(15) NOT NULL,
  `cod_aula` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `capacidad` int(50) NOT NULL,
  `silla disponibles` int(50) NOT NULL,
  `ubicacion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_aula`
--

INSERT INTO `tb_aula` (`id_aula`, `cod_aula`, `nombre`, `capacidad`, `silla disponibles`, `ubicacion`) VALUES
(1, 'LAB-002', 'Laboratorio informatica', 24, 24, 'Segundo piso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_calendario`
--

CREATE TABLE `tb_calendario` (
  `id_calendario` int(15) NOT NULL,
  `institución` int(50) NOT NULL,
  `C.I._Admin` varchar(50) NOT NULL,
  `nombre_cal` varchar(20) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_calendario`
--

INSERT INTO `tb_calendario` (`id_calendario`, `institución`, `C.I._Admin`, `nombre_cal`, `fecha_inicial`, `fecha_final`, `estado`) VALUES
(2, 1, '4921457', 'Gestion 2021', '2021-01-01', '2021-12-04', 'Ac');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_calificacion`
--

CREATE TABLE `tb_calificacion` (
  `id_nota` int(15) NOT NULL,
  `id_alumno` int(15) NOT NULL,
  `id_docente` int(15) NOT NULL,
  `materia` varchar(50) NOT NULL,
  `nota1` int(10) NOT NULL,
  `nota2` int(10) NOT NULL,
  `nota3` int(10) NOT NULL,
  `promedio` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_colegio`
--

CREATE TABLE `tb_colegio` (
  `id_colegio` int(15) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Resolución` varchar(50) NOT NULL,
  `Red` varchar(15) NOT NULL,
  `Disitrito` varchar(20) NOT NULL,
  `ciudad / comunidad` varchar(25) NOT NULL,
  `departamento` varchar(15) NOT NULL,
  `Nit` int(20) NOT NULL,
  `Direccion` text NOT NULL,
  `telefono` int(10) NOT NULL,
  `celular` int(10) NOT NULL,
  `fax` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_colegio`
--

INSERT INTO `tb_colegio` (`id_colegio`, `Nombre`, `Resolución`, `Red`, `Disitrito`, `ciudad / comunidad`, `departamento`, `Nit`, `Direccion`, `telefono`, `celular`, `fax`) VALUES
(1, 'Rotary Chuquiago Marka', '402', '105', 'distrito 2', 'El alto', 'LA PAZ', 45879623, 'Santa Rosa Calle D #124', 2210458, 7774589, 'casdda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_curso`
--

CREATE TABLE `tb_curso` (
  `id_curso` int(15) NOT NULL,
  `curso` varchar(50) NOT NULL,
  `aula` int(15) NOT NULL,
  `encargado/asesor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_curso`
--

INSERT INTO `tb_curso` (`id_curso`, `curso`, `aula`, `encargado/asesor`) VALUES
(1, 'SIS-001', 1, 'Ruddy Aruquipa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_docente`
--

CREATE TABLE `tb_docente` (
  `id_docente` int(15) NOT NULL,
  `RDA` int(15) NOT NULL,
  `CI_d` varchar(20) NOT NULL,
  `nombre_Completo` varchar(150) NOT NULL,
  `fcha_nacimiento` date NOT NULL,
  `lugarNaci` text NOT NULL,
  `DireccionAct` text NOT NULL,
  `telefono` int(10) NOT NULL,
  `celular` int(10) NOT NULL,
  `email` text NOT NULL,
  `profession` varchar(50) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_docente`
--

INSERT INTO `tb_docente` (`id_docente`, `RDA`, `CI_d`, `nombre_Completo`, `fcha_nacimiento`, `lugarNaci`, `DireccionAct`, `telefono`, `celular`, `email`, `profession`, `estado`) VALUES
(4, 77421054, '4532568', 'Mario carmelo Valdez', '1085-02-12', 'La paz - Omasuyo', 'Villa alemania', 77777777, 4444444, 'asdasd', 'lic. matematicas', 'BA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_estudiante`
--

CREATE TABLE `tb_estudiante` (
  `id_estudiante` int(15) NOT NULL,
  `RUDE` int(20) NOT NULL,
  `CI_est` varchar(20) NOT NULL,
  `Nombres` varchar(30) NOT NULL,
  `Ap_paterno` varchar(50) NOT NULL,
  `Ap_materno` varchar(50) NOT NULL,
  `genero` varchar(9) NOT NULL,
  `fcha_nacimiento` date NOT NULL,
  `LugarNac` text NOT NULL,
  `direccion_act` text NOT NULL,
  `celular` int(10) NOT NULL,
  `email` text NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_estudiante`
--

INSERT INTO `tb_estudiante` (`id_estudiante`, `RUDE`, `CI_est`, `Nombres`, `Ap_paterno`, `Ap_materno`, `genero`, `fcha_nacimiento`, `LugarNac`, `direccion_act`, `celular`, `email`, `estado`) VALUES
(2, 5000147, '10101245', 'Deymar Brayan', 'Perez', 'Mendoza', 'masculino', '2006-01-04', 'gfg', 'fg', 7774589, 'wqwqw', 'AC'),
(11, 14523687, '900147', 'ADEMAR RODRIGO', 'ARUQUIPA', 'YUCRA', 'MASCULINO', '1993-08-10', 'LA PAZ', 'VILLA ADELA ISMAEL MONTES #1675', 70523687, 'ADEM@HOTMAIL.COM', 'AC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_estusuario`
--

CREATE TABLE `tb_estusuario` (
  `id_usuario` int(15) NOT NULL,
  `CI_estudi` varchar(20) NOT NULL,
  `tipo_usuario` varchar(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `contraseña` varchar(256) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_estusuario`
--

INSERT INTO `tb_estusuario` (`id_usuario`, `CI_estudi`, `tipo_usuario`, `username`, `contraseña`, `estado`) VALUES
(1, '10101245', 'estudiante', '12SAAA', '827ccb0eea8a706c4c34a16891f84e7b', 'EX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_materia`
--

CREATE TABLE `tb_materia` (
  `id_materia` int(15) NOT NULL,
  `cod_materia` varchar(30) NOT NULL,
  `nombre_materia` varchar(50) NOT NULL,
  `id_curso` int(15) NOT NULL,
  `id_docente` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_materia`
--

INSERT INTO `tb_materia` (`id_materia`, `cod_materia`, `nombre_materia`, `id_curso`, `id_docente`) VALUES
(1, 'INFO1', 'Infotrmatica Aplicada', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuadmin`
--

CREATE TABLE `tb_usuadmin` (
  `id_usuarioad` int(15) NOT NULL,
  `CI_UsAdmin` varchar(20) NOT NULL,
  `tipo_usuario` varchar(30) NOT NULL,
  `username` varchar(15) NOT NULL,
  `contraseña` varchar(256) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_usuadmin`
--

INSERT INTO `tb_usuadmin` (`id_usuarioad`, `CI_UsAdmin`, `tipo_usuario`, `username`, `contraseña`, `estado`) VALUES
(4, '4921457', 'administrativo', 'REA12', 'bbb8aae57c104cda40c93843ad5e6db8', 'AC'),
(6, '1004751', 'ADMINISTRATIVO', 'CARLO22', '827ccb0eea8a706c4c34a16891f84e7b', 'AC'),
(7, '8921457', 'ADMINISTRATIVO', '71960547.RICARD', '25f9e794323b453885f5181f1b624d0b', 'EX'),
(10, '82458457', 'ADMINISTRATIVO', '71960547.PEDRO ', '305ee301fd84da31bad55b5310e2da54', 'EX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usudoce`
--

CREATE TABLE `tb_usudoce` (
  `id_usuariodoc` int(15) NOT NULL,
  `CI_doce` varchar(25) NOT NULL,
  `tipo_usuario` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `contraseña` varchar(256) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_usudoce`
--

INSERT INTO `tb_usudoce` (`id_usuariodoc`, `CI_doce`, `tipo_usuario`, `username`, `contraseña`, `estado`) VALUES
(1, '4532568', 'DOCENTE', 'qqqwq', 'fe452152faec60d73c3f00c3bb985fe9', 'AC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_administrativo`
--
ALTER TABLE `tb_administrativo`
  ADD PRIMARY KEY (`id_Admin`,`CI_Admin`,`RDA`),
  ADD KEY `C.I_Admin` (`CI_Admin`);

--
-- Indices de la tabla `tb_alumno`
--
ALTER TABLE `tb_alumno`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `id_estudiante` (`id_estudiante`),
  ADD UNIQUE KEY `id_curso` (`id_curso`),
  ADD UNIQUE KEY `id_calendario` (`id_calendario`),
  ADD UNIQUE KEY `id_apoderado` (`id_apoderado`);

--
-- Indices de la tabla `tb_apoderado`
--
ALTER TABLE `tb_apoderado`
  ADD PRIMARY KEY (`cod_apoderado`);

--
-- Indices de la tabla `tb_aula`
--
ALTER TABLE `tb_aula`
  ADD PRIMARY KEY (`id_aula`,`cod_aula`);

--
-- Indices de la tabla `tb_calendario`
--
ALTER TABLE `tb_calendario`
  ADD PRIMARY KEY (`id_calendario`),
  ADD UNIQUE KEY `institución` (`institución`),
  ADD UNIQUE KEY `nombre_gestion` (`C.I._Admin`),
  ADD UNIQUE KEY `C.I._Admin` (`C.I._Admin`);

--
-- Indices de la tabla `tb_calificacion`
--
ALTER TABLE `tb_calificacion`
  ADD PRIMARY KEY (`id_nota`),
  ADD UNIQUE KEY `id_alumno` (`id_alumno`),
  ADD UNIQUE KEY `id_docente` (`id_docente`),
  ADD UNIQUE KEY `id_materia` (`materia`),
  ADD UNIQUE KEY `materia` (`materia`);

--
-- Indices de la tabla `tb_colegio`
--
ALTER TABLE `tb_colegio`
  ADD PRIMARY KEY (`id_colegio`);

--
-- Indices de la tabla `tb_curso`
--
ALTER TABLE `tb_curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `aula` (`aula`);

--
-- Indices de la tabla `tb_docente`
--
ALTER TABLE `tb_docente`
  ADD PRIMARY KEY (`id_docente`,`RDA`,`CI_d`),
  ADD KEY `C.I.` (`CI_d`);

--
-- Indices de la tabla `tb_estudiante`
--
ALTER TABLE `tb_estudiante`
  ADD PRIMARY KEY (`id_estudiante`,`RUDE`,`CI_est`),
  ADD KEY `C.I.` (`CI_est`);

--
-- Indices de la tabla `tb_estusuario`
--
ALTER TABLE `tb_estusuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `C.I_est` (`CI_estudi`),
  ADD UNIQUE KEY `CI_estu` (`CI_estudi`),
  ADD UNIQUE KEY `CI_estudi` (`CI_estudi`);

--
-- Indices de la tabla `tb_materia`
--
ALTER TABLE `tb_materia`
  ADD PRIMARY KEY (`id_materia`,`cod_materia`) USING BTREE,
  ADD UNIQUE KEY `id_curso` (`id_curso`),
  ADD UNIQUE KEY `id_docente` (`id_docente`);

--
-- Indices de la tabla `tb_usuadmin`
--
ALTER TABLE `tb_usuadmin`
  ADD PRIMARY KEY (`id_usuarioad`,`username`),
  ADD UNIQUE KEY `C.I_Admin` (`CI_UsAdmin`);

--
-- Indices de la tabla `tb_usudoce`
--
ALTER TABLE `tb_usudoce`
  ADD PRIMARY KEY (`id_usuariodoc`),
  ADD UNIQUE KEY `CI_doce` (`CI_doce`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_administrativo`
--
ALTER TABLE `tb_administrativo`
  MODIFY `id_Admin` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_alumno`
--
ALTER TABLE `tb_alumno`
  MODIFY `id_usuario` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_apoderado`
--
ALTER TABLE `tb_apoderado`
  MODIFY `cod_apoderado` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_aula`
--
ALTER TABLE `tb_aula`
  MODIFY `id_aula` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_calendario`
--
ALTER TABLE `tb_calendario`
  MODIFY `id_calendario` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_calificacion`
--
ALTER TABLE `tb_calificacion`
  MODIFY `id_nota` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_colegio`
--
ALTER TABLE `tb_colegio`
  MODIFY `id_colegio` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_curso`
--
ALTER TABLE `tb_curso`
  MODIFY `id_curso` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_docente`
--
ALTER TABLE `tb_docente`
  MODIFY `id_docente` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_estudiante`
--
ALTER TABLE `tb_estudiante`
  MODIFY `id_estudiante` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tb_estusuario`
--
ALTER TABLE `tb_estusuario`
  MODIFY `id_usuario` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_materia`
--
ALTER TABLE `tb_materia`
  MODIFY `id_materia` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_usuadmin`
--
ALTER TABLE `tb_usuadmin`
  MODIFY `id_usuarioad` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tb_usudoce`
--
ALTER TABLE `tb_usudoce`
  MODIFY `id_usuariodoc` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_alumno`
--
ALTER TABLE `tb_alumno`
  ADD CONSTRAINT `tb_alumno_ibfk_1` FOREIGN KEY (`id_calendario`) REFERENCES `tb_calendario` (`institución`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_alumno_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `tb_curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_alumno_ibfk_3` FOREIGN KEY (`id_estudiante`) REFERENCES `tb_estudiante` (`id_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_alumno_ibfk_4` FOREIGN KEY (`id_apoderado`) REFERENCES `tb_apoderado` (`cod_apoderado`);

--
-- Filtros para la tabla `tb_calendario`
--
ALTER TABLE `tb_calendario`
  ADD CONSTRAINT `tb_calendario_ibfk_1` FOREIGN KEY (`institución`) REFERENCES `tb_colegio` (`id_colegio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_calendario_ibfk_2` FOREIGN KEY (`C.I._Admin`) REFERENCES `tb_administrativo` (`CI_Admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_calificacion`
--
ALTER TABLE `tb_calificacion`
  ADD CONSTRAINT `tb_calificacion_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `tb_alumno` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_calificacion_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `tb_docente` (`id_docente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_curso`
--
ALTER TABLE `tb_curso`
  ADD CONSTRAINT `tb_curso_ibfk_1` FOREIGN KEY (`aula`) REFERENCES `tb_aula` (`id_aula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_estusuario`
--
ALTER TABLE `tb_estusuario`
  ADD CONSTRAINT `tb_estusuario_ibfk_1` FOREIGN KEY (`CI_estudi`) REFERENCES `tb_estudiante` (`CI_est`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_materia`
--
ALTER TABLE `tb_materia`
  ADD CONSTRAINT `tb_materia_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `tb_curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_materia_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `tb_docente` (`id_docente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_usuadmin`
--
ALTER TABLE `tb_usuadmin`
  ADD CONSTRAINT `tb_usuadmin_ibfk_1` FOREIGN KEY (`CI_UsAdmin`) REFERENCES `tb_administrativo` (`CI_Admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_usudoce`
--
ALTER TABLE `tb_usudoce`
  ADD CONSTRAINT `tb_usudoce_ibfk_1` FOREIGN KEY (`CI_doce`) REFERENCES `tb_docente` (`CI_d`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
