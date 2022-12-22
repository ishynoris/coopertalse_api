ALTER TABLE mta_motorista
ADD COLUMN mta_deletado TINYINT(1) NOT NULL default 0,
ADD COLUMN mta_data_cadastro DATETIME NULL,
ADD COLUMN mta_data_alteracao DATETIME NULL;

ALTER TABLE cro_carro 
ADD COLUMN cro_deletado TINYINT(1) NOT NULL DEFAULT 0,
ADD COLUMN cro_data_cadastro DATETIME NULL,
ADD COLUMN cro_data_alteracao DATETIME NULL;

ALTER TABLE chx_chave_pix 
ADD COLUMN chx_deletado TINYINT(1) NOT NULL DEFAULT 0,
ADD COLUMN chx_data_cadastro DATETIME NULL,
ADD COLUMN chx_data_alteracao DATETIME NULL;