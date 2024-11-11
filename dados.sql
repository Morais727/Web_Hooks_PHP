CREATE TABLE boletins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_boletim VARCHAR(50),
    produtor VARCHAR(100),
    especie VARCHAR(50),
    cultivar VARCHAR(50),
    safra VARCHAR(20),
    categoria VARCHAR(20),
    peso_lote DECIMAL(10, 2),
    data_amostragem DATE,
    cidade_ubs VARCHAR(100)
);

CREATE TABLE certificados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_boletim VARCHAR(50),
    numero_certificado VARCHAR(50),
    arquivo_base64 LONGTEXT
);
