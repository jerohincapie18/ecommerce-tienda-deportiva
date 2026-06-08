QUERYS:

CREATE DATABASE users_db

USE users_db

CREATE TABLE productos (
    id INT AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    imagen_url VARCHAR(255) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    es_carrusel TINYINT(1) DEFAULT 0, --1 para mostrarla, 0 para no
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    CONSTRAINT pk_productos PRIMARY KEY (id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    contrasena VARCHAR(100) NOT NULL,
    rol VARCHAR(25) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    CONSTRAINT pk_users PRIMARY KEY (id)
)