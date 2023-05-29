/* Lógico */

create database orgProjeto;
use orgProjeto;

/* Lógico: */

CREATE TABLE Colaborador (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    email VARCHAR(50),
    telefone VARCHAR(14),
    fk_Departamento_id INTEGER,
    fk_Cargo_id INTEGER
);

CREATE TABLE Projeto (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    status INTEGER,
    descricao VARCHAR(255),
    dataInicio DATE,
    dataFim DATE,
    fk_Cliente_id INTEGER
);

CREATE TABLE Tarefa (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    descricao VARCHAR(255),
    prioridade INTEGER
);

CREATE TABLE Cliente (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    email VARCHAR(50),
    telefone VARCHAR(14)
);

CREATE TABLE Especialidade (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32)
);

CREATE TABLE Departamento (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    descricao VARCHAR(255)
);

CREATE TABLE Categoria (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    descricao VARCHAR(255)
);

CREATE TABLE Endereco (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    logradouro VARCHAR(50),
    cep VARCHAR(9),
    bairro VARCHAR(30),
    numero INTEGER,
    fk_Cliente_id INTEGER
);

CREATE TABLE Equipe (
    id INTEGER,
    fk_Projeto_id INTEGER,
    fk_Colaborador_id INTEGER,
    PRIMARY KEY (id, fk_Projeto_id, fk_Colaborador_id)
);

CREATE TABLE Cargo (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(20)
);

CREATE TABLE EspeciColab (
    fk_Especialidade_id INTEGER,
    fk_Colaborador_id INTEGER,
    nivel VARCHAR(15)
);

CREATE TABLE Requisita (
    fk_Especialidade_id INTEGER,
    fk_Projeto_id INTEGER,
    nivel INTEGER
);

CREATE TABLE ProjCateg (
    fk_Projeto_id INTEGER,
    fk_Categoria_id INTEGER
);

CREATE TABLE EquipeTarefa (
    fk_Equipe_id INTEGER,
    fk_Tarefa_id INTEGER,
    dataInicio DATE,
    dataFim DATE,
    status INTEGER
);
 
