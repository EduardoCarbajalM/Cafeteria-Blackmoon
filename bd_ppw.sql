CREATE DATABASE programacionweb;

USE programacionweb;

CREATE TABLE usuarios (
    ID int NOT NULL AUTO_INCREMENT,
    Nombre VARCHAR(20) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    Correo VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID),
    UNIQUE (Nombre),
    UNIQUE (Correo)
);

/*
INSERT INTO usuarios (Nombre, Contraseña, Correo) VALUES 
('Eduardo', '$2y$10$E9F6TqxwFfI4K7a.e/yxCeOE3aYYnntVo1GgPj5ZOMw9W4XZKxgWm', 'ecarbajal@gmail.com'),
('Grecia', '$2y$10$7P7qAiy23JTCmy7uO2n2TeWf9K6PQYqcsA4N8yF3t1XGybhk5A0.e', 'grecia@gmail.com'),
('Diana', '$2y$10$F/ew1VOXUayzQeH1ufF/zOS0CnbJWXsDJyMtc90z0M4mr/vkHcBoS', 'diana@gmail.com'),
('Sara', '$2y$10$ybZ/mW0QW5HdF5/yYlx2UeRxFQmT7rPdGy8fEZZ2U6lB4X8ZZkmKO', 'sara@gmail.com');
*/

-- DROP TABLE usuarios;

SELECT * FROM usuarios;


CREATE TABLE productos (
	ID_producto INT NOT NULL AUTO_INCREMENT,
    Titulo VARCHAR(30) NOT NULL,
    Descripcion VARCHAR(150) NOT NULL,
    Catalogo VARCHAR(25) NOT NULL,
    Cantidad INT NOT NULL,
    Precio DOUBLE NOT NULL,
	PRIMARY KEY (ID_producto)
);

SELECT * FROM productos;

-- DROP TABLE productos;

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Café Latte', 'Delicioso café con leche caliente', 'Bebidas', 10, 45.00),
       ('Jugo Natural de Naranja', 'Refrescante jugo de naranja recién exprimido', 'Bebidas', 15, 30.00),
       ('Té Helado de Durazno', 'Té negro infusionado con sabor a durazno y servido sobre hielo', 'Bebidas', 8, 35.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Ensalada César', 'Ensalada fresca con aderezo especial', 'Complementos', 12, 50.00),
       ('Papas Fritas con Queso', 'Papas fritas crujientes cubiertas con queso derretido', 'Complementos', 20, 40.00),
       ('Sopa de Tortilla', 'Sopa tradicional mexicana con tortillas crujientes y aguacate', 'Complementos', 10, 55.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Tarta de Chocolate', 'Deliciosa tarta de chocolate negro', 'Momentos Dulces', 5, 65.00),
       ('Helado de Vainilla', 'Helado cremoso con sabor a vainilla', 'Momentos Dulces', 18, 40.00),
       ('Churros con Chocolate', 'Churros crujientes acompañados de chocolate caliente', 'Momentos Dulces', 7, 50.00);

ALTER TABLE productos ADD ImagenURL VARCHAR(255);
