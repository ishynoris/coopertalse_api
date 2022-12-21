DROP DATABASE coopertalse;

CREATE DATABASE coopertalse;

USE coopertalse;

CREATE TABLE cro_carro (
    cro_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cro_numero VARCHAR(3) NOT NULL
);

CREATE TABLE mta_motorista (
    mta_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    mta_device_hash VARCHAR(200) NOT NULL,
    mta_nome VARCHAR(200) NOT NULL,
    cro_id INT NOT NULL
);

ALTER TABLE mta_motorista 
ADD CONSTRAINT fk_mta_cro FOREIGN KEY (cro_id) REFERENCES cro_carro(cro_id);

CREATE TABLE chx_chave_pix (
    chx_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    mta_id INT NOT NULL,
    chx_chave_pix VARCHAR(200) NOT NULL
);

ALTER TABLE chx_chave_pix
ADD CONSTRAINT fk_chx_mta FOREIGN KEY (mta_id) REFERENCES mta_motorista(mta_id);
