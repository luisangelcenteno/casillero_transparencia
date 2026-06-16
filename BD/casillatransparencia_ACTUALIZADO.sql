-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2026 a las 07:32:11
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `casillatransparencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_preparaciones`
--

CREATE TABLE `archivo_preparaciones` (
  `c_archivo_preparacion` bigint(20) NOT NULL,
  `c_solicitud` bigint(20) NOT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `c_corte` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_archivo` varchar(100) NOT NULL,
  `x_ubicacion` varchar(120) NOT NULL,
  `x_observacion` text DEFAULT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `archivo_preparaciones`
--

INSERT INTO `archivo_preparaciones` (`c_archivo_preparacion`, `c_solicitud`, `c_usuario`, `c_corte`, `f_registro`, `x_archivo`, `x_ubicacion`, `x_observacion`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `n_aud_ip`) VALUES
(1, 3, 9, '20', '2026-06-05 12:28:14.386866', 'Tomo 12 - C.F. 104-2023-convertido_v3.pdf', 'uploads/archivo/ARCHIVO_SOL_3_1780680494.pdf', 'El archivo falta ser firmado por el juez oh notario,etc', 'S', 9, '2026-06-05 12:28:14.386866', 'I', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_administrativas`
--

CREATE TABLE `areas_administrativas` (
  `c_area_administrativa` char(3) NOT NULL,
  `c_unidad_administrativa` char(2) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_area_administrativa` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditorias_sistema`
--

CREATE TABLE `auditorias_sistema` (
  `c_auditoria` bigint(20) NOT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `c_solicitud` bigint(20) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_evento` varchar(100) NOT NULL,
  `x_modulo` varchar(80) NOT NULL,
  `x_accion` varchar(120) NOT NULL,
  `x_detalle` text DEFAULT NULL,
  `n_ip` varchar(45) DEFAULT NULL,
  `x_user_agent` varchar(255) DEFAULT NULL,
  `l_estado` char(1) DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `auditorias_sistema`
--

INSERT INTO `auditorias_sistema` (`c_auditoria`, `c_usuario`, `c_solicitud`, `f_registro`, `x_evento`, `x_modulo`, `x_accion`, `x_detalle`, `n_ip`, `x_user_agent`, `l_estado`) VALUES
(1, 2, 1, '2026-04-20 22:22:36.658624', 'PRESENTACION DE SOLICITUD', 'CASILLERO DIGITAL', 'REGISTRO DE SOLICITUD', 'REGISTRO INICIAL POR EL CIUDADANO', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(2, 1, 2, '2026-06-04 09:08:58.847526', 'PRESENTACION DE SOLICITUD', 'CASILLERO DIGITAL', 'REGISTRO DE SOLICITUD', 'REGISTRO INICIAL POR EL CIUDADANO', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(3, 13, 2, '2026-06-04 10:12:32.445711', 'ASIGNACION Y VALIDACION', 'TRANSPARENCIA', 'DERIVACION DE DOCUMENTOS', 'DERIVADO A: SECRETARIA GENERAL - INFORMACION ADMINISTRATIVA Y RESOLUCIONES | SE DERIVA PARA EVALUAR COMPETENCIA, UBICAR LA INFORMACION SOLICITADA Y REMITIR RESPUESTA DOCUMENTADA.', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(4, 7, 2, '2026-06-04 12:45:49.353679', 'GENERACION DE CARGO', 'ASISTENCIA ADMINISTRATIVA', 'RESPUESTA FIRMADA GENERADA', 'FIRMA DIGITAL APLICADA EN TODAS LAS HOJAS DEL DOCUMENTO DEL CIUDADANO Y REGISTRADA EN PLATAFORMA. | FIRMADO POR: JORGUE QUIROZ BERROCAL - JUEZ SUPERIOR', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(5, 16, 3, '2026-06-05 11:21:24.232904', 'PRESENTACION DE SOLICITUD', 'CASILLERO DIGITAL', 'REGISTRO DE SOLICITUD', 'REGISTRO INICIAL POR EL CIUDADANO', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(6, 5, 3, '2026-06-05 11:25:06.801422', 'ASIGNACION Y VALIDACION', 'MESA DE PARTES', 'DERIVACION DE DOCUMENTOS', 'DERIVADO A: MESA DE PARTES - LO REVISA MESA DE PARTES | SE DERIVA PARA EVALUAR COMPETENCIA, UBICAR LA INFORMACION SOLICITADA Y REMITIR RESPUESTA DOCUMENTADA.', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(7, 10, 3, '2026-06-05 11:41:36.320977', 'VALIDACION Y CARGO', 'MESA DE PARTES', 'VALIDACION DE INGRESO', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(8, 10, 3, '2026-06-05 11:41:41.847255', 'VALIDACION Y CARGO', 'MESA DE PARTES', 'VALIDACION DE INGRESO', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(9, 10, 3, '2026-06-05 11:41:43.344468', 'VALIDACION Y CARGO', 'MESA DE PARTES', 'VALIDACION DE INGRESO', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(10, 10, 3, '2026-06-05 11:41:44.429575', 'VALIDACION Y CARGO', 'MESA DE PARTES', 'VALIDACION DE INGRESO', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(11, 10, 3, '2026-06-05 11:42:09.283708', 'VALIDACION Y CARGO', 'MESA DE PARTES', 'VALIDACION DE INGRESO', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(12, 10, 3, '2026-06-05 11:48:37.442168', 'ASIGNACION Y VALIDACION', 'MESA DE PARTES', 'REMISION DE SOLICITUD', 'REMITIDO POR MESA DE PARTES A: ARCHIVO CENTRAL', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(13, 5, 3, '2026-06-05 12:14:13.465746', 'ASIGNACION Y VALIDACION', 'ARCHIVO CENTRAL', 'DERIVACION DE DOCUMENTOS', 'DERIVADO A: ARCHIVO CENTRAL - LO REVISA TECNICO DE ARCHIVO | SE DERIVA PARA EVALUAR COMPETENCIA, UBICAR LA INFORMACION SOLICITADA Y REMITIR RESPUESTA DOCUMENTADA.', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(14, 9, 3, '2026-06-05 12:28:14.390246', 'ATENCION DE SOLICITUD', 'ARCHIVO CENTRAL', 'ATENCION DOCUMENTAL', 'ARCHIVO CENTRAL | DOCUMENTO PREPARADO COMO ANEXO DE RESPUESTA | EL ARCHIVO FALTA SER FIRMADO POR EL JUEZ OH NOTARIO,ETC', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(15, 9, 3, '2026-06-05 12:32:48.543587', 'ATENCION DE SOLICITUD', 'ARCHIVO CENTRAL', 'ATENCION DOCUMENTAL', 'ARCHIVO CENTRAL | DOCUMENTACION REMITIDA A: ASISTENCIA ADMINISTRATIVA', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(16, 7, 3, '2026-06-05 12:47:44.664204', 'MOVIMIENTO DE SOLICITUD', 'CASILLERO DIGITAL', 'MOVIMIENTO REGISTRADO', 'DOCUMENTOS FIRMADOS | FIRMADO POR: JORGUE QUIROZ BERROCAL - JUEZ SUPERIOR', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(17, 16, 3, '2026-06-05 14:21:58.152021', 'PAGO DE REPRODUCCION', 'CULQI ONLINE DEMO', 'PAGO REGISTRADO', 'PAGO DE REPRODUCCION CONFIRMADO | COPIA SIMPLE | S/ 5.00 | CULQI-DEMO-20260605212158-804', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(18, 13, 3, '2026-06-05 15:04:14.606434', 'COPIA ENTREGADA', 'PAGOS CULQI', 'GESTION DE COPIA', 'COPIA SIMPLE PREPARADA CON MARCA DE AGUA PARA ENTREGA AL CIUDADANO', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(19, 13, 3, '2026-06-05 15:06:24.457109', 'COPIA ENTREGADA', 'PAGOS CULQI', 'GESTION DE COPIA', 'COPIA SIMPLE ENTREGADA AL CIUDADANO', '::1', 'CARGA INICIAL DESDE TRAZABILIDAD', 'S'),
(32, 7, 2, '2026-06-04 12:45:49.352569', 'NOTIFICACION ENVIADA', 'CASILLERO DIGITAL', 'RESPUESTA DISPONIBLE PARA EL CIUDADANO', 'Respuesta firmada: firmado_1.pdf', '::1', 'CARGA INICIAL DESDE RESPUESTAS', 'S'),
(33, 7, 3, '2026-06-05 12:46:10.486200', 'NOTIFICACION ENVIADA', 'CASILLERO DIGITAL', 'RESPUESTA DISPONIBLE PARA EL CIUDADANO', 'Respuesta firmada: firmado_2.pdf', '::1', 'CARGA INICIAL DESDE RESPUESTAS', 'S'),
(35, 1, 2, '2026-06-04 13:04:29.965396', 'INCIDENCIA Y ATENCION SLA', 'SOPORTE SLA', 'REGISTRO DE INCIDENCIA', 'ARCHIVO FISICO NO ENCONTRADO | El anexo GRUPO CORIL SOCIEDAD AGENTE DE BOLSA SA_2 DIC 2020_0001.pdf figura en la base de datos, pero falta guardar/copiar el PDF fisico en storage/uploads/anexos.', '127.0.0.1', 'CARGA INICIAL DESDE SOPORTE', 'S'),
(36, 1, 2, '2026-06-04 13:07:14.039090', 'INCIDENCIA Y ATENCION SLA', 'SOPORTE SLA', 'REGISTRO DE INCIDENCIA', 'ARCHIVO NO SUBIDO | AYUDAME A CAMBIARLO PORFAVOR\n[2026-06-04 23:29 - ADMINISTRADOR SISTEMA] ok', '::1', 'CARGA INICIAL DESDE SOPORTE', 'S'),
(37, 13, 1, '2026-06-04 15:52:23.129388', 'INCIDENCIA Y ATENCION SLA', 'SOPORTE SLA', 'REGISTRO DE INCIDENCIA', 'ARCHIVO FISICO NO ENCONTRADO | El anexo figura en la base de datos, pero no existe en la carpeta storage/uploads/anexos.', '::1', 'CARGA INICIAL DESDE SOPORTE', 'S'),
(38, 16, 3, '2026-06-05 14:21:58.149357', 'PAGO DE REPRODUCCION', 'CULQI ONLINE DEMO', 'PAGO REGISTRADO', 'COPIA SIMPLE | PEN 5.00 | CULQI-DEMO-20260605212158-804', '::1', 'CARGA INICIAL DESDE PAGOS', 'S'),
(39, 13, NULL, '2026-06-05 16:50:55.672006', 'CONSULTA DE AUDITORIA', 'REGISTRO AUDITORIA', 'VISUALIZACION DEL LOG DE AUDITORIA', 'Administrador consulta los eventos criticos del sistema.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'S'),
(40, 13, NULL, '2026-06-05 16:51:30.076241', 'CONSULTA DE AUDITORIA', 'REGISTRO AUDITORIA', 'VISUALIZACION DEL LOG DE AUDITORIA', 'Administrador consulta los eventos criticos del sistema.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cortes_nacionales`
--

CREATE TABLE `cortes_nacionales` (
  `c_corte` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_corte` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cortes_nacionales`
--

INSERT INTO `cortes_nacionales` (`c_corte`, `f_registro`, `x_corte`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('01', '2026-04-18 21:54:02.195985', 'Corte Suprema', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('02', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Amazonas', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('03', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Ancash', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('04', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Apurimac', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('05', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Arequipa', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('06', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Ayacucho', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('07', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Cajamarca', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('08', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia del Callao', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('09', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Cañete', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('10', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Cusco', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('11', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Huancavelica', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('12', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Huanuco', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('13', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Huaura', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('14', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Ica', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('15', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Junin', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('16', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de La Libertad', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('17', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lambayeque', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('18', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lima', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('19', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lima Este', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('20', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lima Norte', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('21', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lima Sur', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('22', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Loreto', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('23', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Madre de Dios', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('24', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Moquegua', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('25', '2026-04-18 21:54:02.195985', 'Corte Nacional de Justicia Penal Especializada', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('26', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Pasco', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('27', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Piura', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('28', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Puente Piedra - Ventanilla', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('29', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Puno', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('30', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de San Martín', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('31', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia del Santa', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('32', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de la Selva Central', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('33', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Sullana', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('34', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Tacna', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('35', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Tumbes', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('36', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Ucayali', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL),
('37', '2026-04-18 21:54:02.195985', 'Gerencia General', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `c_departamento` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_departamento` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`c_departamento`, `f_registro`, `x_departamento`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('01', '2026-04-18 22:01:14.846737', 'AMAZONAS', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('02', '2026-04-18 22:01:14.846737', 'ANCASH', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('03', '2026-04-18 22:01:14.846737', 'APURIMAC', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('04', '2026-04-18 22:01:14.846737', 'AREQUIPA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('05', '2026-04-18 22:01:14.846737', 'AYACUCHO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('06', '2026-04-18 22:01:14.846737', 'CAJAMARCA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('07', '2026-04-18 22:01:14.846737', 'CALLAO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('08', '2026-04-18 22:01:14.846737', 'CUSCO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('09', '2026-04-18 22:01:14.846737', 'HUANCAVELICA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('10', '2026-04-18 22:01:14.846737', 'HUANUCO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('11', '2026-04-18 22:01:14.846737', 'ICA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('12', '2026-04-18 22:01:14.846737', 'JUNIN', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('13', '2026-04-18 22:01:14.846737', 'LA LIBERTAD', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('14', '2026-04-18 22:01:14.846737', 'LAMBAYEQUE', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('15', '2026-04-18 22:01:14.846737', 'LIMA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('16', '2026-04-18 22:01:14.846737', 'LORETO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('17', '2026-04-18 22:01:14.846737', 'MADRE DE DIOS', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('18', '2026-04-18 22:01:14.846737', 'MOQUEGUA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('19', '2026-04-18 22:01:14.846737', 'PASCO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('20', '2026-04-18 22:01:14.846737', 'PIURA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('21', '2026-04-18 22:01:14.846737', 'PUNO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('22', '2026-04-18 22:01:14.846737', 'SAN MARTIN', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('23', '2026-04-18 22:01:14.846737', 'TACNA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('24', '2026-04-18 22:01:14.846737', 'TUMBES', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL),
('25', '2026-04-18 22:01:14.846737', 'UCAYALI', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distritos`
--

CREATE TABLE `distritos` (
  `c_distrito` char(6) NOT NULL,
  `c_provincia` char(4) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_distrito` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `distritos`
--

INSERT INTO `distritos` (`c_distrito`, `c_provincia`, `f_registro`, `x_distrito`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('150101', '1501', '2026-04-20 22:16:59.051177', 'LIMA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150102', '1501', '2026-04-20 22:16:59.051177', 'ANCON', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150103', '1501', '2026-04-20 22:16:59.051177', 'ATE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150104', '1501', '2026-04-20 22:16:59.051177', 'BARRANCO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150105', '1501', '2026-04-20 22:16:59.051177', 'BREÑA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150106', '1501', '2026-04-20 22:16:59.051177', 'CARABAYLLO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150107', '1501', '2026-04-20 22:16:59.051177', 'CHACLACAYO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150108', '1501', '2026-04-20 22:16:59.051177', 'CHORRILLOS', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150109', '1501', '2026-04-20 22:16:59.051177', 'CIENEGUILLA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150110', '1501', '2026-04-20 22:16:59.051177', 'COMAS', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150111', '1501', '2026-04-20 22:16:59.051177', 'EL AGUSTINO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150112', '1501', '2026-04-20 22:16:59.051177', 'INDEPENDENCIA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150113', '1501', '2026-04-20 22:16:59.051177', 'JESUS MARIA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150114', '1501', '2026-04-20 22:16:59.051177', 'LA MOLINA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150115', '1501', '2026-04-20 22:16:59.051177', 'LA VICTORIA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150116', '1501', '2026-04-20 22:16:59.051177', 'LINCE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150117', '1501', '2026-04-20 22:16:59.051177', 'LURIGANCHO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150118', '1501', '2026-04-20 22:16:59.051177', 'LURIN', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150119', '1501', '2026-04-20 22:16:59.051177', 'MAGDALENA DEL MAR', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150120', '1501', '2026-04-20 22:16:59.051177', 'PUEBLO LIBRE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150121', '1501', '2026-04-20 22:16:59.051177', 'MIRAFLORES', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150122', '1501', '2026-04-20 22:16:59.051177', 'PACHACAMAC', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150123', '1501', '2026-04-20 22:16:59.051177', 'PUCUSANA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150124', '1501', '2026-04-20 22:16:59.051177', 'PUENTE PIEDRA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150125', '1501', '2026-04-20 22:16:59.051177', 'PUNTA HERMOSA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150126', '1501', '2026-04-20 22:16:59.051177', 'PUNTA NEGRA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150127', '1501', '2026-04-20 22:16:59.051177', 'SAN BARTOLO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150128', '1501', '2026-04-20 22:16:59.051177', 'SAN BORJA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150129', '1501', '2026-04-20 22:16:59.051177', 'SAN ISIDRO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150130', '1501', '2026-04-20 22:16:59.051177', 'SAN JUAN DE LURIGANCHO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150131', '1501', '2026-04-20 22:16:59.051177', 'SAN JUAN DE MIRAFLORES', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150132', '1501', '2026-04-20 22:16:59.051177', 'SAN LUIS', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150133', '1501', '2026-04-20 22:16:59.051177', 'SAN MARTIN DE PORRES', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150134', '1501', '2026-04-20 22:16:59.051177', 'SAN MIGUEL', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150135', '1501', '2026-04-20 22:16:59.051177', 'SANTA ANITA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150136', '1501', '2026-04-20 22:16:59.051177', 'SANTA MARIA DEL MAR', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150137', '1501', '2026-04-20 22:16:59.051177', 'SANTA ROSA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150138', '1501', '2026-04-20 22:16:59.051177', 'SANTIAGO DE SURCO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150139', '1501', '2026-04-20 22:16:59.051177', 'SURQUILLO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150140', '1501', '2026-04-20 22:16:59.051177', 'VILLA EL SALVADOR', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150141', '1501', '2026-04-20 22:16:59.051177', 'VILLA MARIA DEL TRIUNFO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150501', '1505', '2026-04-20 22:16:59.051177', 'SAN VICENTE DE CAÑETE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150502', '1505', '2026-04-20 22:16:59.051177', 'ASIA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150503', '1505', '2026-04-20 22:16:59.051177', 'CALANGO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150508', '1505', '2026-04-20 22:16:59.051177', 'MALA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150801', '1508', '2026-04-20 22:16:59.051177', 'HUACHO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150802', '1508', '2026-04-20 22:16:59.051177', 'AMBAR', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150804', '1508', '2026-04-20 22:16:59.051177', 'CALETA DE CARQUIN', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('150810', '1508', '2026-04-20 22:16:59.051177', 'SAYAN', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `firmas_jefes`
--

CREATE TABLE `firmas_jefes` (
  `c_firma_jefe` bigint(20) NOT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `c_corte` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_juez` varchar(120) NOT NULL,
  `x_cargo` varchar(80) NOT NULL,
  `x_archivo` varchar(100) NOT NULL,
  `x_ubicacion` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `firmas_jefes`
--

INSERT INTO `firmas_jefes` (`c_firma_jefe`, `c_usuario`, `c_corte`, `f_registro`, `x_juez`, `x_cargo`, `x_archivo`, `x_ubicacion`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `n_aud_ip`) VALUES
(1, 6, '21', '2026-06-04 12:14:17.975138', 'JUAN PEREZ GONZALES', 'JUEZ SUPERIOR', 'esignature_cocosign.png', 'uploads/firmas/FIRMA_JEFE_6_1780593618.png', 'S', 6, '2026-06-04 12:20:18.899530', 'U', '::1'),
(2, 14, '20', '2026-06-04 12:31:57.497219', 'JUEZ LIMA NORTE DEMO', 'JUEZ SUPERIOR', 'firma_lima_norte_demo.svg', 'uploads/firmas/firma_lima_norte_demo.svg', 'S', 14, '2026-06-04 12:31:57.497219', 'I', '127.0.0.1'),
(3, 15, '20', '2026-06-04 12:45:11.331449', 'JORGUE QUIROZ BERROCAL', 'JUEZ SUPERIOR', 'esignature_2_CONO NORTE.png', 'uploads/firmas/FIRMA_JEFE_15_1780595111.png', 'S', 15, '2026-06-04 12:45:11.331449', 'I', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_reproduccion`
--

CREATE TABLE `pagos_reproduccion` (
  `c_pago_reproduccion` bigint(20) NOT NULL,
  `c_solicitud` bigint(20) NOT NULL,
  `c_solicitud_respuesta` bigint(20) NOT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_tipo_copia` varchar(60) NOT NULL,
  `n_monto` decimal(10,2) NOT NULL,
  `x_moneda` char(3) DEFAULT 'PEN',
  `x_pasarela` varchar(60) DEFAULT 'CULQI ONLINE DEMO',
  `x_codigo_pago` varchar(80) NOT NULL,
  `x_estado` varchar(30) DEFAULT 'PAGADO',
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `x_estado_entrega` varchar(40) DEFAULT 'PENDIENTE DE PREPARACION',
  `x_copia_archivo` varchar(120) DEFAULT NULL,
  `x_copia_ubicacion` varchar(160) DEFAULT NULL,
  `f_preparacion` datetime(6) DEFAULT NULL,
  `f_entrega` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagos_reproduccion`
--

INSERT INTO `pagos_reproduccion` (`c_pago_reproduccion`, `c_solicitud`, `c_solicitud_respuesta`, `c_usuario`, `f_registro`, `x_tipo_copia`, `n_monto`, `x_moneda`, `x_pasarela`, `x_codigo_pago`, `x_estado`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `n_aud_ip`, `x_estado_entrega`, `x_copia_archivo`, `x_copia_ubicacion`, `f_preparacion`, `f_entrega`) VALUES
(1, 3, 2, 16, '2026-06-05 14:21:58.149357', 'COPIA SIMPLE', 5.00, 'PEN', 'CULQI ONLINE DEMO', 'CULQI-DEMO-20260605212158-804', 'PAGADO', 'S', 13, '2026-06-05 15:06:24.455681', 'U', '::1', 'ENTREGADO', 'COPIA_PAGO_1_SOL_3.pdf', 'uploads/copias/COPIA_PAGO_1_SOL_3.pdf', '2026-06-05 15:04:14.603535', '2026-06-05 15:06:24.455681');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `c_provincia` char(4) NOT NULL,
  `c_departamento` char(2) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_provincia` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`c_provincia`, `c_departamento`, `f_registro`, `x_provincia`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('1501', '15', '2026-04-20 22:16:59.051177', 'LIMA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1502', '15', '2026-04-20 22:16:59.051177', 'BARRANCA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1503', '15', '2026-04-20 22:16:59.051177', 'CAJATAMBO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1504', '15', '2026-04-20 22:16:59.051177', 'CANTA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1505', '15', '2026-04-20 22:16:59.051177', 'CAÑETE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1506', '15', '2026-04-20 22:16:59.051177', 'HUARAL', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1507', '15', '2026-04-20 22:16:59.051177', 'HUAROCHIRI', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1508', '15', '2026-04-20 22:16:59.051177', 'HUAURA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1509', '15', '2026-04-20 22:16:59.051177', 'OYON', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL),
('1510', '15', '2026-04-20 22:16:59.051177', 'YAUYOS', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperaciones_contrasenas`
--

CREATE TABLE `recuperaciones_contrasenas` (
  `c_recupera_contrasena` bigint(20) NOT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_hash` text NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `c_solicitud` bigint(20) NOT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `c_tipo_via` char(2) DEFAULT NULL,
  `c_tipo_zona` char(2) DEFAULT NULL,
  `c_departamento` char(2) DEFAULT NULL,
  `c_provincia` char(4) DEFAULT NULL,
  `c_distrito` char(6) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_via_otro` varchar(50) DEFAULT NULL,
  `x_nombre_via` varchar(100) DEFAULT NULL,
  `x_zona_otro` varchar(50) DEFAULT NULL,
  `x_referencia` varchar(100) DEFAULT NULL,
  `x_telefono` varchar(7) DEFAULT NULL,
  `x_celular` varchar(9) DEFAULT NULL,
  `x_sustentacion` text NOT NULL,
  `n_tiempo_atencion` int(11) DEFAULT 10,
  `n_tiempo_prorroga` int(11) DEFAULT 0,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`c_solicitud`, `c_usuario`, `c_tipo_via`, `c_tipo_zona`, `c_departamento`, `c_provincia`, `c_distrito`, `f_registro`, `x_via_otro`, `x_nombre_via`, `x_zona_otro`, `x_referencia`, `x_telefono`, `x_celular`, `x_sustentacion`, `n_tiempo_atencion`, `n_tiempo_prorroga`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
(1, 2, '01', '01', '15', '1501', '150130', '2026-04-20 22:22:36.658624', NULL, 'PROCERES DE LA INDEPENDENCIA', NULL, 'NUMERO 1596', '2548785', '999999999', 'Solicito información de las prisiones preventivas', 10, 0, 'S', 2, '2026-04-20 22:22:36.658624', 'I', 'postgres', NULL, NULL, '::1', NULL),
(2, 1, '02', '02', '15', '1501', '150110', '2026-06-04 09:08:58.844121', NULL, 'MOLITALIA', NULL, 'FRENTE AL PARQUE TUPAC.', '9985474', '984747474', 'Se necesita, realizar un trámite o una carta notarial.', 10, 0, 'S', 1, '2026-06-04 09:08:58.844121', 'I', NULL, NULL, NULL, '::1', NULL),
(3, 16, '04', '01', '15', '1501', '150138', '2026-06-05 11:21:24.230700', NULL, 'HADES', NULL, 'CERCA AL PARTE DIANA', '9998547', '995874747', 'NECESITO SOLICITAR UN EXPEDIENTE PORFAVOR', 10, 0, 'S', 16, '2026-06-05 11:21:24.230700', 'I', NULL, NULL, NULL, '::1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_anexos`
--

CREATE TABLE `solicitudes_anexos` (
  `c_solicitud_anexo` bigint(20) NOT NULL,
  `c_solicitud` bigint(20) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `n_secuencia` int(11) DEFAULT NULL,
  `x_archivo` varchar(100) NOT NULL,
  `x_ubicacion` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_anexos`
--

INSERT INTO `solicitudes_anexos` (`c_solicitud_anexo`, `c_solicitud`, `f_registro`, `n_secuencia`, `x_archivo`, `x_ubicacion`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
(1, 1, '2026-04-20 22:22:36.658624', 1, 'ANEXO 01.pdf', 'uploads/anexos/SOL_1_ANX_1_1776741756.pdf', 'S', 2, '2026-04-20 22:22:36.658624', 'I', 'postgres', NULL, NULL, '::1', NULL),
(2, 2, '2026-06-04 09:08:58.851310', 1, 'GRUPO CORIL SOCIEDAD AGENTE DE BOLSA SA_2 DIC 2020_0001.pdf', 'uploads/anexos/SOL_2_ANX_1_1780582138.pdf', 'S', 1, '2026-06-04 09:08:58.851310', 'I', NULL, NULL, NULL, '::1', NULL),
(3, 3, '2026-06-05 12:41:52.315782', 1, 'ARCHIVO_Tomo 12 - C.F. 104-2023-convertido_v3.pdf', 'uploads/archivo/ARCHIVO_SOL_3_1780680494.pdf', 'S', 9, '2026-06-05 12:41:52.315782', 'I', NULL, NULL, NULL, '::1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_apoyo`
--

CREATE TABLE `solicitudes_apoyo` (
  `c_solicitud_apoyo` bigint(20) NOT NULL,
  `c_solicitud` bigint(20) NOT NULL,
  `c_solicitud_anexo` bigint(20) DEFAULT NULL,
  `c_usuario_reporta` bigint(20) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_motivo` varchar(120) NOT NULL,
  `x_descripcion` text DEFAULT NULL,
  `x_estado` varchar(30) DEFAULT 'PENDIENTE',
  `n_sla_horas` int(11) DEFAULT 24,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_apoyo`
--

INSERT INTO `solicitudes_apoyo` (`c_solicitud_apoyo`, `c_solicitud`, `c_solicitud_anexo`, `c_usuario_reporta`, `f_registro`, `x_motivo`, `x_descripcion`, `x_estado`, `n_sla_horas`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `n_aud_ip`) VALUES
(1, 2, 2, 1, '2026-06-04 13:04:29.965396', 'ARCHIVO FISICO NO ENCONTRADO', 'El anexo GRUPO CORIL SOCIEDAD AGENTE DE BOLSA SA_2 DIC 2020_0001.pdf figura en la base de datos, pero falta guardar/copiar el PDF fisico en storage/uploads/anexos.', 'PENDIENTE', 24, 'S', 1, '2026-06-04 13:04:29.965396', 'I', '127.0.0.1'),
(2, 2, 2, 1, '2026-06-04 13:07:14.039090', 'ARCHIVO NO SUBIDO', 'AYUDAME A CAMBIARLO PORFAVOR\n[2026-06-04 23:29 - ADMINISTRADOR SISTEMA] ok', 'EN ATENCION', 24, 'S', 13, '2026-06-04 17:56:11.769794', 'U', '::1'),
(3, 1, 1, 13, '2026-06-04 15:52:23.129388', 'ARCHIVO FISICO NO ENCONTRADO', 'El anexo figura en la base de datos, pero no existe en la carpeta storage/uploads/anexos.', 'PENDIENTE', 24, 'S', 13, '2026-06-04 15:52:23.129388', 'I', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_apoyo_mensajes`
--

CREATE TABLE `solicitudes_apoyo_mensajes` (
  `c_mensaje` bigint(20) NOT NULL,
  `c_solicitud_apoyo` bigint(20) DEFAULT NULL,
  `c_solicitud` bigint(20) NOT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_origen` varchar(20) NOT NULL,
  `x_mensaje` text NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_apoyo_mensajes`
--

INSERT INTO `solicitudes_apoyo_mensajes` (`c_mensaje`, `c_solicitud_apoyo`, `c_solicitud`, `c_usuario`, `f_registro`, `x_origen`, `x_mensaje`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `n_aud_ip`) VALUES
(1, 2, 2, 1, '2026-06-04 17:40:08.593662', 'CIUDADANO', 'HOLA NECESITO AYUDA', 'S', 1, '2026-06-04 17:40:08.593662', 'I', '::1'),
(2, 2, 2, 1, '2026-06-04 17:40:08.595064', 'BOT', 'Tu caso fue derivado a Administracion del Sistema. Un administrador respondera desde Soporte SLA.', 'S', 1, '2026-06-04 17:40:08.595064', 'I', '::1'),
(3, 2, 2, 13, '2026-06-04 17:46:44.848271', 'ADMIN', 'Hola en que necesitas hacer?', 'S', 13, '2026-06-04 17:46:44.848271', 'I', '::1'),
(4, 2, 2, 1, '2026-06-04 17:48:59.499379', 'CIUDADANO', 'Mi documento que solicite no es la ficha sion otro codumento', 'S', 1, '2026-06-04 17:48:59.499379', 'I', '::1'),
(5, 2, 2, 1, '2026-06-04 17:49:08.665018', 'CIUDADANO', 'Necesito conversar con Administracion del Sistema para solucionar mi problema.', 'S', 1, '2026-06-04 17:49:08.665018', 'I', '::1'),
(6, 2, 2, 1, '2026-06-04 17:49:08.666218', 'BOT', 'Tu caso fue derivado a Administracion del Sistema. Un administrador respondera desde Soporte SLA.', 'S', 1, '2026-06-04 17:49:08.666218', 'I', '::1'),
(7, 2, 2, 13, '2026-06-04 17:49:54.508374', 'ADMIN', 'hola?', 'S', 13, '2026-06-04 17:49:54.508374', 'I', '::1'),
(8, 2, 2, 1, '2026-06-04 17:50:11.197116', 'CIUDADANO', 'Necesito conversar con Administracion del Sistema para solucionar mi problema.', 'S', 1, '2026-06-04 17:50:11.197116', 'I', '::1'),
(9, 2, 2, 1, '2026-06-04 17:50:11.231226', 'BOT', 'Tu caso fue derivado a Administracion del Sistema. Un administrador respondera desde Soporte SLA.', 'S', 1, '2026-06-04 17:50:11.231226', 'I', '::1'),
(10, 2, 2, 1, '2026-06-04 17:55:33.317292', 'CIUDADANO', 'esta bien', 'S', 1, '2026-06-04 17:55:33.317292', 'I', '::1'),
(11, 2, 2, 13, '2026-06-04 17:55:42.799610', 'ADMIN', 'entonces como solucionamos su problema', 'S', 13, '2026-06-04 17:55:42.799610', 'I', '::1'),
(12, 2, 2, 1, '2026-06-04 17:55:56.017977', 'CIUDADANO', 'bueno no s etu diras, ayudame porfavor', 'S', 1, '2026-06-04 17:55:56.017977', 'I', '::1'),
(13, 2, 2, 13, '2026-06-04 17:56:11.767857', 'ADMIN', 'okey entiendo, ya este ahorita lo reviso', 'S', 13, '2026-06-04 17:56:11.767857', 'I', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_reiterativos`
--

CREATE TABLE `solicitudes_reiterativos` (
  `c_solicitud_reiterativo` bigint(20) NOT NULL,
  `c_solicitud` bigint(20) DEFAULT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `c_tipo_solicitud_estado` char(2) DEFAULT NULL,
  `c_corte` char(2) DEFAULT NULL,
  `c_unidad_administrativa` char(2) DEFAULT NULL,
  `c_area_administrativa` char(3) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_observacion` text DEFAULT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_respuestas`
--

CREATE TABLE `solicitudes_respuestas` (
  `c_solicitud_respuesta` bigint(20) NOT NULL,
  `c_solicitud` bigint(20) DEFAULT NULL,
  `c_solicitud_ubicacion` bigint(20) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `n_secuencia` int(11) DEFAULT NULL,
  `x_archivo` varchar(100) NOT NULL,
  `x_ubicacion` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_respuestas`
--

INSERT INTO `solicitudes_respuestas` (`c_solicitud_respuesta`, `c_solicitud`, `c_solicitud_ubicacion`, `f_registro`, `n_secuencia`, `x_archivo`, `x_ubicacion`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
(1, 2, 3, '2026-06-04 12:45:49.352569', 1, 'firmado_1.pdf', 'uploads/respuestas/firmado_1.pdf', 'S', 7, '2026-06-04 14:29:18.878782', 'U', NULL, NULL, NULL, '::1', NULL),
(2, 3, 15, '2026-06-05 12:46:10.486200', 1, 'firmado_2.pdf', 'uploads/respuestas/firmado_2.pdf', 'S', 7, '2026-06-05 12:47:44.663634', 'U', NULL, NULL, NULL, '::1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_respuestas_firmas`
--

CREATE TABLE `solicitudes_respuestas_firmas` (
  `c_respuesta_firma` bigint(20) NOT NULL,
  `c_solicitud_respuesta` bigint(20) NOT NULL,
  `c_firma_jefe` bigint(20) NOT NULL,
  `c_usuario_firma` bigint(20) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_respuestas_firmas`
--

INSERT INTO `solicitudes_respuestas_firmas` (`c_respuesta_firma`, `c_solicitud_respuesta`, `c_firma_jefe`, `c_usuario_firma`, `f_registro`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `n_aud_ip`) VALUES
(1, 1, 3, 7, '2026-06-04 13:12:50.891043', 'S', 7, '2026-06-04 13:12:50.891043', 'I', '127.0.0.1'),
(2, 2, 3, 7, '2026-06-05 12:46:10.488420', 'S', 7, '2026-06-05 12:46:10.488420', 'I', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_ubicaciones`
--

CREATE TABLE `solicitudes_ubicaciones` (
  `c_solicitud_ubicacion` bigint(20) NOT NULL,
  `c_solicitud` bigint(20) DEFAULT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `c_tipo_solicitud_estado` char(2) DEFAULT NULL,
  `c_corte` char(2) DEFAULT NULL,
  `c_unidad_administrativa` char(2) DEFAULT NULL,
  `c_area_administrativa` char(3) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_observacion` text DEFAULT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_ubicaciones`
--

INSERT INTO `solicitudes_ubicaciones` (`c_solicitud_ubicacion`, `c_solicitud`, `c_usuario`, `c_tipo_solicitud_estado`, `c_corte`, `c_unidad_administrativa`, `c_area_administrativa`, `f_registro`, `x_observacion`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
(1, 1, 2, '01', '18', NULL, NULL, '2026-04-20 22:22:36.658624', 'REGISTRO INICIAL POR EL CIUDADANO', 'S', 2, '2026-04-20 22:22:36.658624', 'I', 'postgres', NULL, NULL, '::1', NULL),
(2, 2, 1, '01', '20', NULL, NULL, '2026-06-04 09:08:58.847526', 'REGISTRO INICIAL POR EL CIUDADANO', 'S', 1, '2026-06-04 09:08:58.847526', 'I', NULL, NULL, NULL, '::1', NULL),
(3, 2, 13, '02', '20', NULL, NULL, '2026-06-04 10:12:32.445711', 'DERIVADO A: SECRETARIA GENERAL - INFORMACION ADMINISTRATIVA Y RESOLUCIONES | SE DERIVA PARA EVALUAR COMPETENCIA, UBICAR LA INFORMACION SOLICITADA Y REMITIR RESPUESTA DOCUMENTADA.', 'S', 13, '2026-06-04 10:12:32.445711', 'I', NULL, NULL, NULL, '::1', NULL),
(4, 2, 7, '04', '20', NULL, NULL, '2026-06-04 12:45:49.353679', 'FIRMA DIGITAL APLICADA EN TODAS LAS HOJAS DEL DOCUMENTO DEL CIUDADANO Y REGISTRADA EN PLATAFORMA. | FIRMADO POR: JORGUE QUIROZ BERROCAL - JUEZ SUPERIOR', 'S', 7, '2026-06-04 12:45:49.353679', 'I', NULL, NULL, NULL, '::1', NULL),
(5, 3, 16, '01', '20', NULL, NULL, '2026-06-05 11:21:24.232904', 'REGISTRO INICIAL POR EL CIUDADANO', 'S', 16, '2026-06-05 11:21:24.232904', 'I', NULL, NULL, NULL, '::1', NULL),
(6, 3, 5, '02', '20', NULL, NULL, '2026-06-05 11:25:06.801422', 'DERIVADO A: MESA DE PARTES - LO REVISA MESA DE PARTES | SE DERIVA PARA EVALUAR COMPETENCIA, UBICAR LA INFORMACION SOLICITADA Y REMITIR RESPUESTA DOCUMENTADA.', 'S', 5, '2026-06-05 11:25:06.801422', 'I', NULL, NULL, NULL, '::1', NULL),
(7, 3, 10, '02', '20', NULL, NULL, '2026-06-05 11:41:36.320977', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', 'S', 10, '2026-06-05 11:41:36.320977', 'I', NULL, NULL, NULL, '::1', NULL),
(8, 3, 10, '02', '20', NULL, NULL, '2026-06-05 11:41:41.847255', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', 'S', 10, '2026-06-05 11:41:41.847255', 'I', NULL, NULL, NULL, '::1', NULL),
(9, 3, 10, '02', '20', NULL, NULL, '2026-06-05 11:41:43.344468', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', 'S', 10, '2026-06-05 11:41:43.344468', 'I', NULL, NULL, NULL, '::1', NULL),
(10, 3, 10, '02', '20', NULL, NULL, '2026-06-05 11:41:44.429575', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', 'S', 10, '2026-06-05 11:41:44.429575', 'I', NULL, NULL, NULL, '::1', NULL),
(11, 3, 10, '02', '20', NULL, NULL, '2026-06-05 11:42:09.283708', 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION', 'S', 10, '2026-06-05 11:42:09.283708', 'I', NULL, NULL, NULL, '::1', NULL),
(12, 3, 10, '02', '20', NULL, NULL, '2026-06-05 11:48:37.442168', 'REMITIDO POR MESA DE PARTES A: ARCHIVO CENTRAL', 'S', 10, '2026-06-05 11:48:37.442168', 'I', NULL, NULL, NULL, '::1', NULL),
(13, 3, 5, '02', '20', NULL, NULL, '2026-06-05 12:14:13.465746', 'DERIVADO A: ARCHIVO CENTRAL - LO REVISA TECNICO DE ARCHIVO | SE DERIVA PARA EVALUAR COMPETENCIA, UBICAR LA INFORMACION SOLICITADA Y REMITIR RESPUESTA DOCUMENTADA.', 'S', 5, '2026-06-05 12:14:13.465746', 'I', NULL, NULL, NULL, '::1', NULL),
(14, 3, 9, '02', '20', NULL, NULL, '2026-06-05 12:28:14.390246', 'ARCHIVO CENTRAL | DOCUMENTO PREPARADO COMO ANEXO DE RESPUESTA | EL ARCHIVO FALTA SER FIRMADO POR EL JUEZ OH NOTARIO,ETC', 'S', 9, '2026-06-05 12:28:14.390246', 'I', NULL, NULL, NULL, '::1', NULL),
(15, 3, 9, '02', '20', NULL, NULL, '2026-06-05 12:32:48.543587', 'ARCHIVO CENTRAL | DOCUMENTACION REMITIDA A: ASISTENCIA ADMINISTRATIVA', 'S', 9, '2026-06-05 12:32:48.543587', 'I', NULL, NULL, NULL, '::1', NULL),
(16, 3, 7, '04', '20', NULL, NULL, '2026-06-05 12:47:44.664204', 'DOCUMENTOS FIRMADOS | FIRMADO POR: JORGUE QUIROZ BERROCAL - JUEZ SUPERIOR', 'S', 7, '2026-06-05 12:47:44.664204', 'I', NULL, NULL, NULL, '::1', NULL),
(17, 3, 16, '04', '20', NULL, NULL, '2026-06-05 14:21:58.152021', 'PAGO DE REPRODUCCION CONFIRMADO | COPIA SIMPLE | S/ 5.00 | CULQI-DEMO-20260605212158-804', 'S', 16, '2026-06-05 14:21:58.152021', 'I', NULL, NULL, NULL, '::1', NULL),
(18, 3, 13, '04', '20', NULL, NULL, '2026-06-05 15:04:14.606434', 'COPIA SIMPLE PREPARADA CON MARCA DE AGUA PARA ENTREGA AL CIUDADANO', 'S', 13, '2026-06-05 15:04:14.606434', 'I', NULL, NULL, NULL, '::1', NULL),
(19, 3, 13, '04', '20', NULL, NULL, '2026-06-05 15:06:24.457109', 'COPIA SIMPLE ENTREGADA AL CIUDADANO', 'S', 13, '2026-06-05 15:06:24.457109', 'I', NULL, NULL, NULL, '::1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_perfiles`
--

CREATE TABLE `tipos_perfiles` (
  `c_tipo_perfil` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_tipo_perfil` varchar(50) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_perfiles`
--

INSERT INTO `tipos_perfiles` (`c_tipo_perfil`, `f_registro`, `x_tipo_perfil`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('01', '2026-04-18 21:55:26.567403', 'CIUDADANO', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL),
('02', '2026-04-18 21:55:26.567403', 'RESPONSABLE TRANSPARENCIA', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL),
('03', '2026-04-18 21:55:26.567403', 'JEFE ADMINISTRATIVO', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL),
('04', '2026-04-18 21:55:26.567403', 'ASISTENTE ADMINISTRATIVO', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL),
('05', '2026-04-18 21:55:26.567403', 'RESPONSABLE ODANC', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL),
('06', '2026-06-03 18:54:57.963379', 'TECNICO DE ARCHIVO', 'S', 1, '2026-06-03 18:54:57.963379', 'I', 'root', NULL, NULL, NULL, NULL),
('07', '2026-06-03 18:54:57.963379', 'MESA DE PARTES', 'S', 1, '2026-06-03 18:54:57.963379', 'I', 'root', NULL, NULL, NULL, NULL),
('08', '2026-06-03 18:54:57.963379', 'SUPERVISOR GENERAL', 'S', 1, '2026-06-03 18:54:57.963379', 'I', 'root', NULL, NULL, NULL, NULL),
('09', '2026-06-03 18:54:57.963379', 'AUDITOR DE PLAZOS', 'S', 1, '2026-06-03 18:54:57.963379', 'I', 'root', NULL, NULL, NULL, NULL),
('10', '2026-06-03 18:54:57.963379', 'ADMINISTRADOR DEL SISTEMA', 'S', 1, '2026-06-03 18:54:57.963379', 'I', 'root', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_personas`
--

CREATE TABLE `tipos_personas` (
  `c_tipo_persona` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_tipo_persona` varchar(80) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_personas`
--

INSERT INTO `tipos_personas` (`c_tipo_persona`, `f_registro`, `x_tipo_persona`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('01', '2026-04-18 22:42:17.540049', 'PERSONA NATURAL', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL),
('02', '2026-04-18 22:42:17.540049', 'PERSONA JURIDICA', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL),
('03', '2026-04-18 22:42:17.540049', 'PERSONA EXTRANJERA', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL),
('04', '2026-04-18 22:42:17.540049', 'PERSONA NATURAL CON RUC', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL),
('05', '2026-04-18 22:42:17.540049', 'PERSONA JURIDICA EXTRANJERA', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL),
('06', '2026-04-18 22:42:17.540049', 'TRABAJADOR JUDICIAL', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_solicitud_estados`
--

CREATE TABLE `tipos_solicitud_estados` (
  `c_tipo_solicitud_estado` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_tipo_solicitud_estado` varchar(50) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_solicitud_estados`
--

INSERT INTO `tipos_solicitud_estados` (`c_tipo_solicitud_estado`, `f_registro`, `x_tipo_solicitud_estado`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('01', '2026-04-18 21:58:28.298469', 'PENDIENTE', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL),
('02', '2026-04-18 21:58:28.298469', 'EN PROCESO', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL),
('03', '2026-04-18 21:58:28.298469', 'CON PRÓRROGA', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL),
('04', '2026-04-18 21:58:28.298469', 'ATENDIDO', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL),
('05', '2026-04-18 21:58:28.298469', 'VENCIDO', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_vias`
--

CREATE TABLE `tipos_vias` (
  `c_tipo_via` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_tipo_via` varchar(50) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_vias`
--

INSERT INTO `tipos_vias` (`c_tipo_via`, `f_registro`, `x_tipo_via`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('01', '2026-04-18 22:01:23.190269', 'AVENIDA', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('02', '2026-04-18 22:01:23.190269', 'JIRÓN', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('03', '2026-04-18 22:01:23.190269', 'CALLE', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('04', '2026-04-18 22:01:23.190269', 'PASAJE', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('05', '2026-04-18 22:01:23.190269', 'CARRETERA', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('06', '2026-04-18 22:01:23.190269', 'PROLONGACIÓN', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('07', '2026-04-18 22:01:23.190269', 'ALAMEDA', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('08', '2026-04-18 22:01:23.190269', 'MALECÓN', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('09', '2026-04-18 22:01:23.190269', 'ÓVALO', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('10', '2026-04-18 22:01:23.190269', 'PARQUE', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL),
('11', '2026-04-18 22:01:23.190269', 'OTROS', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_zonas`
--

CREATE TABLE `tipos_zonas` (
  `c_tipo_zona` char(2) NOT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_tipo_zona` varchar(50) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_zonas`
--

INSERT INTO `tipos_zonas` (`c_tipo_zona`, `f_registro`, `x_tipo_zona`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
('01', '2026-04-18 22:02:28.236438', 'URBANIZACIÓN', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('02', '2026-04-18 22:02:28.236438', 'ASENTAMIENTO HUMANO', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('03', '2026-04-18 22:02:28.236438', 'PUEBLO JOVEN', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('04', '2026-04-18 22:02:28.236438', 'UNIDAD VECINAL', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('05', '2026-04-18 22:02:28.236438', 'CONJUNTO HABITACIONAL', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('06', '2026-04-18 22:02:28.236438', 'COOPERATIVA', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('07', '2026-04-18 22:02:28.236438', 'RESIDENCIAL', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('08', '2026-04-18 22:02:28.236438', 'ASOCIACIÓN', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('09', '2026-04-18 22:02:28.236438', 'GRUPO VIVIENDA', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('10', '2026-04-18 22:02:28.236438', 'ZONA INDUSTRIAL', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL),
('11', '2026-04-18 22:02:28.236438', 'OTROS', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `c_trabajador` bigint(20) NOT NULL,
  `c_usuario` bigint(20) DEFAULT NULL,
  `c_corte` char(2) DEFAULT NULL,
  `c_unidad_administrativa` char(2) DEFAULT NULL,
  `c_area_administrativa` char(3) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_administrativas`
--

CREATE TABLE `unidades_administrativas` (
  `c_unidad_administrativa` char(2) NOT NULL,
  `c_corte` char(2) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `x_unidad_administrativa` varchar(100) NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `c_usuario` bigint(20) NOT NULL,
  `c_tipo_perfil` char(2) DEFAULT NULL,
  `c_tipo_persona` char(2) DEFAULT NULL,
  `f_registro` datetime(6) DEFAULT current_timestamp(6),
  `n_documento` varchar(20) NOT NULL,
  `x_nombres` varchar(100) NOT NULL,
  `x_ap_paterno` varchar(50) NOT NULL,
  `x_ap_materno` varchar(50) DEFAULT NULL,
  `x_correo` varchar(100) NOT NULL,
  `x_contrasena` text NOT NULL,
  `l_estado` char(1) DEFAULT 'S',
  `c_aud` int(11) DEFAULT NULL,
  `f_aud` datetime(6) DEFAULT current_timestamp(6),
  `b_aud` char(1) NOT NULL,
  `c_aud_uid` varchar(30) DEFAULT NULL,
  `c_aud_uidred` varchar(30) DEFAULT NULL,
  `c_aud_pc` varchar(30) DEFAULT NULL,
  `n_aud_ip` varchar(15) DEFAULT NULL,
  `c_aud_mcaddr` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`c_usuario`, `c_tipo_perfil`, `c_tipo_persona`, `f_registro`, `n_documento`, `x_nombres`, `x_ap_paterno`, `x_ap_materno`, `x_correo`, `x_contrasena`, `l_estado`, `c_aud`, `f_aud`, `b_aud`, `c_aud_uid`, `c_aud_uidred`, `c_aud_pc`, `n_aud_ip`, `c_aud_mcaddr`) VALUES
(1, '01', '06', '2026-04-18 22:42:17.540049', '12345678', 'Luis', 'Centeno', NULL, 'u18209348@utp.edu.pe', '123456', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL),
(2, '01', '01', '2026-04-20 00:13:51.637559', '789456123', 'GABRIEL', 'GONZALES', 'PRADA', 'u18209349@utp.edu.pe', '123456', 'S', 0, '2026-04-20 00:13:51.637559', 'I', 'postgres', NULL, NULL, '::1', NULL),
(3, '01', '01', '2026-04-20 00:14:45.719119', '789456123', 'JULIO', 'PORTOCARRERO', 'GUTIERREZ', 'u18209350@utp.edu.pe', '123456', 'S', 0, '2026-04-20 00:14:45.719119', 'I', 'postgres', NULL, NULL, '::1', NULL),
(4, '01', '01', '2026-04-20 00:15:09.886009', '789456123', 'MANUEL', 'QUIROZ', 'LOPEZ', 'u18209351@utp.edu.pe', '123456', 'S', 0, '2026-04-20 00:15:09.886009', 'I', 'postgres', NULL, NULL, '::1', NULL),
(5, '02', '06', '2026-06-03 18:54:57.969039', '20000002', 'RESPONSABLE', 'TRANSPARENCIA', NULL, 'responsable@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(6, '03', '06', '2026-06-03 18:54:57.969039', '20000003', 'JEFE', 'ADMINISTRATIVO', NULL, 'jefe@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(7, '04', '06', '2026-06-03 18:54:57.969039', '20000004', 'ASISTENTE', 'ADMINISTRATIVO', NULL, 'asistente@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(8, '05', '06', '2026-06-03 18:54:57.969039', '20000005', 'RESPONSABLE', 'ODANC', NULL, 'odanc@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(9, '06', '06', '2026-06-03 18:54:57.969039', '20000006', 'TECNICO', 'ARCHIVO', NULL, 'archivo@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(10, '07', '06', '2026-06-03 18:54:57.969039', '20000007', 'MESA', 'PARTES', NULL, 'mesa@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(11, '08', '06', '2026-06-03 18:54:57.969039', '20000008', 'SUPERVISOR', 'GENERAL', NULL, 'supervisor@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(12, '09', '06', '2026-06-03 18:54:57.969039', '20000009', 'AUDITOR', 'PLAZOS', NULL, 'auditor@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(13, '10', '06', '2026-06-03 18:54:57.969039', '20000010', 'ADMINISTRADOR', 'SISTEMA', NULL, 'admin@pj.gob.pe', '123456', 'S', 1, '2026-06-03 18:54:57.969039', 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(14, '03', '01', '2026-06-04 12:31:57.494135', '20260020', 'JEFE', 'LIMA NORTE', 'DEMO', 'jefe.norte@pj.gob.pe', '123456', 'S', 1, '2026-06-04 12:31:57.494135', 'I', NULL, NULL, NULL, '127.0.0.1', NULL),
(15, '03', '01', '2026-06-04 12:39:46.782677', '20260021', 'JORGUE', 'QUIROZ', NULL, 'JQ_JEFE_NORTE@PJ.GOB.PE', '123456', 'S', 1, '2026-06-04 12:39:46.782677', 'I', NULL, NULL, NULL, '127.0.0.1', NULL),
(16, '01', '01', '2026-06-05 11:01:02.278559', '47532188', 'JOSE DAVID', 'HUERTAS', 'QUIROZ', 'u21212977@utp.edu.pe', '123456', 'S', 0, '2026-06-05 11:01:02.278559', 'I', NULL, NULL, NULL, '::1', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivo_preparaciones`
--
ALTER TABLE `archivo_preparaciones`
  ADD PRIMARY KEY (`c_archivo_preparacion`),
  ADD KEY `idx_archivo_preparaciones_solicitud` (`c_solicitud`);

--
-- Indices de la tabla `areas_administrativas`
--
ALTER TABLE `areas_administrativas`
  ADD PRIMARY KEY (`c_area_administrativa`),
  ADD KEY `areas_administrativas_c_unidad_administrativa_fkey` (`c_unidad_administrativa`);

--
-- Indices de la tabla `auditorias_sistema`
--
ALTER TABLE `auditorias_sistema`
  ADD PRIMARY KEY (`c_auditoria`),
  ADD KEY `idx_auditoria_usuario` (`c_usuario`),
  ADD KEY `idx_auditoria_solicitud` (`c_solicitud`),
  ADD KEY `idx_auditoria_evento` (`x_evento`),
  ADD KEY `idx_auditoria_fecha` (`f_registro`);

--
-- Indices de la tabla `cortes_nacionales`
--
ALTER TABLE `cortes_nacionales`
  ADD PRIMARY KEY (`c_corte`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`c_departamento`);

--
-- Indices de la tabla `distritos`
--
ALTER TABLE `distritos`
  ADD PRIMARY KEY (`c_distrito`),
  ADD KEY `distritos_c_provincia_fkey` (`c_provincia`);

--
-- Indices de la tabla `firmas_jefes`
--
ALTER TABLE `firmas_jefes`
  ADD PRIMARY KEY (`c_firma_jefe`),
  ADD KEY `idx_firmas_jefes_corte` (`c_corte`);

--
-- Indices de la tabla `pagos_reproduccion`
--
ALTER TABLE `pagos_reproduccion`
  ADD PRIMARY KEY (`c_pago_reproduccion`),
  ADD KEY `idx_pagos_reproduccion_solicitud` (`c_solicitud`),
  ADD KEY `idx_pagos_reproduccion_respuesta` (`c_solicitud_respuesta`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`c_provincia`),
  ADD KEY `provincias_c_departamento_fkey` (`c_departamento`);

--
-- Indices de la tabla `recuperaciones_contrasenas`
--
ALTER TABLE `recuperaciones_contrasenas`
  ADD PRIMARY KEY (`c_recupera_contrasena`),
  ADD KEY `recuperaciones_contrasenas_c_usuario_fkey` (`c_usuario`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`c_solicitud`),
  ADD KEY `solicitudes_c_departamento_fkey` (`c_departamento`),
  ADD KEY `solicitudes_c_distrito_fkey` (`c_distrito`),
  ADD KEY `solicitudes_c_provincia_fkey` (`c_provincia`),
  ADD KEY `solicitudes_c_tipo_via_fkey` (`c_tipo_via`),
  ADD KEY `solicitudes_c_tipo_zona_fkey` (`c_tipo_zona`),
  ADD KEY `solicitudes_c_usuario_fkey` (`c_usuario`);

--
-- Indices de la tabla `solicitudes_anexos`
--
ALTER TABLE `solicitudes_anexos`
  ADD PRIMARY KEY (`c_solicitud_anexo`),
  ADD KEY `solicitudes_anexos_c_solicitud_fkey` (`c_solicitud`);

--
-- Indices de la tabla `solicitudes_apoyo`
--
ALTER TABLE `solicitudes_apoyo`
  ADD PRIMARY KEY (`c_solicitud_apoyo`),
  ADD KEY `idx_apoyo_solicitud` (`c_solicitud`),
  ADD KEY `idx_apoyo_estado` (`x_estado`);

--
-- Indices de la tabla `solicitudes_apoyo_mensajes`
--
ALTER TABLE `solicitudes_apoyo_mensajes`
  ADD PRIMARY KEY (`c_mensaje`),
  ADD KEY `idx_apoyo_mensajes_ticket` (`c_solicitud_apoyo`),
  ADD KEY `idx_apoyo_mensajes_solicitud` (`c_solicitud`);

--
-- Indices de la tabla `solicitudes_reiterativos`
--
ALTER TABLE `solicitudes_reiterativos`
  ADD PRIMARY KEY (`c_solicitud_reiterativo`),
  ADD KEY `solicitudes_reiterativos_c_area_administrativa_fkey` (`c_area_administrativa`),
  ADD KEY `solicitudes_reiterativos_c_corte_fkey` (`c_corte`),
  ADD KEY `solicitudes_reiterativos_c_solicitud_fkey` (`c_solicitud`),
  ADD KEY `solicitudes_reiterativos_c_tipo_solicitud_estado_fkey` (`c_tipo_solicitud_estado`),
  ADD KEY `solicitudes_reiterativos_c_unidad_administrativa_fkey` (`c_unidad_administrativa`),
  ADD KEY `solicitudes_reiterativos_c_usuario_fkey` (`c_usuario`);

--
-- Indices de la tabla `solicitudes_respuestas`
--
ALTER TABLE `solicitudes_respuestas`
  ADD PRIMARY KEY (`c_solicitud_respuesta`),
  ADD KEY `solicitudes_respuestas_c_solicitud_fkey` (`c_solicitud`),
  ADD KEY `solicitudes_respuestas_c_solicitud_ubicacion_fkey` (`c_solicitud_ubicacion`);

--
-- Indices de la tabla `solicitudes_respuestas_firmas`
--
ALTER TABLE `solicitudes_respuestas_firmas`
  ADD PRIMARY KEY (`c_respuesta_firma`),
  ADD KEY `idx_respuestas_firmas_respuesta` (`c_solicitud_respuesta`),
  ADD KEY `idx_respuestas_firmas_firma` (`c_firma_jefe`);

--
-- Indices de la tabla `solicitudes_ubicaciones`
--
ALTER TABLE `solicitudes_ubicaciones`
  ADD PRIMARY KEY (`c_solicitud_ubicacion`),
  ADD KEY `solicitudes_ubicaciones_c_area_administrativa_fkey` (`c_area_administrativa`),
  ADD KEY `solicitudes_ubicaciones_c_corte_fkey` (`c_corte`),
  ADD KEY `solicitudes_ubicaciones_c_solicitud_fkey` (`c_solicitud`),
  ADD KEY `solicitudes_ubicaciones_c_tipo_solicitud_estado_fkey` (`c_tipo_solicitud_estado`),
  ADD KEY `solicitudes_ubicaciones_c_unidad_administrativa_fkey` (`c_unidad_administrativa`),
  ADD KEY `solicitudes_ubicaciones_c_usuario_fkey` (`c_usuario`);

--
-- Indices de la tabla `tipos_perfiles`
--
ALTER TABLE `tipos_perfiles`
  ADD PRIMARY KEY (`c_tipo_perfil`);

--
-- Indices de la tabla `tipos_personas`
--
ALTER TABLE `tipos_personas`
  ADD PRIMARY KEY (`c_tipo_persona`);

--
-- Indices de la tabla `tipos_solicitud_estados`
--
ALTER TABLE `tipos_solicitud_estados`
  ADD PRIMARY KEY (`c_tipo_solicitud_estado`);

--
-- Indices de la tabla `tipos_vias`
--
ALTER TABLE `tipos_vias`
  ADD PRIMARY KEY (`c_tipo_via`);

--
-- Indices de la tabla `tipos_zonas`
--
ALTER TABLE `tipos_zonas`
  ADD PRIMARY KEY (`c_tipo_zona`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`c_trabajador`),
  ADD KEY `trabajadores_c_area_administrativa_fkey` (`c_area_administrativa`),
  ADD KEY `trabajadores_c_corte_fkey` (`c_corte`),
  ADD KEY `trabajadores_c_unidad_administrativa_fkey` (`c_unidad_administrativa`),
  ADD KEY `trabajadores_c_usuario_fkey` (`c_usuario`);

--
-- Indices de la tabla `unidades_administrativas`
--
ALTER TABLE `unidades_administrativas`
  ADD PRIMARY KEY (`c_unidad_administrativa`),
  ADD KEY `unidades_administrativas_c_corte_fkey` (`c_corte`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`c_usuario`),
  ADD UNIQUE KEY `usuarios_x_correo_key` (`x_correo`),
  ADD KEY `usuarios_c_tipo_perfil_fkey` (`c_tipo_perfil`),
  ADD KEY `usuarios_c_tipo_persona_fkey` (`c_tipo_persona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivo_preparaciones`
--
ALTER TABLE `archivo_preparaciones`
  MODIFY `c_archivo_preparacion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `auditorias_sistema`
--
ALTER TABLE `auditorias_sistema`
  MODIFY `c_auditoria` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `firmas_jefes`
--
ALTER TABLE `firmas_jefes`
  MODIFY `c_firma_jefe` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pagos_reproduccion`
--
ALTER TABLE `pagos_reproduccion`
  MODIFY `c_pago_reproduccion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `recuperaciones_contrasenas`
--
ALTER TABLE `recuperaciones_contrasenas`
  MODIFY `c_recupera_contrasena` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `c_solicitud` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitudes_anexos`
--
ALTER TABLE `solicitudes_anexos`
  MODIFY `c_solicitud_anexo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitudes_apoyo`
--
ALTER TABLE `solicitudes_apoyo`
  MODIFY `c_solicitud_apoyo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitudes_apoyo_mensajes`
--
ALTER TABLE `solicitudes_apoyo_mensajes`
  MODIFY `c_mensaje` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `solicitudes_reiterativos`
--
ALTER TABLE `solicitudes_reiterativos`
  MODIFY `c_solicitud_reiterativo` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes_respuestas`
--
ALTER TABLE `solicitudes_respuestas`
  MODIFY `c_solicitud_respuesta` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitudes_respuestas_firmas`
--
ALTER TABLE `solicitudes_respuestas_firmas`
  MODIFY `c_respuesta_firma` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitudes_ubicaciones`
--
ALTER TABLE `solicitudes_ubicaciones`
  MODIFY `c_solicitud_ubicacion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `c_trabajador` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `c_usuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areas_administrativas`
--
ALTER TABLE `areas_administrativas`
  ADD CONSTRAINT `areas_administrativas_c_unidad_administrativa_fkey` FOREIGN KEY (`c_unidad_administrativa`) REFERENCES `unidades_administrativas` (`c_unidad_administrativa`);

--
-- Filtros para la tabla `distritos`
--
ALTER TABLE `distritos`
  ADD CONSTRAINT `distritos_c_provincia_fkey` FOREIGN KEY (`c_provincia`) REFERENCES `provincias` (`c_provincia`);

--
-- Filtros para la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD CONSTRAINT `provincias_c_departamento_fkey` FOREIGN KEY (`c_departamento`) REFERENCES `departamentos` (`c_departamento`);

--
-- Filtros para la tabla `recuperaciones_contrasenas`
--
ALTER TABLE `recuperaciones_contrasenas`
  ADD CONSTRAINT `recuperaciones_contrasenas_c_usuario_fkey` FOREIGN KEY (`c_usuario`) REFERENCES `usuarios` (`c_usuario`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_c_departamento_fkey` FOREIGN KEY (`c_departamento`) REFERENCES `departamentos` (`c_departamento`),
  ADD CONSTRAINT `solicitudes_c_distrito_fkey` FOREIGN KEY (`c_distrito`) REFERENCES `distritos` (`c_distrito`),
  ADD CONSTRAINT `solicitudes_c_provincia_fkey` FOREIGN KEY (`c_provincia`) REFERENCES `provincias` (`c_provincia`),
  ADD CONSTRAINT `solicitudes_c_tipo_via_fkey` FOREIGN KEY (`c_tipo_via`) REFERENCES `tipos_vias` (`c_tipo_via`),
  ADD CONSTRAINT `solicitudes_c_tipo_zona_fkey` FOREIGN KEY (`c_tipo_zona`) REFERENCES `tipos_zonas` (`c_tipo_zona`),
  ADD CONSTRAINT `solicitudes_c_usuario_fkey` FOREIGN KEY (`c_usuario`) REFERENCES `usuarios` (`c_usuario`);

--
-- Filtros para la tabla `solicitudes_anexos`
--
ALTER TABLE `solicitudes_anexos`
  ADD CONSTRAINT `solicitudes_anexos_c_solicitud_fkey` FOREIGN KEY (`c_solicitud`) REFERENCES `solicitudes` (`c_solicitud`);

--
-- Filtros para la tabla `solicitudes_reiterativos`
--
ALTER TABLE `solicitudes_reiterativos`
  ADD CONSTRAINT `solicitudes_reiterativos_c_area_administrativa_fkey` FOREIGN KEY (`c_area_administrativa`) REFERENCES `areas_administrativas` (`c_area_administrativa`),
  ADD CONSTRAINT `solicitudes_reiterativos_c_corte_fkey` FOREIGN KEY (`c_corte`) REFERENCES `cortes_nacionales` (`c_corte`),
  ADD CONSTRAINT `solicitudes_reiterativos_c_solicitud_fkey` FOREIGN KEY (`c_solicitud`) REFERENCES `solicitudes` (`c_solicitud`),
  ADD CONSTRAINT `solicitudes_reiterativos_c_tipo_solicitud_estado_fkey` FOREIGN KEY (`c_tipo_solicitud_estado`) REFERENCES `tipos_solicitud_estados` (`c_tipo_solicitud_estado`),
  ADD CONSTRAINT `solicitudes_reiterativos_c_unidad_administrativa_fkey` FOREIGN KEY (`c_unidad_administrativa`) REFERENCES `unidades_administrativas` (`c_unidad_administrativa`),
  ADD CONSTRAINT `solicitudes_reiterativos_c_usuario_fkey` FOREIGN KEY (`c_usuario`) REFERENCES `usuarios` (`c_usuario`);

--
-- Filtros para la tabla `solicitudes_respuestas`
--
ALTER TABLE `solicitudes_respuestas`
  ADD CONSTRAINT `solicitudes_respuestas_c_solicitud_fkey` FOREIGN KEY (`c_solicitud`) REFERENCES `solicitudes` (`c_solicitud`),
  ADD CONSTRAINT `solicitudes_respuestas_c_solicitud_ubicacion_fkey` FOREIGN KEY (`c_solicitud_ubicacion`) REFERENCES `solicitudes_ubicaciones` (`c_solicitud_ubicacion`);

--
-- Filtros para la tabla `solicitudes_ubicaciones`
--
ALTER TABLE `solicitudes_ubicaciones`
  ADD CONSTRAINT `solicitudes_ubicaciones_c_area_administrativa_fkey` FOREIGN KEY (`c_area_administrativa`) REFERENCES `areas_administrativas` (`c_area_administrativa`),
  ADD CONSTRAINT `solicitudes_ubicaciones_c_corte_fkey` FOREIGN KEY (`c_corte`) REFERENCES `cortes_nacionales` (`c_corte`),
  ADD CONSTRAINT `solicitudes_ubicaciones_c_solicitud_fkey` FOREIGN KEY (`c_solicitud`) REFERENCES `solicitudes` (`c_solicitud`),
  ADD CONSTRAINT `solicitudes_ubicaciones_c_tipo_solicitud_estado_fkey` FOREIGN KEY (`c_tipo_solicitud_estado`) REFERENCES `tipos_solicitud_estados` (`c_tipo_solicitud_estado`),
  ADD CONSTRAINT `solicitudes_ubicaciones_c_unidad_administrativa_fkey` FOREIGN KEY (`c_unidad_administrativa`) REFERENCES `unidades_administrativas` (`c_unidad_administrativa`),
  ADD CONSTRAINT `solicitudes_ubicaciones_c_usuario_fkey` FOREIGN KEY (`c_usuario`) REFERENCES `usuarios` (`c_usuario`);

--
-- Filtros para la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD CONSTRAINT `trabajadores_c_area_administrativa_fkey` FOREIGN KEY (`c_area_administrativa`) REFERENCES `areas_administrativas` (`c_area_administrativa`),
  ADD CONSTRAINT `trabajadores_c_corte_fkey` FOREIGN KEY (`c_corte`) REFERENCES `cortes_nacionales` (`c_corte`),
  ADD CONSTRAINT `trabajadores_c_unidad_administrativa_fkey` FOREIGN KEY (`c_unidad_administrativa`) REFERENCES `unidades_administrativas` (`c_unidad_administrativa`),
  ADD CONSTRAINT `trabajadores_c_usuario_fkey` FOREIGN KEY (`c_usuario`) REFERENCES `usuarios` (`c_usuario`);

--
-- Filtros para la tabla `unidades_administrativas`
--
ALTER TABLE `unidades_administrativas`
  ADD CONSTRAINT `unidades_administrativas_c_corte_fkey` FOREIGN KEY (`c_corte`) REFERENCES `cortes_nacionales` (`c_corte`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_c_tipo_perfil_fkey` FOREIGN KEY (`c_tipo_perfil`) REFERENCES `tipos_perfiles` (`c_tipo_perfil`),
  ADD CONSTRAINT `usuarios_c_tipo_persona_fkey` FOREIGN KEY (`c_tipo_persona`) REFERENCES `tipos_personas` (`c_tipo_persona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
