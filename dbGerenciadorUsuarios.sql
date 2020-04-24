

create database dbGerenciadorUsuarios;
use dbGerenciadorUsuarios;
CREATE TABLE `CRUD` (
`crud_nome` VARCHAR(50) NOT NULL,
`crud_fone_celular` VARCHAR(10) NOT NULL,
`crud_cidade` VARCHAR(50) NOT NULL,
`crud_uf` VARCHAR(2) NOT NULL DEFAULT '0',
`crud_codigo` INT(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`crud_codigo`)
);