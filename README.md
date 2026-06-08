OJO AL HACER PUSH, RECUERDEN QUE CUANDO HAGAN 'git add' NO PONGAN LA CARPETA DE backend/
* **`backend/`**: Tiene la conexion LOCAL a la base de datos, no suban eso aun asi visual se los marque como modified
* Otra nota: el carrusel esta roto lol

QUERYS:

CREATE DATABASE users_db;

USE users_db;
CREATE TABLE productos (
    id INT AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    imagen_url VARCHAR(255) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    es_carrusel TINYINT(1) DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_productos PRIMARY KEY (id)
);

USE users_db;
CREATE TABLE users (
    id INT AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    contrasena VARCHAR(100) NOT NULL,
    rol VARCHAR(25) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_users PRIMARY KEY (id)
);

USE users_db;
CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    producto_id INT NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY usuario_producto (user_id, producto_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

INSERTAR CONTENIDO:


USE users_db;
INSERT INTO productos (nombre, descripcion, precio, imagen_url, categoria) VALUES
('camisetta', 'coloimva', 200000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a717c6ae0diaz1.png', 'hombre'),
('camiseta 2', 'luis diaz', 2000000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a72535681diaz2.png', 'hombre'),
('perro', 'perrro', 2100000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a72d617b4perro1.png', 'hombre'),
('gato ropa', 'roa', 2100000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a736f375dperro2.png', 'mujer'),
('zapato', 'tenis', 500000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a75c791edtenis4.png', 'mujer'),
('champions balon', 'balon', 12341.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a76782f34balon1.png', 'hombre'),
('balon mundial', '1234', 99999999.99, '/ecommerce-tienda-deportiva/backend/uploads/6a26a77209290balon3.png', 'hombre'),
('perro negro', 'hola1', 12444.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a77a520f2perro3.png', 'hombre'),
('camiseta vlanca', 'camiseta color bmalc', 12345677.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a78ad3a18camiseta1.png', 'mujer'),
('campus', 'tenis camots', 5000000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a26a7b1c983ftenis3.png', 'hombre'),
('balon ucl', 'balon de futbol', 200000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a271bf1b6626balon2.png', 'hombre'),
('guayos', 'guayo 1', 20000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a271c0fd270aguayo1.png', 'hombre'),
('messi', 'mesi', 200000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a271c1de9828messi.png', 'hombre'),
('zapato mujer', 'zapato cafe', 120000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a271c34dd3f3tenis2.png', 'mujer'),
('zapato de correr', 'asd124', 200000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a271c4a9d170teni1.png', 'mujer'),
('chaqutea', 'chaqueta para mujer', 200000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a2730c2cc896Captura de pantalla 2026-06-08 161013.png', 'mujer'),
('zapato', 'para correr', 200000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a2730d2ccfa7Captura de pantalla 2026-06-08 161109.png', 'mujer'),
('rosado', 'hola', 123456.00, '/ecommerce-tienda-deportiva/backend/uploads/6a2730eb9297aCaptura de pantalla 2026-06-08 161127.png', 'mujer'),
('perrubi', 'holiwi', 400000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a2730f994163Captura de pantalla 2026-06-08 161201.png', 'mujer'),
('chaqueta mujer 2', 'hola', 500000.00, '/ecommerce-tienda-deportiva/backend/uploads/6a27310605db1Captura de pantalla 2026-06-08 161045.png', 'mujer');
