CREATE DATABASE IF NOT EXISTS casillatransparencia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE casillatransparencia;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE areas_administrativas (
    c_area_administrativa CHAR(3) NOT NULL,
    c_unidad_administrativa CHAR(2),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_area_administrativa VARCHAR(100) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_area_administrativa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cortes_nacionales (
    c_corte CHAR(2) NOT NULL,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_corte VARCHAR(100) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_corte)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE departamentos (
    c_departamento CHAR(2) NOT NULL,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_departamento VARCHAR(100) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_departamento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE distritos (
    c_distrito CHAR(6) NOT NULL,
    c_provincia CHAR(4),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_distrito VARCHAR(100) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_distrito)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE provincias (
    c_provincia CHAR(4) NOT NULL,
    c_departamento CHAR(2),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_provincia VARCHAR(100) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_provincia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE recuperaciones_contrasenas (
    c_recupera_contrasena BIGINT NOT NULL AUTO_INCREMENT,
    c_usuario BIGINT,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_hash TEXT NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_recupera_contrasena)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE solicitudes (
    c_solicitud BIGINT NOT NULL AUTO_INCREMENT,
    c_usuario BIGINT,
    c_tipo_via CHAR(2),
    c_tipo_zona CHAR(2),
    c_departamento CHAR(2),
    c_provincia CHAR(4),
    c_distrito CHAR(6),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_via_otro VARCHAR(50),
    x_nombre_via VARCHAR(100),
    x_zona_otro VARCHAR(50),
    x_referencia VARCHAR(100),
    x_telefono VARCHAR(7),
    x_celular VARCHAR(9),
    x_sustentacion TEXT NOT NULL,
    n_tiempo_atencion INT DEFAULT 10,
    n_tiempo_prorroga INT DEFAULT 0,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_solicitud)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE solicitudes_anexos (
    c_solicitud_anexo BIGINT NOT NULL AUTO_INCREMENT,
    c_solicitud BIGINT,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    n_secuencia INT,
    x_archivo VARCHAR(100) NOT NULL,
    x_ubicacion VARCHAR(100) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_solicitud_anexo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE solicitudes_reiterativos (
    c_solicitud_reiterativo BIGINT NOT NULL AUTO_INCREMENT,
    c_solicitud BIGINT,
    c_usuario BIGINT,
    c_tipo_solicitud_estado CHAR(2),
    c_corte CHAR(2),
    c_unidad_administrativa CHAR(2),
    c_area_administrativa CHAR(3),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_observacion TEXT,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_solicitud_reiterativo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE solicitudes_respuestas (
    c_solicitud_respuesta BIGINT NOT NULL AUTO_INCREMENT,
    c_solicitud BIGINT,
    c_solicitud_ubicacion BIGINT,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    n_secuencia INT,
    x_archivo VARCHAR(100) NOT NULL,
    x_ubicacion VARCHAR(100) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_solicitud_respuesta)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE solicitudes_ubicaciones (
    c_solicitud_ubicacion BIGINT NOT NULL AUTO_INCREMENT,
    c_solicitud BIGINT,
    c_usuario BIGINT,
    c_tipo_solicitud_estado CHAR(2),
    c_corte CHAR(2),
    c_unidad_administrativa CHAR(2),
    c_area_administrativa CHAR(3),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_observacion TEXT,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_solicitud_ubicacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tipos_perfiles (
    c_tipo_perfil CHAR(2) NOT NULL,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_tipo_perfil VARCHAR(50) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_tipo_perfil)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tipos_personas (
    c_tipo_persona CHAR(2) NOT NULL,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_tipo_persona VARCHAR(80) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_tipo_persona)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tipos_solicitud_estados (
    c_tipo_solicitud_estado CHAR(2) NOT NULL,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_tipo_solicitud_estado VARCHAR(50) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_tipo_solicitud_estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tipos_vias (
    c_tipo_via CHAR(2) NOT NULL,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_tipo_via VARCHAR(50) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_tipo_via)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tipos_zonas (
    c_tipo_zona CHAR(2) NOT NULL,
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_tipo_zona VARCHAR(50) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_tipo_zona)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE trabajadores (
    c_trabajador BIGINT NOT NULL AUTO_INCREMENT,
    c_usuario BIGINT,
    c_corte CHAR(2),
    c_unidad_administrativa CHAR(2),
    c_area_administrativa CHAR(3),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_trabajador)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE unidades_administrativas (
    c_unidad_administrativa CHAR(2) NOT NULL,
    c_corte CHAR(2),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    x_unidad_administrativa VARCHAR(100) NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_unidad_administrativa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE usuarios (
    c_usuario BIGINT NOT NULL AUTO_INCREMENT,
    c_tipo_perfil CHAR(2),
    c_tipo_persona CHAR(2),
    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    n_documento VARCHAR(20) NOT NULL,
    x_nombres VARCHAR(100) NOT NULL,
    x_ap_paterno VARCHAR(50) NOT NULL,
    x_ap_materno VARCHAR(50),
    x_correo VARCHAR(100) NOT NULL,
    x_contrasena TEXT NOT NULL,
    l_estado CHAR(1) DEFAULT 'S',
    c_aud INT,
    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
    b_aud CHAR(1) NOT NULL,
    c_aud_uid VARCHAR(30) DEFAULT NULL,
    c_aud_uidred VARCHAR(30),
    c_aud_pc VARCHAR(30),
    n_aud_ip VARCHAR(15),
    c_aud_mcaddr VARCHAR(17),
    PRIMARY KEY (c_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('01', '2026-04-18 21:54:02.195985', 'Corte Suprema', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('02', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Amazonas', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('03', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Ancash', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('04', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Apurimac', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('05', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Arequipa', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('06', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Ayacucho', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('07', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Cajamarca', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('08', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia del Callao', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('09', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Cañete', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('10', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Cusco', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('11', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Huancavelica', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('12', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Huanuco', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('13', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Huaura', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('14', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Ica', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('15', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Junin', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('16', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de La Libertad', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('17', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lambayeque', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('18', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lima', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('19', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lima Este', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('20', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lima Norte', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('21', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Lima Sur', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('22', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Loreto', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('23', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Madre de Dios', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('24', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Moquegua', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('25', '2026-04-18 21:54:02.195985', 'Corte Nacional de Justicia Penal Especializada', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('26', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Pasco', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('27', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Piura', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('28', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Puente Piedra - Ventanilla', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('29', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Puno', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('30', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de San Martín', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('31', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia del Santa', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('32', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de la Selva Central', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('33', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Sullana', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('34', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Tacna', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('35', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Tumbes', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('36', '2026-04-18 21:54:02.195985', 'Corte Superior de Justicia de Ucayali', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO cortes_nacionales (c_corte, f_registro, x_corte, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('37', '2026-04-18 21:54:02.195985', 'Gerencia General', 'S', 1, '2026-04-18 21:54:02.195985', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('01', '2026-04-18 22:01:14.846737', 'AMAZONAS', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('02', '2026-04-18 22:01:14.846737', 'ANCASH', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('03', '2026-04-18 22:01:14.846737', 'APURIMAC', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('04', '2026-04-18 22:01:14.846737', 'AREQUIPA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('05', '2026-04-18 22:01:14.846737', 'AYACUCHO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('06', '2026-04-18 22:01:14.846737', 'CAJAMARCA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('07', '2026-04-18 22:01:14.846737', 'CALLAO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('08', '2026-04-18 22:01:14.846737', 'CUSCO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('09', '2026-04-18 22:01:14.846737', 'HUANCAVELICA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('10', '2026-04-18 22:01:14.846737', 'HUANUCO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('11', '2026-04-18 22:01:14.846737', 'ICA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('12', '2026-04-18 22:01:14.846737', 'JUNIN', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('13', '2026-04-18 22:01:14.846737', 'LA LIBERTAD', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('14', '2026-04-18 22:01:14.846737', 'LAMBAYEQUE', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('15', '2026-04-18 22:01:14.846737', 'LIMA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('16', '2026-04-18 22:01:14.846737', 'LORETO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('17', '2026-04-18 22:01:14.846737', 'MADRE DE DIOS', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('18', '2026-04-18 22:01:14.846737', 'MOQUEGUA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('19', '2026-04-18 22:01:14.846737', 'PASCO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('20', '2026-04-18 22:01:14.846737', 'PIURA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('21', '2026-04-18 22:01:14.846737', 'PUNO', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('22', '2026-04-18 22:01:14.846737', 'SAN MARTIN', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('23', '2026-04-18 22:01:14.846737', 'TACNA', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('24', '2026-04-18 22:01:14.846737', 'TUMBES', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO departamentos (c_departamento, f_registro, x_departamento, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('25', '2026-04-18 22:01:14.846737', 'UCAYALI', 'S', 1, '2026-04-18 22:01:14.846737', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150101', '1501', '2026-04-20 22:16:59.051177', 'LIMA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150102', '1501', '2026-04-20 22:16:59.051177', 'ANCON', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150103', '1501', '2026-04-20 22:16:59.051177', 'ATE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150104', '1501', '2026-04-20 22:16:59.051177', 'BARRANCO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150105', '1501', '2026-04-20 22:16:59.051177', 'BREÑA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150106', '1501', '2026-04-20 22:16:59.051177', 'CARABAYLLO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150107', '1501', '2026-04-20 22:16:59.051177', 'CHACLACAYO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150108', '1501', '2026-04-20 22:16:59.051177', 'CHORRILLOS', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150109', '1501', '2026-04-20 22:16:59.051177', 'CIENEGUILLA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150110', '1501', '2026-04-20 22:16:59.051177', 'COMAS', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150111', '1501', '2026-04-20 22:16:59.051177', 'EL AGUSTINO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150112', '1501', '2026-04-20 22:16:59.051177', 'INDEPENDENCIA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150113', '1501', '2026-04-20 22:16:59.051177', 'JESUS MARIA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150114', '1501', '2026-04-20 22:16:59.051177', 'LA MOLINA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150115', '1501', '2026-04-20 22:16:59.051177', 'LA VICTORIA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150116', '1501', '2026-04-20 22:16:59.051177', 'LINCE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150117', '1501', '2026-04-20 22:16:59.051177', 'LURIGANCHO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150118', '1501', '2026-04-20 22:16:59.051177', 'LURIN', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150119', '1501', '2026-04-20 22:16:59.051177', 'MAGDALENA DEL MAR', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150120', '1501', '2026-04-20 22:16:59.051177', 'PUEBLO LIBRE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150121', '1501', '2026-04-20 22:16:59.051177', 'MIRAFLORES', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150122', '1501', '2026-04-20 22:16:59.051177', 'PACHACAMAC', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150123', '1501', '2026-04-20 22:16:59.051177', 'PUCUSANA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150124', '1501', '2026-04-20 22:16:59.051177', 'PUENTE PIEDRA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150125', '1501', '2026-04-20 22:16:59.051177', 'PUNTA HERMOSA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150126', '1501', '2026-04-20 22:16:59.051177', 'PUNTA NEGRA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150127', '1501', '2026-04-20 22:16:59.051177', 'SAN BARTOLO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150128', '1501', '2026-04-20 22:16:59.051177', 'SAN BORJA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150129', '1501', '2026-04-20 22:16:59.051177', 'SAN ISIDRO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150130', '1501', '2026-04-20 22:16:59.051177', 'SAN JUAN DE LURIGANCHO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150131', '1501', '2026-04-20 22:16:59.051177', 'SAN JUAN DE MIRAFLORES', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150132', '1501', '2026-04-20 22:16:59.051177', 'SAN LUIS', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150133', '1501', '2026-04-20 22:16:59.051177', 'SAN MARTIN DE PORRES', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150134', '1501', '2026-04-20 22:16:59.051177', 'SAN MIGUEL', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150135', '1501', '2026-04-20 22:16:59.051177', 'SANTA ANITA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150136', '1501', '2026-04-20 22:16:59.051177', 'SANTA MARIA DEL MAR', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150137', '1501', '2026-04-20 22:16:59.051177', 'SANTA ROSA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150138', '1501', '2026-04-20 22:16:59.051177', 'SANTIAGO DE SURCO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150139', '1501', '2026-04-20 22:16:59.051177', 'SURQUILLO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150140', '1501', '2026-04-20 22:16:59.051177', 'VILLA EL SALVADOR', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150141', '1501', '2026-04-20 22:16:59.051177', 'VILLA MARIA DEL TRIUNFO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150801', '1508', '2026-04-20 22:16:59.051177', 'HUACHO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150802', '1508', '2026-04-20 22:16:59.051177', 'AMBAR', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150804', '1508', '2026-04-20 22:16:59.051177', 'CALETA DE CARQUIN', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150810', '1508', '2026-04-20 22:16:59.051177', 'SAYAN', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150501', '1505', '2026-04-20 22:16:59.051177', 'SAN VICENTE DE CAÑETE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150502', '1505', '2026-04-20 22:16:59.051177', 'ASIA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150503', '1505', '2026-04-20 22:16:59.051177', 'CALANGO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO distritos (c_distrito, c_provincia, f_registro, x_distrito, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('150508', '1505', '2026-04-20 22:16:59.051177', 'MALA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1501', '15', '2026-04-20 22:16:59.051177', 'LIMA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1502', '15', '2026-04-20 22:16:59.051177', 'BARRANCA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1503', '15', '2026-04-20 22:16:59.051177', 'CAJATAMBO', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1504', '15', '2026-04-20 22:16:59.051177', 'CANTA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1505', '15', '2026-04-20 22:16:59.051177', 'CAÑETE', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1506', '15', '2026-04-20 22:16:59.051177', 'HUARAL', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1507', '15', '2026-04-20 22:16:59.051177', 'HUAROCHIRI', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1508', '15', '2026-04-20 22:16:59.051177', 'HUAURA', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1509', '15', '2026-04-20 22:16:59.051177', 'OYON', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO provincias (c_provincia, c_departamento, f_registro, x_provincia, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('1510', '15', '2026-04-20 22:16:59.051177', 'YAUYOS', 'S', 1, '2026-04-20 22:16:59.051177', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO solicitudes (c_solicitud, c_usuario, c_tipo_via, c_tipo_zona, c_departamento, c_provincia, c_distrito, f_registro, x_via_otro, x_nombre_via, x_zona_otro, x_referencia, x_telefono, x_celular, x_sustentacion, n_tiempo_atencion, n_tiempo_prorroga, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES (1, 2, '01', '01', '15', '1501', '150130', '2026-04-20 22:22:36.658624', NULL, 'PROCERES DE LA INDEPENDENCIA', NULL, 'NUMERO 1596', '2548785', '999999999', 'Solicito información de las prisiones preventivas', 10, 0, 'S', 2, '2026-04-20 22:22:36.658624', 'I', 'postgres', NULL, NULL, '::1', NULL);
INSERT INTO solicitudes_anexos (c_solicitud_anexo, c_solicitud, f_registro, n_secuencia, x_archivo, x_ubicacion, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES (1, 1, '2026-04-20 22:22:36.658624', 1, 'ANEXO 01.pdf', 'uploads/anexos/SOL_1_ANX_1_1776741756.pdf', 'S', 2, '2026-04-20 22:22:36.658624', 'I', 'postgres', NULL, NULL, '::1', NULL);
INSERT INTO solicitudes_ubicaciones (c_solicitud_ubicacion, c_solicitud, c_usuario, c_tipo_solicitud_estado, c_corte, c_unidad_administrativa, c_area_administrativa, f_registro, x_observacion, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES (1, 1, 2, '01', '18', NULL, NULL, '2026-04-20 22:22:36.658624', 'REGISTRO INICIAL POR EL CIUDADANO', 'S', 2, '2026-04-20 22:22:36.658624', 'I', 'postgres', NULL, NULL, '::1', NULL);
INSERT INTO tipos_perfiles (c_tipo_perfil, f_registro, x_tipo_perfil, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('01', '2026-04-18 21:55:26.567403', 'CIUDADANO', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_perfiles (c_tipo_perfil, f_registro, x_tipo_perfil, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('02', '2026-04-18 21:55:26.567403', 'RESPONSABLE TRANSPARENCIA', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_perfiles (c_tipo_perfil, f_registro, x_tipo_perfil, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('03', '2026-04-18 21:55:26.567403', 'JEFE ADMINISTRATIVO', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_perfiles (c_tipo_perfil, f_registro, x_tipo_perfil, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('04', '2026-04-18 21:55:26.567403', 'ASISTENTE ADMINISTRATIVO', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_perfiles (c_tipo_perfil, f_registro, x_tipo_perfil, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('05', '2026-04-18 21:55:26.567403', 'RESPONSABLE ODANC', 'S', 1, '2026-04-18 21:55:26.567403', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_personas (c_tipo_persona, f_registro, x_tipo_persona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('01', '2026-04-18 22:42:17.540049', 'PERSONA NATURAL', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_personas (c_tipo_persona, f_registro, x_tipo_persona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('02', '2026-04-18 22:42:17.540049', 'PERSONA JURIDICA', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_personas (c_tipo_persona, f_registro, x_tipo_persona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('03', '2026-04-18 22:42:17.540049', 'PERSONA EXTRANJERA', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_personas (c_tipo_persona, f_registro, x_tipo_persona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('04', '2026-04-18 22:42:17.540049', 'PERSONA NATURAL CON RUC', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_personas (c_tipo_persona, f_registro, x_tipo_persona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('05', '2026-04-18 22:42:17.540049', 'PERSONA JURIDICA EXTRANJERA', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_personas (c_tipo_persona, f_registro, x_tipo_persona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('06', '2026-04-18 22:42:17.540049', 'TRABAJADOR JUDICIAL', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_solicitud_estados (c_tipo_solicitud_estado, f_registro, x_tipo_solicitud_estado, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('01', '2026-04-18 21:58:28.298469', 'PENDIENTE', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_solicitud_estados (c_tipo_solicitud_estado, f_registro, x_tipo_solicitud_estado, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('02', '2026-04-18 21:58:28.298469', 'EN PROCESO', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_solicitud_estados (c_tipo_solicitud_estado, f_registro, x_tipo_solicitud_estado, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('03', '2026-04-18 21:58:28.298469', 'CON PRÓRROGA', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_solicitud_estados (c_tipo_solicitud_estado, f_registro, x_tipo_solicitud_estado, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('04', '2026-04-18 21:58:28.298469', 'ATENDIDO', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_solicitud_estados (c_tipo_solicitud_estado, f_registro, x_tipo_solicitud_estado, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('05', '2026-04-18 21:58:28.298469', 'VENCIDO', 'S', 1, '2026-04-18 21:58:28.298469', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('01', '2026-04-18 22:01:23.190269', 'AVENIDA', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('02', '2026-04-18 22:01:23.190269', 'JIRÓN', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('03', '2026-04-18 22:01:23.190269', 'CALLE', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('04', '2026-04-18 22:01:23.190269', 'PASAJE', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('05', '2026-04-18 22:01:23.190269', 'CARRETERA', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('06', '2026-04-18 22:01:23.190269', 'PROLONGACIÓN', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('07', '2026-04-18 22:01:23.190269', 'ALAMEDA', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('08', '2026-04-18 22:01:23.190269', 'MALECÓN', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('09', '2026-04-18 22:01:23.190269', 'ÓVALO', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('10', '2026-04-18 22:01:23.190269', 'PARQUE', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_vias (c_tipo_via, f_registro, x_tipo_via, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('11', '2026-04-18 22:01:23.190269', 'OTROS', 'S', 1, '2026-04-18 22:01:23.190269', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('01', '2026-04-18 22:02:28.236438', 'URBANIZACIÓN', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('02', '2026-04-18 22:02:28.236438', 'ASENTAMIENTO HUMANO', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('03', '2026-04-18 22:02:28.236438', 'PUEBLO JOVEN', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('04', '2026-04-18 22:02:28.236438', 'UNIDAD VECINAL', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('05', '2026-04-18 22:02:28.236438', 'CONJUNTO HABITACIONAL', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('06', '2026-04-18 22:02:28.236438', 'COOPERATIVA', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('07', '2026-04-18 22:02:28.236438', 'RESIDENCIAL', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('08', '2026-04-18 22:02:28.236438', 'ASOCIACIÓN', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('09', '2026-04-18 22:02:28.236438', 'GRUPO VIVIENDA', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('10', '2026-04-18 22:02:28.236438', 'ZONA INDUSTRIAL', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO tipos_zonas (c_tipo_zona, f_registro, x_tipo_zona, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES ('11', '2026-04-18 22:02:28.236438', 'OTROS', 'S', 1, '2026-04-18 22:02:28.236438', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO usuarios (c_usuario, c_tipo_perfil, c_tipo_persona, f_registro, n_documento, x_nombres, x_ap_paterno, x_ap_materno, x_correo, x_contrasena, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES (1, '01', '06', '2026-04-18 22:42:17.540049', '12345678', 'Luis', 'Centeno', NULL, 'u18209348@utp.edu.pe', '123456', 'S', 1, '2026-04-18 22:42:17.540049', 'I', 'postgres', NULL, NULL, NULL, NULL);
INSERT INTO usuarios (c_usuario, c_tipo_perfil, c_tipo_persona, f_registro, n_documento, x_nombres, x_ap_paterno, x_ap_materno, x_correo, x_contrasena, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES (2, '01', '01', '2026-04-20 00:13:51.637559', '789456123', 'GABRIEL', 'GONZALES', 'PRADA', 'u18209349@utp.edu.pe', '123456', 'S', 0, '2026-04-20 00:13:51.637559', 'I', 'postgres', NULL, NULL, '::1', NULL);
INSERT INTO usuarios (c_usuario, c_tipo_perfil, c_tipo_persona, f_registro, n_documento, x_nombres, x_ap_paterno, x_ap_materno, x_correo, x_contrasena, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES (3, '01', '01', '2026-04-20 00:14:45.719119', '789456123', 'JULIO', 'PORTOCARRERO', 'GUTIERREZ', 'u18209350@utp.edu.pe', '123456', 'S', 0, '2026-04-20 00:14:45.719119', 'I', 'postgres', NULL, NULL, '::1', NULL);
INSERT INTO usuarios (c_usuario, c_tipo_perfil, c_tipo_persona, f_registro, n_documento, x_nombres, x_ap_paterno, x_ap_materno, x_correo, x_contrasena, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr) VALUES (4, '01', '01', '2026-04-20 00:15:09.886009', '789456123', 'MANUEL', 'QUIROZ', 'LOPEZ', 'u18209351@utp.edu.pe', '123456', 'S', 0, '2026-04-20 00:15:09.886009', 'I', 'postgres', NULL, NULL, '::1', NULL);
ALTER TABLE usuarios
    ADD CONSTRAINT usuarios_x_correo_key UNIQUE (x_correo);

ALTER TABLE areas_administrativas
    ADD CONSTRAINT areas_administrativas_c_unidad_administrativa_fkey FOREIGN KEY (c_unidad_administrativa) REFERENCES unidades_administrativas(c_unidad_administrativa);

ALTER TABLE distritos
    ADD CONSTRAINT distritos_c_provincia_fkey FOREIGN KEY (c_provincia) REFERENCES provincias(c_provincia);

ALTER TABLE provincias
    ADD CONSTRAINT provincias_c_departamento_fkey FOREIGN KEY (c_departamento) REFERENCES departamentos(c_departamento);

ALTER TABLE recuperaciones_contrasenas
    ADD CONSTRAINT recuperaciones_contrasenas_c_usuario_fkey FOREIGN KEY (c_usuario) REFERENCES usuarios(c_usuario);

ALTER TABLE solicitudes_anexos
    ADD CONSTRAINT solicitudes_anexos_c_solicitud_fkey FOREIGN KEY (c_solicitud) REFERENCES solicitudes(c_solicitud);

ALTER TABLE solicitudes
    ADD CONSTRAINT solicitudes_c_departamento_fkey FOREIGN KEY (c_departamento) REFERENCES departamentos(c_departamento);

ALTER TABLE solicitudes
    ADD CONSTRAINT solicitudes_c_distrito_fkey FOREIGN KEY (c_distrito) REFERENCES distritos(c_distrito);

ALTER TABLE solicitudes
    ADD CONSTRAINT solicitudes_c_provincia_fkey FOREIGN KEY (c_provincia) REFERENCES provincias(c_provincia);

ALTER TABLE solicitudes
    ADD CONSTRAINT solicitudes_c_tipo_via_fkey FOREIGN KEY (c_tipo_via) REFERENCES tipos_vias(c_tipo_via);

ALTER TABLE solicitudes
    ADD CONSTRAINT solicitudes_c_tipo_zona_fkey FOREIGN KEY (c_tipo_zona) REFERENCES tipos_zonas(c_tipo_zona);

ALTER TABLE solicitudes
    ADD CONSTRAINT solicitudes_c_usuario_fkey FOREIGN KEY (c_usuario) REFERENCES usuarios(c_usuario);

ALTER TABLE solicitudes_reiterativos
    ADD CONSTRAINT solicitudes_reiterativos_c_area_administrativa_fkey FOREIGN KEY (c_area_administrativa) REFERENCES areas_administrativas(c_area_administrativa);

ALTER TABLE solicitudes_reiterativos
    ADD CONSTRAINT solicitudes_reiterativos_c_corte_fkey FOREIGN KEY (c_corte) REFERENCES cortes_nacionales(c_corte);

ALTER TABLE solicitudes_reiterativos
    ADD CONSTRAINT solicitudes_reiterativos_c_solicitud_fkey FOREIGN KEY (c_solicitud) REFERENCES solicitudes(c_solicitud);

ALTER TABLE solicitudes_reiterativos
    ADD CONSTRAINT solicitudes_reiterativos_c_tipo_solicitud_estado_fkey FOREIGN KEY (c_tipo_solicitud_estado) REFERENCES tipos_solicitud_estados(c_tipo_solicitud_estado);

ALTER TABLE solicitudes_reiterativos
    ADD CONSTRAINT solicitudes_reiterativos_c_unidad_administrativa_fkey FOREIGN KEY (c_unidad_administrativa) REFERENCES unidades_administrativas(c_unidad_administrativa);

ALTER TABLE solicitudes_reiterativos
    ADD CONSTRAINT solicitudes_reiterativos_c_usuario_fkey FOREIGN KEY (c_usuario) REFERENCES usuarios(c_usuario);

ALTER TABLE solicitudes_respuestas
    ADD CONSTRAINT solicitudes_respuestas_c_solicitud_fkey FOREIGN KEY (c_solicitud) REFERENCES solicitudes(c_solicitud);

ALTER TABLE solicitudes_respuestas
    ADD CONSTRAINT solicitudes_respuestas_c_solicitud_ubicacion_fkey FOREIGN KEY (c_solicitud_ubicacion) REFERENCES solicitudes_ubicaciones(c_solicitud_ubicacion);

ALTER TABLE solicitudes_ubicaciones
    ADD CONSTRAINT solicitudes_ubicaciones_c_area_administrativa_fkey FOREIGN KEY (c_area_administrativa) REFERENCES areas_administrativas(c_area_administrativa);

ALTER TABLE solicitudes_ubicaciones
    ADD CONSTRAINT solicitudes_ubicaciones_c_corte_fkey FOREIGN KEY (c_corte) REFERENCES cortes_nacionales(c_corte);

ALTER TABLE solicitudes_ubicaciones
    ADD CONSTRAINT solicitudes_ubicaciones_c_solicitud_fkey FOREIGN KEY (c_solicitud) REFERENCES solicitudes(c_solicitud);

ALTER TABLE solicitudes_ubicaciones
    ADD CONSTRAINT solicitudes_ubicaciones_c_tipo_solicitud_estado_fkey FOREIGN KEY (c_tipo_solicitud_estado) REFERENCES tipos_solicitud_estados(c_tipo_solicitud_estado);

ALTER TABLE solicitudes_ubicaciones
    ADD CONSTRAINT solicitudes_ubicaciones_c_unidad_administrativa_fkey FOREIGN KEY (c_unidad_administrativa) REFERENCES unidades_administrativas(c_unidad_administrativa);

ALTER TABLE solicitudes_ubicaciones
    ADD CONSTRAINT solicitudes_ubicaciones_c_usuario_fkey FOREIGN KEY (c_usuario) REFERENCES usuarios(c_usuario);

ALTER TABLE trabajadores
    ADD CONSTRAINT trabajadores_c_area_administrativa_fkey FOREIGN KEY (c_area_administrativa) REFERENCES areas_administrativas(c_area_administrativa);

ALTER TABLE trabajadores
    ADD CONSTRAINT trabajadores_c_corte_fkey FOREIGN KEY (c_corte) REFERENCES cortes_nacionales(c_corte);

ALTER TABLE trabajadores
    ADD CONSTRAINT trabajadores_c_unidad_administrativa_fkey FOREIGN KEY (c_unidad_administrativa) REFERENCES unidades_administrativas(c_unidad_administrativa);

ALTER TABLE trabajadores
    ADD CONSTRAINT trabajadores_c_usuario_fkey FOREIGN KEY (c_usuario) REFERENCES usuarios(c_usuario);

ALTER TABLE unidades_administrativas
    ADD CONSTRAINT unidades_administrativas_c_corte_fkey FOREIGN KEY (c_corte) REFERENCES cortes_nacionales(c_corte);

ALTER TABLE usuarios
    ADD CONSTRAINT usuarios_c_tipo_perfil_fkey FOREIGN KEY (c_tipo_perfil) REFERENCES tipos_perfiles(c_tipo_perfil);

ALTER TABLE usuarios
    ADD CONSTRAINT usuarios_c_tipo_persona_fkey FOREIGN KEY (c_tipo_persona) REFERENCES tipos_personas(c_tipo_persona);

SET FOREIGN_KEY_CHECKS=1;

-- Perfiles y usuarios adicionales para pruebas en dashboard
USE casillatransparencia;

INSERT IGNORE INTO tipos_perfiles
(c_tipo_perfil, f_registro, x_tipo_perfil, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr)
VALUES
('06', NOW(6), 'TECNICO DE ARCHIVO', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, NULL, NULL),
('07', NOW(6), 'MESA DE PARTES', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, NULL, NULL),
('08', NOW(6), 'SUPERVISOR GENERAL', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, NULL, NULL),
('09', NOW(6), 'AUDITOR DE PLAZOS', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, NULL, NULL),
('10', NOW(6), 'ADMINISTRADOR DEL SISTEMA', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, NULL, NULL);

INSERT IGNORE INTO usuarios
(c_usuario, c_tipo_perfil, c_tipo_persona, f_registro, n_documento, x_nombres, x_ap_paterno, x_ap_materno, x_correo, x_contrasena, l_estado, c_aud, f_aud, b_aud, c_aud_uid, c_aud_uidred, c_aud_pc, n_aud_ip, c_aud_mcaddr)
VALUES
(5, '02', '06', NOW(6), '20000002', 'RESPONSABLE', 'TRANSPARENCIA', NULL, 'responsable@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(6, '03', '06', NOW(6), '20000003', 'JEFE', 'ADMINISTRATIVO', NULL, 'jefe@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(7, '04', '06', NOW(6), '20000004', 'ASISTENTE', 'ADMINISTRATIVO', NULL, 'asistente@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(8, '05', '06', NOW(6), '20000005', 'RESPONSABLE', 'ODANC', NULL, 'odanc@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(9, '06', '06', NOW(6), '20000006', 'TECNICO', 'ARCHIVO', NULL, 'archivo@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(10, '07', '06', NOW(6), '20000007', 'MESA', 'PARTES', NULL, 'mesa@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(11, '08', '06', NOW(6), '20000008', 'SUPERVISOR', 'GENERAL', NULL, 'supervisor@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(12, '09', '06', NOW(6), '20000009', 'AUDITOR', 'PLAZOS', NULL, 'auditor@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL),
(13, '10', '06', NOW(6), '20000010', 'ADMINISTRADOR', 'SISTEMA', NULL, 'admin@pj.gob.pe', '123456', 'S', 1, NOW(6), 'I', 'root', NULL, NULL, '127.0.0.1', NULL);


