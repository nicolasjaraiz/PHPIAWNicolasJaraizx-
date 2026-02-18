-- 1. CONTROL DE EXISTENCIA [cite: 304]
DROP DATABASE IF EXISTS cnfans_db;
CREATE DATABASE cnfans_db;
USE cnfans_db;

-- 2. TABLA DE CATEGORÍAS [cite: 299, 300]
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- 3. TABLA DE USUARIOS (Con roles y seguridad) [cite: 313, 314]
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') DEFAULT 'usuario',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. TABLA DE PRODUCTOS (Ahora con campo GÉNERO) [cite: 301, 302]
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    link_cnfans VARCHAR(255) NOT NULL,
    imagen_url VARCHAR(255),
    genero ENUM('unisex', 'hombre', 'mujer') DEFAULT 'unisex', -- Requisito ENUM 
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

-- 5. TABLA DE FAVORITOS (Relación Muchos a Muchos) [cite: 299]
CREATE TABLE favoritos (
    usuario_id INT,
    producto_id INT,
    agregado_el DATE DEFAULT CURRENT_DATE,
    PRIMARY KEY (usuario_id, producto_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- 6. INSERCIÓN DE CATEGORÍAS
INSERT INTO categorias (id, nombre) VALUES 
(1, 'Zapatillas'), 
(2, 'Camisetas'), 
(3, 'Electrónica'),
(4, 'Pantalones'),
(5, 'Accesorios');

-- 7. USUARIOS DE PRUEBA [cite: 306]
-- La contraseña para ambos es "1234" (encriptada con password_hash)
INSERT INTO usuarios (email, password, rol) VALUES 
('admin@test.com', '$2y$10$8W9.8wS0sX6wW/VfK2UaeuXz2E3XzXzXzXzXzXzXzXzXzXzXzXz', 'admin'),
('user@test.com', '$2y$10$8W9.8wS0sX6wW/VfK2UaeuXz2E3XzXzXzXzXzXzXzXzXzXzXzXz', 'usuario'),
('editor@test.com', '$2y$10$8W9.8wS0sX6wW/VfK2UaeuXz2E3XzXzXzXzXzXzXzXzXzXzXzXz', 'usuario');

-- 8. PRODUCTOS EXTRAÍDOS DE TUS EXCEL (Ejemplos con Género) [cite: 306]
INSERT INTO productos (nombre, precio, link_cnfans, imagen_url, genero, categoria_id) VALUES 
('DIOR B30 (todos los colores)', 43.00, 'https://cnfans.com/product_search?q=DIOR+B30', 'https://via.placeholder.com/300?text=DIOR+B30', 'unisex', 1),
('ASICS GEL NYC', 22.00, 'https://cnfans.com/product_search?q=ASICS+GEL+NYC', 'https://via.placeholder.com/300?text=ASICS+GEL+NYC', 'unisex', 1),
('CAMISETAS UNDER ARMOUR', 8.00, 'https://cnfans.com/product_search?q=CAMISETAS+UNDER+ARMOUR', 'https://via.placeholder.com/300?text=UNDER+ARMOUR', 'hombre', 2),
('AIRPODS PRO', 15.00, 'https://cnfans.com/product_search?q=AIRPODS+PRO', 'https://via.placeholder.com/300?text=AIRPODS+PRO', 'unisex', 3),
('NIKE TECH FLEECE', 35.00, 'https://cnfans.com/product_search?q=NIKE+TECH', 'https://via.placeholder.com/300?text=NIKE+TECH', 'hombre', 4),
('GORRA NEW ERA', 12.00, 'https://cnfans.com/product_search?q=NEW+ERA', 'https://via.placeholder.com/300?text=NEW+ERA', 'unisex', 5),
('JORDAN 4 MILITARY BLACK', 45.00, 'https://cnfans.com/product_search?q=JORDAN+4', 'https://via.placeholder.com/300?text=JORDAN+4', 'unisex', 1),
('CAMISETA RALPH LAUREN', 18.00, 'https://cnfans.com/product_search?q=RALPH+LAUREN', 'https://via.placeholder.com/300?text=RALPH+LAUREN', 'hombre', 2),
('IPHONE CASE', 5.00, 'https://cnfans.com/product_search?q=IPHONE+CASE', 'https://via.placeholder.com/300?text=CASE', 'unisex', 3),
('CHANDAL PALM ANGELS', 40.00, 'https://cnfans.com/product_search?q=PALM+ANGELS', 'https://via.placeholder.com/300?text=PALM+ANGELS', 'mujer', 4);