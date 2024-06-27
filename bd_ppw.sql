CREATE DATABASE programacionweb;

USE programacionweb;

CREATE TABLE usuarios (
    ID int NOT NULL AUTO_INCREMENT,
    Nombre VARCHAR(20) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Correo VARCHAR(50) NOT NULL,
    saldo DOUBLE,
    Administrador BOOLEAN NOT NULL,
    PRIMARY KEY (ID),
    UNIQUE (Nombre),
    UNIQUE (Correo)
);

INSERT INTO usuarios (Nombre, Password, Correo, saldo, Administrador)
VALUES ('admin', 'sudo', 'admin@ejemplo.com', 0, TRUE);


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
VALUES ('Expreso', 'Shot de expreso colombiano', 'Bebidas', 20, 30.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Capuchino', 'Shot doble de expreso con leche endulsado con stevia', 'Bebidas', 20, 30.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Tisana de moras', 'Infusión de moras silvestres servido con frutos secos', 'Bebidas', 20, 35.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Frappé', 'Frappe de caramelo', 'Bebidas', 20, 30.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Baguette', 'Baguette con pechuga de pavo y queso manchego', 'Complementos', 20, 50.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Ensalada Cesar', 'ensalada cesar con pollo y parmesano', 'Complementos', 20, 40.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Pasta Alfredo', 'Salsa Alfredo con pechuga asada y sasonada con especias', 'Complementos', 20, 55.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Tarta de Chocolate', 'Deliciosa tarta de chocolate semiamargo con almendras', 'Momentos Dulces', 20, 65.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Pastel de mocha', 'pan de café co relleno de chocolate', 'Momentos Dulces', 20, 65.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Flan', 'flan de vainilla con caramelo', 'Momentos Dulces', 20, 40.00);

INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio)
VALUES ('Pay de limón', 'Mouse de limon con una base de galleta', 'Momentos Dulces', 20, 50.00);


SELECT * FROM usuarios;
SELECT * FROM productos;
