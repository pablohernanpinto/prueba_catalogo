CREATE DATABASE IF NOT EXISTS fonda;

CREATE USER 'fonda_user'@'localhost' IDENTIFIED BY '123';
-- Dar permisos al usuario sobre la base fonda
GRANT SELECT, INSERT, UPDATE, DELETE ON fonda.* TO 'fonda_user'@'localhost';

-- Aplicar los cambios de permisos
FLUSH PRIVILEGES;

USE fonda;


CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio INT(10) NOT NULL,
    imagen VARCHAR(255) DEFAULT 'default.png'
);
