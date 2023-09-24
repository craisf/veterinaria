DROP DATABASE IF EXISTS dbveterinaria;

CREATE DATABASE dbveterinaria;

USE dbveterinaria;

CREATE TABLE cliente
(
idcliente 		INT PRIMARY KEY AUTO_INCREMENT,
apellidos		VARCHAR(40)		NOT NULL,
nombres			VARCHAR(40) 	NOT NULL,
dni				CHAR(8)			NOT NULL,
claveacceso		VARCHAR(200) 	NOT NULL
)ENGINE = INNODB;

CREATE TABLE animales
(
idanimal INT PRIMARY KEY AUTO_INCREMENT,
nombre_animal	VARCHAR(30)
)ENGINE=INNODB;


CREATE TABLE razas
(
idraza			INT PRIMARY KEY AUTO_INCREMENT,
idanimal		INT 	NOT NULL,
nombre_raza		VARCHAR(20) NOT NULL
)ENGINE=INNODB;


CREATE TABLE mascotas
(
idmascota		INT PRIMARY KEY AUTO_INCREMENT,
idcliente		INT 	NOT NULL,
idraza			INT 	NOT NULL,
nombre			VARCHAR(20) NOT NULL,
fotografia		VARCHAR(400)NULL,
color				VARCHAR(20)	NOT NULL,
genero			CHAR(1)		NOT NULL, -- M/H
CONSTRAINT fk_idcliente_tb FOREIGN KEY (idcliente) REFERENCES cliente (idcliente),
CONSTRAINT fk_idraza_tb FOREIGN KEY (idraza) REFERENCES razas (idraza)
)ENGINE=INNODB;

INSERT INTO cliente (apellidos, nombres, dni, claveacceso) VALUES
('Moran','Carlos','71594314','$2y$10$j.U0As3zmAyW/05ylfEchuhEaUb7iMdyscOhPznMVc88FOg9pvsnC'),
('Gonzales','Pier','12345678','$2y$10$j.U0As3zmAyW/05ylfEchuhEaUb7iMdyscOhPznMVc88FOg9pvsnC'),
('Mejia','Juan','96385274','$2y$10$j.U0As3zmAyW/05ylfEchuhEaUb7iMdyscOhPznMVc88FOg9pvsnC');


INSERT INTO animales (nombre_animal) VALUES
('Perro'),
('Gato'),
('Pez');

INSERT INTO razas (idanimal, nombre_raza) VALUES 
(1,'Bull Terrier'),
(1,'Bulldog francés'),
(2,'Gato siberiano'),
(2,'Gato birmano'),
(3,'Pez ángel'),
(4,'Pez cebra');

INSERT INTO mascotas (idcliente, idraza, nombre,color, genero) VALUES 
(1,1,'KEMBA','negro y blanco','M'),
(2,3,'ASTA','blanco y gris','M'),
(3,5,'PEZI','rojo','M');

SELECT * FROM cliente
SELECT * FROM animales
SELECT * FROM razas
SELECT * FROM mascotas



-- registrar mascota
DELIMITER $$
CREATE PROCEDURE spu_mascotas_add(
IN _idcliente INT,
IN _idraza INT,
IN _nombre VARCHAR(20),
IN _color VARCHAR(20),
IN _genero CHAR(1)
)
BEGIN
INSERT INTO mascotas (idcliente, idraza, nombre,color, genero) VALUES 
(_idcliente,_idraza,_nombre,_color,_genero);
END $$

-- registrar cleinte
DELIMITER $$
CREATE PROCEDURE spu_clientes_add(
IN _apellidos VARCHAR(30),
IN _nombres VARCHAR(20),
IN _dni VARCHAR(9),
IN _claveacceso VARCHAR(200)
)
BEGIN
INSERT INTO cliente (apellidos, nombres, dni, claveacceso) VALUES
(_apellidos,_nombres,_dni,_claveacceso);
END $$

-- 
DELIMITER $$
CREATE PROCEDURE spu_consultar_cliente(IN _dni CHAR(9))
BEGIN
SELECT CONCAT(cliente.`apellidos`,', ',cliente.`nombres`) AS Dueño, razas.nombre_raza,
mascotas.`nombre`
FROM cliente
INNER JOIN mascotas ON mascotas.`idcliente` = cliente.`idcliente`
INNER JOIN razas ON razas.idraza = mascotas.`idraza`
WHERE cliente.`dni`=_dni;
END $$
-- 
DELIMITER $$
CREATE PROCEDURE spu_consultar_mascotas(IN _idmascota CHAR(9))
BEGIN
SELECT  animales.nombre_animal,razas.nombre_raza,mascotas.`nombre`, mascotas.`fotografia`, mascotas.`color`, mascotas.`genero`
FROM cliente
INNER JOIN mascotas ON mascotas.`idcliente` = cliente.`idcliente`
INNER JOIN razas ON razas.idraza = mascotas.`idraza`
INNER JOIN animales ON animales.idanimal = razas.idanimal
WHERE mascotas.`idmascota` = _idmascota;
END $$


DELIMITER $$
CREATE PROCEDURE spu_login(IN _dni CHAR(8))
BEGIN 
SELECT * FROM usuarios
WHERE dni = _dni;
END $$

CALL spu_consultar_mascotas()