ALTER TABLE Colaborador ADD CONSTRAINT FK_Colaborador_2
    FOREIGN KEY (fk_Departamento_id)
    REFERENCES Departamento (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Colaborador ADD CONSTRAINT FK_Colaborador_3
    FOREIGN KEY (fk_Cargo_id)
    REFERENCES Cargo (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Projeto ADD CONSTRAINT FK_Projeto_2
    FOREIGN KEY (fk_Cliente_id)
    REFERENCES Cliente (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Endereco ADD CONSTRAINT FK_Endereco_2
    FOREIGN KEY (fk_Cliente_id)
    REFERENCES Cliente (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Equipe ADD CONSTRAINT FK_Equipe_2
    FOREIGN KEY (fk_Projeto_id)
    REFERENCES Projeto (id);
 
ALTER TABLE Equipe ADD CONSTRAINT FK_Equipe_3
    FOREIGN KEY (fk_Colaborador_id)
    REFERENCES Colaborador (id);
 
ALTER TABLE EspeciColab ADD CONSTRAINT FK_EspeciColab_1
    FOREIGN KEY (fk_Especialidade_id)
    REFERENCES Especialidade (id)
    ON DELETE RESTRICT;
 
ALTER TABLE EspeciColab ADD CONSTRAINT FK_EspeciColab_2
    FOREIGN KEY (fk_Colaborador_id)
    REFERENCES Colaborador (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Requisita ADD CONSTRAINT FK_Requisita_1
    FOREIGN KEY (fk_Especialidade_id)
    REFERENCES Especialidade (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Requisita ADD CONSTRAINT FK_Requisita_2
    FOREIGN KEY (fk_Projeto_id)
    REFERENCES Projeto (id)
    ON DELETE RESTRICT;
 
ALTER TABLE ProjCateg ADD CONSTRAINT FK_ProjCateg_1
    FOREIGN KEY (fk_Projeto_id)
    REFERENCES Projeto (id)
    ON DELETE RESTRICT;
 
ALTER TABLE ProjCateg ADD CONSTRAINT FK_ProjCateg_2
    FOREIGN KEY (fk_Categoria_id)
    REFERENCES Categoria (id)
    ON DELETE RESTRICT;
 
ALTER TABLE EquipeTarefa ADD CONSTRAINT FK_EquipeTarefa_1
    FOREIGN KEY (fk_Equipe_id)
    REFERENCES Equipe (id)
    ON DELETE RESTRICT;
 
ALTER TABLE EquipeTarefa ADD CONSTRAINT FK_EquipeTarefa_2
    FOREIGN KEY (fk_Tarefa_id)
    REFERENCES Tarefa (id)
    ON DELETE RESTRICT;

insert into Cliente (nome,email,telefone) values ('Cliente 1', 'email@cliente1.com.br', '(48)12323531');
insert into Cliente (nome,email,telefone) values ('Cliente 2', 'email@cliente2.com.br', '(48)22323531');
insert into Cliente (nome,email,telefone) values ('Cliente 3', 'email@cliente3.com.br', '(48)32323531');
insert into Cliente (nome,email,telefone) values ('Cliente 4', 'email@cliente4.com.br', '(48)42323531');

insert into Cargo (nome) values ('Gerente');
insert into Cargo (nome) values ('Programador');

insert into Endereco (logradouro,cep,bairro,numero,fk_Cliente_id) values ('Av.N1', 'Centro', '88905121', 10, 1);
insert into Endereco (logradouro,cep,bairro,numero,fk_Cliente_id) values ('Av.N2', 'Centro', '88905122', 20, 2);
insert into Endereco (logradouro,cep,bairro,numero,fk_Cliente_id) values ('Av.N3', 'Centro', '88905123', 30, 3);
insert into Endereco (logradouro,cep,bairro,numero,fk_Cliente_id) values ('Av.N4', 'Centro', '88905124', 40, 4);

insert into Projeto (nome,status,descricao,dataInicio,dataFim,fk_Cliente_id) values ('Proj 1', 30, 'Desc do Proj 1', '2023-03-30', '2023-06-24', 1);
insert into Projeto (nome,status,descricao,dataInicio,dataFim,fk_Cliente_id) values ('Proj 2', 60, 'Desc do Proj 2', '2023-03-30', '2023-05-22', 1);
insert into Projeto (nome,status,descricao,dataInicio,dataFim,fk_Cliente_id) values ('Proj 3', 10, 'Desc do Proj 3', '2023-03-30', '2023-06-24', 2);

insert into Categoria (nome,descricao) values ('Aplicação', 'Projeto de aplicação');
insert into Categoria (nome,descricao) values ('Back-End', 'Projeto de Back-End');

insert into ProjCateg (fk_Projeto_id,fk_Categoria_id) values (1,1);
insert into ProjCateg (fk_Projeto_id,fk_Categoria_id) values (2,2);

insert into Especialidade (nome) values ('C++');
insert into Especialidade (nome) values ('SQL');
insert into Especialidade (nome) values ('Java');

insert into Requisita (fk_Projeto_id, fk_Especialidade_id,nivel) values (1,1,5);
insert into Requisita (fk_Projeto_id, fk_Especialidade_id,nivel) values (1,2,5);
insert into Requisita (fk_Projeto_id, fk_Especialidade_id,nivel) values (2,1,5);
insert into Requisita (fk_Projeto_id, fk_Especialidade_id,nivel) values (2,2,10);
insert into Requisita (fk_Projeto_id, fk_Especialidade_id,nivel) values (2,3,15);

insert into Departamento (nome,descricao) values ('Geral', 'temp');

insert into Colaborador (nome,email,telefone,fk_Departamento_id, fk_Cargo_id) values ('Colab 2', 'colab2@gmail.com', '(48)32321212',1,2);
insert into Colaborador (nome,email,telefone,fk_Departamento_id, fk_Cargo_id) values ('Colab 3', 'colab3@gmail.com', '(48)32321213',1,2);
insert into Colaborador (nome,email,telefone,fk_Departamento_id, fk_Cargo_id) values ('Colab 4', 'colab4@gmail.com', '(48)32321214',1,2);
insert into Colaborador (nome,email,telefone,fk_Departamento_id, fk_Cargo_id) values ('Colab 1', 'colab1@gmail.com', '(48)32321211',1,1);

insert into EspeciColab (fk_Colaborador_id,fk_Especialidade_id,nivel) values (1,1,2);
insert into EspeciColab (fk_Colaborador_id,fk_Especialidade_id,nivel) values (1,2,5);
insert into EspeciColab (fk_Colaborador_id,fk_Especialidade_id,nivel) values (2,2,6);
insert into EspeciColab (fk_Colaborador_id,fk_Especialidade_id,nivel) values (3,3,15);

insert into Equipe (id,fk_Projeto_id,fk_Colaborador_id) values (1,1,1);
insert into Equipe (id,fk_Projeto_id,fk_Colaborador_id) values (1,1,2);
insert into Equipe (id,fk_Projeto_id,fk_Colaborador_id) values (1,1,3);
insert into Equipe (id,fk_Projeto_id,fk_Colaborador_id) values (1,1,4);
insert into Equipe (id,fk_Projeto_id,fk_Colaborador_id) values (2,2,2);
insert into Equipe (id,fk_Projeto_id,fk_Colaborador_id) values (2,2,3);

insert into Tarefa (nome,descricao,prioridade) values ('Tarefa 1', 'Descricao T1', 3);
insert into Tarefa (nome,descricao,prioridade) values ('Tarefa 2', 'Descricao T2', 4);
insert into Tarefa (nome,descricao,prioridade) values ('Tarefa 3', 'Descricao T3', 5);
insert into Tarefa (nome,descricao,prioridade) values ('Tarefa 4', 'Descricao T4', 3);

insert into EquipeTarefa (fk_Equipe_id,fk_Tarefa_id,dataInicio,dataFim,status) values (1,1,'2023-05-08','2023-05-10',10);
insert into EquipeTarefa (fk_Equipe_id,fk_Tarefa_id,dataInicio,dataFim,status) values (1,2,'2023-05-09','2023-05-12',15);
insert into EquipeTarefa (fk_Equipe_id,fk_Tarefa_id,dataInicio,dataFim,status) values (2,2,'2023-05-09','2023-05-12',95);