DROP DATABASE if EXISTS `projeto_mvc`;

CREATE DATABASE `projeto_mvc`;
USE `projeto_mvc`;

CREATE TABLE associacoes(
	assoc_id INT(11) NOT NULL AUTO_INCREMENT,
	assoc_nome VARCHAR(80) NOT NULL UNIQUE,
	assoc_morada VARCHAR(100) NOT NULL,
	assoc_numContribuinte VARCHAR(9) NOT NULL UNIQUE,
	assoc_quotas_preco FLOAT NOT NULL,
	PRIMARY KEY(assoc_id)
)ENGINE=INNODB;

CREATE TABLE socios(
	user_id INT(11) NOT NULL AUTO_INCREMENT,
	`user` VARCHAR(80) NOT NULL UNIQUE,
	user_password VARCHAR(255) NOT NULL,
	user_name VARCHAR(80) NOT NULL,
	user_email VARCHAR(120) NOT NULL UNIQUE,
	user_session_id VARCHAR(255) NOT NULL,
	user_permissions LONGTEXT NOT NULL,
	PRIMARY KEY(user_id)
)ENGINE=INNODB;

CREATE TABLE quotas(
	quotas_id INT(11) NOT NULL AUTO_INCREMENT,
	quotas_data_comeco DATETIME NOT NULL,
	quotas_data_termino DATETIME NULL,
	quotas_preco FLOAT NOT NULL,
	user_id INT(11) NOT NULL UNIQUE,
	PRIMARY KEY(quotas_id)
)ENGINE=INNODB;

CREATE TABLE assoc_socios(
	assoc_id INT(11) NOT NULL,
	user_id INT(11) NOT NULL,
	`dono` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY(assoc_id, user_id, `dono`)
)ENGINE=INNODB;

CREATE TABLE imagens(
	image_id INT(11) NOT NULL AUTO_INCREMENT,
	image_title VARCHAR(80) NOT NULL,
	image_src VARCHAR(200) NOT NULL,
	assoc_id INT(11) NOT NULL,
	PRIMARY KEY(image_id)
)ENGINE=INNODB;

CREATE TABLE noticias(
	noticia_id INT(11) NOT NULL AUTO_INCREMENT,
	noticia_titulo VARCHAR(100) NOT NULL,
	noticia_descricao VARCHAR(255) NOT NULL,
	noticia_image VARCHAR(200) NOT NULL,
	assoc_id INT(11) NOT NULL,
	PRIMARY KEY(noticia_id)
)ENGINE=INNODB;

CREATE TABLE eventos(
	evento_id INT(11) NOT NULL AUTO_INCREMENT,
	evento_titulo VARCHAR(100) NOT NULL,
	evento_descricao VARCHAR(255) NOT NULL,
	evento_data VARCHAR(25) NOT NULL,
	evento_horas VARCHAR(25) NOT NULL,
	evento_unique_id VARCHAR(255) NOT NULL UNIQUE,
	assoc_id INT(11) NOT NULL, 
	PRIMARY KEY(evento_id)
)ENGINE=INNODB;

CREATE TABLE inscricoes(
	user_id INT(11) NOT NULL,
	evento_id INT(11) NOT NULL,
	PRIMARY KEY(user_id, evento_id)
)ENGINE=INNODB;

CREATE VIEW listar_assoc_dono AS 
SELECT `associacoes`.*, `socios`.* FROM `assoc_socios` 
INNER JOIN `socios` ON `assoc_socios`.`user_id` = `socios`.`user_id`
INNER JOIN `associacoes` ON `assoc_socios`.`assoc_id` = `associacoes`.`assoc_id` 
WHERE `assoc_socios`.`dono` = 1;

CREATE VIEW listar_assoc_socios AS 
SELECT `associacoes`.*, `socios`.* FROM `assoc_socios` 
INNER JOIN `socios` ON `assoc_socios`.`user_id` = `socios`.`user_id`
INNER JOIN `associacoes` ON `assoc_socios`.`assoc_id` = `associacoes`.`assoc_id`
WHERE `assoc_socios`.`dono` = 0;

INSERT INTO `socios` VALUES	(1, 'Admin', '$2a$08$2AEpHUaS75jId/VlX3bNnew.P58HbqXTa.7ioiDgM2kAd0R469yBy', 'Admin', 'admin@gmail.com','vp7b3tnarjj5p66n3n1su8mim5', 'a:5:{i:0;s:13:"user-register";i:1;s:18:"adm-gerir-noticias";i:2;s:21:"adm-gerir-associacoes";i:3;s:17:"adm-gerir-galeria";i:4;s:5:"admin";}');