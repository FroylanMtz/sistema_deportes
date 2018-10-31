DROP DATABASE IF EXISTS sistema_deportes;

CREATE DATABASE IF NOT EXISTS sistema_deportes;

USE sistema_deportes;

CREATE TABLE usuarios(
	usuario_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	usuario varchar(50) NOT NULL,
	nombre varchar(100) NOT NULL,
	correo varchar(50) NOT NULL,
	contrasena char(32) NOT NULL,

	UNIQUE i_usuario(usuario)
);

CREATE TABLE deportes(
	deporte_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombre varchar(50) NOT NULL

);

CREATE TABLE equipos(
	equipo_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombre varchar(50) NOT NULL,
	deporte_id INT(11),

	FOREIGN KEY (deporte_id) REFERENCES deportes( deporte_id ) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE jugadores(
	matricula varchar(10) NOT NULL PRIMARY KEY,
	nombre varchar(50) NOT NULL,
	apellido varchar(50) NOT NULL,
	correo varchar(50) NOT NULL,
	foto varchar(100) NOT NULL
);

CREATE TABLE equipo_jugadores(
	equipo_id INT(11),
	jugador_id varchar(10),

	FOREIGN KEY (equipo_id) REFERENCES equipos( equipo_id ) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (jugador_id) REFERENCES jugadores( matricula ) ON DELETE SET NULL ON UPDATE CASCADE
);