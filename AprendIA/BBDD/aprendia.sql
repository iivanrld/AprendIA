CREATE DATABASE IF NOT EXISTS aprendia;

USE aprendia;

-- Tabla para usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(191) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('alumno', 'docente', 'admin') DEFAULT 'alumno',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para registrar preguntas y respuestas personalizadas
CREATE TABLE user_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    modulo VARCHAR(191) NOT NULL,
    tema VARCHAR(191) NOT NULL,
    materia VARCHAR(191) NOT NULL,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);

-- Tabla para registrar el progreso del alumno
CREATE TABLE progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    curso VARCHAR(191) NOT NULL,
    modulo VARCHAR(191) NOT NULL,
    tema VARCHAR(191) NOT NULL,
    materia VARCHAR(191) NOT NULL,
    estado ENUM('pendiente', 'aprobado', 'desaprobado') DEFAULT 'pendiente',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);

-- Tabla para almacenar cache de contenidos generados
CREATE TABLE cache_contenidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modulo VARCHAR(191) NOT NULL,
    tema VARCHAR(191) NOT NULL,
    materia VARCHAR(191) NOT NULL,
    prompt TEXT NOT NULL,
    respuesta TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para registrar cursos disponibles
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(191) NOT NULL,
    descripcion TEXT,
    creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para módulos de cada curso
CREATE TABLE modulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    nombre VARCHAR(191) NOT NULL,
    descripcion TEXT,
    orden INT DEFAULT 0,
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);

-- Tabla para temas dentro de módulos
CREATE TABLE temas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modulo_id INT NOT NULL,
    nombre VARCHAR(191) NOT NULL,
    descripcion TEXT,
    prompt TEXT,
    orden INT DEFAULT 0,
    FOREIGN KEY (modulo_id) REFERENCES modulos(id)
);

-- Tabla para materias dentro de temas
CREATE TABLE materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tema_id INT NOT NULL,
    titulo VARCHAR(191) NOT NULL,
    tipo ENUM('teoria', 'practica') DEFAULT 'teoria',
    nivel ENUM('principiante', 'intermedio', 'avanzado') DEFAULT 'principiante',
    orden INT DEFAULT 0,
    FOREIGN KEY (tema_id) REFERENCES temas(id)
);

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Administrador del Sistema', 'admin@aprendia.com', '$2y$10$LoTV//Ezuuz4DEbdbShOdOd1uxCuvdp.SfTFi8IbnYNDoFK/VBQFu', 'admin', '2025-03-26 20:35:52'),
(2, 'Profesor de Programación', 'docente@aprendia.com', '$2y$10$43jyxxI5nkybZNrDllISrOF9mukG9SSlN8aX.UNavKAafjRDXVMkK', 'docente', '2025-03-26 20:35:52'),
(3, 'Juan', 'juan@ejemplo.com', '$2y$10$0gPMopgjRuBIJ9jJqdTXbOMGK6.9aA/PZyZ.6U8ZcJD2BxKvhaGES', 'alumno', '2025-03-26 20:36:57');
COMMIT;
