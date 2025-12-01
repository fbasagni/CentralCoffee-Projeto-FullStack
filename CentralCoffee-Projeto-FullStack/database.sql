CREATE DATABASE IF NOT EXISTS centralcoffee
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE centralcoffee;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reservas (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT UNSIGNED NOT NULL,
  nome_cliente VARCHAR(100) NOT NULL,
  email_cliente VARCHAR(150) NOT NULL,
  telefone_cliente VARCHAR(20) NOT NULL,
  data_visita DATE NOT NULL,
  hora_visita TIME NOT NULL,
  numero_pessoas INT NOT NULL,
  preferencia_assento VARCHAR(100) NOT NULL,
  episodio_preferido VARCHAR(150) NULL,
  observacoes TEXT NULL,
  criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_reservas_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
);

