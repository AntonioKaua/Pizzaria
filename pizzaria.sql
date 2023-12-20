CREATE DATABASE pizzaria;
USE pizzaria;
-- TABELAS
CREATE TABLE bordas(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    tipo VARCHAR(100)
);
CREATE TABLE massas(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    tipo VARCHAR(100)
);
CREATE TABLE sabores(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    preco DECIMAL(10,2)
);

CREATE TABLE usuario(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(225),
    email VARCHAR(255),
    senha VARCHAR (60)
);

CREATE TABLE pizzas(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    borda_id INT NOT NULL,
    massa_id  INT NOT NULL,
    foreign key (borda_id) REFERENCES bordas (id),
    foreign key (massa_id) REFERENCES massas (id)
);

-- n
CREATE TABLE pizza_sabor(
	id INT PRIMARY KEY AUTO_INCREMENT,
	pizza_id INT NOT NULL,
    sabor_id  INT NOT NULL,
    foreign key (pizza_id) REFERENCES pizzas (id),
    foreign key (sabor_id) REFERENCES sabores (id)
);
CREATE TABLE status(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    tipo VARCHAR(100)
);
CREATE TABLE pedidos(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	pizza_id INT NOT NULL,
    status_id  INT NOT NULL,
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    foreign key (pizza_id) REFERENCES pizzas (id),
    foreign key (status_id) REFERENCES status (id)
);

-- INSERTS 
INSERT INTO status(tipo) VALUES
('Em produção'),
('Entrega'),
('Concluída');
select * from status;
INSERT INTO massas (tipo) VALUES
('Comum'),
('Integral'),
('Temperada');
INSERT INTO bordas (tipo) VALUES
('Cheddar'),
('Catupiry');

INSERT INTO sabores (nome) VALUES
('4 Queijos'),
('Frango com Catupiry'),
('Calabresa'),
('Lombinho'),
('Filé com Cheddar'),
('Portuguesa'),
('Margherita');

UPDATE sabores SET preco = 30.00 WHERE nome = '4 Queijos';
UPDATE sabores SET preco = 32.00 WHERE nome = 'Frango com Catupiry';
UPDATE sabores SET preco = 26.00 WHERE nome = 'Calabresa';
UPDATE sabores SET preco = 42.00 WHERE nome = 'Lombinho';
UPDATE sabores SET preco = 50.00 WHERE nome = 'Filé com Cheddar';
UPDATE sabores SET preco = 28.00 WHERE nome = 'Portuguesa';
UPDATE sabores SET preco = 26.00 WHERE nome = 'Margherita';






