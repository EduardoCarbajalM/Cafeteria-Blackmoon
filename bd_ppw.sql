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