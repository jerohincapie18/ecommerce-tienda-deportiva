-- ============================================================
--  Khella - Tienda Deportiva
--  Script de instalación de la base de datos (MySQL / MariaDB)
--
--  Uso en terminal:
--      sudo mariadb -u root -p < database.sql
--  Uso en phpMyAdmin:
--      Importar > seleccionar este archivo > Continuar
-- ============================================================
--
--  ATENCIÓN: este script borra las tablas si ya existen.
--  Solo es para una instalación desde cero (base local de desarrollo).
-- ============================================================

CREATE DATABASE IF NOT EXISTS users_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE users_db;

-- ------------------------------------------------------------
--  Productos
-- ------------------------------------------------------------
DROP TABLE IF EXISTS favoritos;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS users;

CREATE TABLE productos (
    id            INT AUTO_INCREMENT,
    nombre        VARCHAR(150)     NOT NULL,
    descripcion   TEXT,
    precio        DECIMAL(10, 2)   NOT NULL,
    stock         INT              NOT NULL DEFAULT 0,
    imagen_url    VARCHAR(255)     NOT NULL,
    categoria     VARCHAR(50)      NOT NULL,
    es_carrusel   TINYINT(1)       DEFAULT 0,
    fecha_creacion TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_productos PRIMARY KEY (id)
);

-- ------------------------------------------------------------
--  Usuarios  (rol = 'user' | 'admin')
-- ------------------------------------------------------------
CREATE TABLE users (
    id             INT AUTO_INCREMENT,
    nombre         VARCHAR(100) NOT NULL,
    email          VARCHAR(100) NOT NULL,
    contrasena     VARCHAR(255) NOT NULL,   -- hash bcrypt (password_hash)
    rol            VARCHAR(25)  NOT NULL DEFAULT 'user',
    fecha_creacion TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_users PRIMARY KEY (id),
    UNIQUE KEY uk_users_email (email)
);

-- ------------------------------------------------------------
--  Favoritos
-- ------------------------------------------------------------
CREATE TABLE favoritos (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT NOT NULL,
    producto_id     INT NOT NULL,
    fecha_agregado  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY usuario_producto (user_id, producto_id),
    FOREIGN KEY (user_id)     REFERENCES users(id)     ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- ============================================================
--  Datos iniciales
-- ============================================================

--  Cuenta de administrador
--  usuario: admin@khella.com   contraseña: admin123
--  (cambiar la contraseña desde el panel de usuario al primer ingreso)
INSERT INTO users (nombre, email, contrasena, rol) VALUES
('Administrador', 'admin@khella.com', '$2y$12$WswPoWQ0NApZje1epPW/ju8/lqO31pAVBbICKG5FN6ihDsZqivCza', 'admin');

--  Productos de ejemplo.
--  Estas imágenes son archivos del propio repo; al crear productos desde
--  el panel de admin las imágenes se guardan en backend/uploads/ y la URL
--  queda como /ecommerce-tienda-deportiva/backend/uploads/<archivo>.
INSERT INTO productos (nombre, descripcion, precio, stock, imagen_url, categoria) VALUES
('Camiseta deportiva',   'Camiseta de algodón con estampado del equipo',        120000.00, 25, '/ecommerce-tienda-deportiva/frontend/assets/img/man.jpg',      'hombre'),
('Chaqueta urbana',       'Chaqueta liviana resistente al viento',              250000.00, 12, '/ecommerce-tienda-deportiva/frontend/assets/img/banner.jpg',    'hombre'),
('Tenis running',         'Tenis-AMortiguado para running',                      300000.00, 18, '/ecommerce-tienda-deportiva/frontend/assets/img/mar.jpg',      'hombre'),
('Balón de fútbol',       'Balón de entrenamiento talla 5',                       80000.00, 40, '/ecommerce-tienda-deportiva/frontend/assets/img/logo2.jpg',    'hombre'),
('Camiseta fitness',      'Camiseta deportiva manga corta',                     115000.00, 30, '/ecommerce-tienda-deportiva/frontend/assets/img/women.jpg',    'mujer'),
('Chaqueta impermeable',  'Chaqueta impermeable para clima frío',                260000.00, 10, '/ecommerce-tienda-deportiva/frontend/assets/img/bannerdos.jpg','mujer'),
('Set deportivo',         'Set de camiseta y pantalón para entrenamiento',      190000.00, 22, '/ecommerce-tienda-deportiva/frontend/assets/img/profilepic.png','mujer'),
('Zapatillas urbanas',    'Zapatillas suela de goma para uso diario',            310000.00, 15, '/ecommerce-tienda-deportiva/frontend/assets/img/logo.png',     'mujer');
