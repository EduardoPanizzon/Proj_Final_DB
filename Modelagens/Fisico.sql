/* Lógico */

create database orgProjeto;
use orgProjeto;

/* Lógico: */

CREATE TABLE Colaborador (
id INTEGER PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(32),
email VARCHAR(50),
telefone VARCHAR(14),
departamentoID INTEGER,
cargoID INTEGER
);

CREATE TABLE Projeto (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    status INTEGER,
    descricao VARCHAR(255),
    dataInicio DATE,
    dataPrevista DATE,
    dataFim DATE,
    clienteID INTEGER
);

CREATE TABLE Tarefa (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    descricao VARCHAR(255),
    prioridade INTEGER,
    dataIni DATE,
    dataPrevista DATE,
    dataFim DATE,
    status INTEGER,
    categoriaTarefaID INTEGER
);

CREATE TABLE Cliente (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(32),
    email VARCHAR(50),
    telefone VARCHAR(14),
    cep VARCHAR(9)
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

CREATE TABLE Equipe (
    id INTEGER,
    projetoID INTEGER,
    colaboradorID INTEGER,
    PRIMARY KEY (id, projetoID, colaboradorID)
);

CREATE TABLE Cargo (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(20)
);

CREATE TABLE EspeciColab (
    especialidadeID INTEGER,
    colaboradorID INTEGER,
    nivel VARCHAR(15),
    PRIMARY KEY (especialidadeID, colaboradorID)
);

CREATE TABLE Requisita (
    especialidadeID INTEGER,
    projetoID INTEGER,
    nivel INTEGER,
    PRIMARY KEY (especialidadeID, projetoID)
);

CREATE TABLE ProjCateg (
    projetoID INTEGER,
    categoriaID INTEGER,
    PRIMARY KEY (projetoID, categoriaID)
);

CREATE TABLE EquipeTarefa (
    equipeID INTEGER,
    tarefaID INTEGER,
    projetoID INTEGER,
    colaboradorID INTEGER,
    PRIMARY KEY (projetoID, tarefaID, equipeID, colaboradorID)
);

CREATE TABLE CategoriaTarefa (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50)
);

ALTER TABLE Colaborador ADD CONSTRAINT FK_Colaborador_2
    FOREIGN KEY (departamentoID)
    REFERENCES Departamento (id)
    ON DELETE RESTRICT;

ALTER TABLE Colaborador ADD CONSTRAINT FK_Colaborador_3
    FOREIGN KEY (cargoID)
    REFERENCES Cargo (id)
    ON DELETE RESTRICT;

ALTER TABLE Projeto ADD CONSTRAINT FK_Projeto_2
    FOREIGN KEY (clienteID)
    REFERENCES Cliente (id)
    ON DELETE RESTRICT;

ALTER TABLE Tarefa ADD CONSTRAINT FK_Tarefa_2
    FOREIGN KEY (categoriaTarefaID)
    REFERENCES CategoriaTarefa (id);

ALTER TABLE Equipe ADD CONSTRAINT FK_Equipe_2
    FOREIGN KEY (projetoID)
    REFERENCES Projeto (id);

ALTER TABLE Equipe ADD CONSTRAINT FK_Equipe_3
    FOREIGN KEY (colaboradorID)
    REFERENCES Colaborador (id);

ALTER TABLE EspeciColab ADD CONSTRAINT FK_EspeciColab_1
    FOREIGN KEY (especialidadeID)
    REFERENCES Especialidade (id)
    ON DELETE RESTRICT;

ALTER TABLE EspeciColab ADD CONSTRAINT FK_EspeciColab_2
    FOREIGN KEY (colaboradorID)
    REFERENCES Colaborador (id)
    ON DELETE RESTRICT;

ALTER TABLE Requisita ADD CONSTRAINT FK_Requisita_1
    FOREIGN KEY (especialidadeID)
    REFERENCES Especialidade (id)
    ON DELETE RESTRICT;

ALTER TABLE Requisita ADD CONSTRAINT FK_Requisita_2
    FOREIGN KEY (projetoID)
    REFERENCES Projeto (id)
    ON DELETE RESTRICT;

ALTER TABLE ProjCateg ADD CONSTRAINT FK_ProjCateg_1
    FOREIGN KEY (projetoID)
    REFERENCES Projeto (id)
    ON DELETE RESTRICT;

ALTER TABLE ProjCateg ADD CONSTRAINT FK_ProjCateg_2
    FOREIGN KEY (categoriaID)
    REFERENCES Categoria (id)
    ON DELETE RESTRICT;

ALTER TABLE EquipeTarefa ADD CONSTRAINT FK_EquipeTarefa_1
    FOREIGN KEY (equipeID, projetoID, colaboradorID)
    REFERENCES Equipe (id, projetoID, colaboradorID)
    ON DELETE RESTRICT;

ALTER TABLE EquipeTarefa ADD CONSTRAINT FK_EquipeTarefa_2
    FOREIGN KEY (tarefaID)
    REFERENCES Tarefa (id)
    ON DELETE RESTRICT;

insert into Cliente (nome,email,telefone,cep) values ('Cliente 1', 'email@cliente1.com.br', '(48)12323531',"88960-000");
insert into Cliente (nome,email,telefone,cep) values ('Cliente 2', 'email@cliente2.com.br', '(48)22323531',"12312-123");
insert into Cliente (nome,email,telefone,cep) values ('Cliente 3', 'email@cliente3.com.br', '(48)32323531',"45645-456");
insert into Cliente (nome,email,telefone,cep) values ('Cliente 4', 'email@cliente4.com.br', '(48)42323531',"78978-789");

insert into Cargo (nome) values ('Gerente');
insert into Cargo (nome) values ('Programador');

insert into Projeto (nome,status,descricao,dataInicio,dataPrevista,dataFim,clienteID) values ('Proj 1', 30, 'Desc do Proj 1', '2023-03-30', '2023-06-24', '2023-06-24', 1);
insert into Projeto (nome,status,descricao,dataInicio,dataPrevista,dataFim,clienteID) values ('Proj 2', 60, 'Desc do Proj 2', '2023-03-30', '2023-06-24', '2023-05-22', 1);
insert into Projeto (nome,status,descricao,dataInicio,dataPrevista,dataFim,clienteID) values ('Proj 3', 10, 'Desc do Proj 3', '2023-03-30', '2023-06-24', '2023-06-24', 2);

insert into Categoria (nome,descricao) values ('Aplicação', 'Projeto de aplicação');
insert into Categoria (nome,descricao) values ('Back-End', 'Projeto de Back-End');

insert into ProjCateg (projetoID,categoriaID) values (1,1);
insert into ProjCateg (projetoID,categoriaID) values (2,2);

insert into Especialidade (nome) values ('C++');
insert into Especialidade (nome) values ('SQL');
insert into Especialidade (nome) values ('Java');

insert into Requisita (projetoID, especialidadeID,nivel) values (1,1,5);
insert into Requisita (projetoID, especialidadeID,nivel) values (1,2,5);
insert into Requisita (projetoID, especialidadeID,nivel) values (2,1,5);
insert into Requisita (projetoID, especialidadeID,nivel) values (2,2,10);
insert into Requisita (projetoID, especialidadeID,nivel) values (2,3,15);

insert into Departamento (nome,descricao) values ('Geral', 'temp');

insert into Colaborador (nome,email,telefone,departamentoID, cargoID) values ('Colab 2', 'colab2@gmail.com', '(48)32321212',1,2);
insert into Colaborador (nome,email,telefone,departamentoID, cargoID) values ('Colab 3', 'colab3@gmail.com', '(48)32321213',1,2);
insert into Colaborador (nome,email,telefone,departamentoID, cargoID) values ('Colab 4', 'colab4@gmail.com', '(48)32321214',1,2);
insert into Colaborador (nome,email,telefone,departamentoID, cargoID) values ('Colab 1', 'colab1@gmail.com', '(48)32321211',1,1);

insert into EspeciColab (colaboradorID,especialidadeID,nivel) values (1,1,2);
insert into EspeciColab (colaboradorID,especialidadeID,nivel) values (1,2,5);
insert into EspeciColab (colaboradorID,especialidadeID,nivel) values (2,2,6);
insert into EspeciColab (colaboradorID,especialidadeID,nivel) values (3,3,15);

insert into Equipe (id,projetoID,colaboradorID) values (1,1,1);
insert into Equipe (id,projetoID,colaboradorID) values (1,1,2);
insert into Equipe (id,projetoID,colaboradorID) values (1,1,3);
insert into Equipe (id,projetoID,colaboradorID) values (1,1,4);
insert into Equipe (id,projetoID,colaboradorID) values (2,2,2);
insert into Equipe (id,projetoID,colaboradorID) values (2,2,3);

insert into CategoriaTarefa(nome) values ('Documentação');
insert into CategoriaTarefa(nome) values ('Programação');


insert into Tarefa (nome,descricao,prioridade,dataIni,dataPrevista,dataFim,status,categoriaTarefaID) values ('Tarefa 1', 'Descricao T1', 3,'2023-05-08','2023-05-10','2023-05-10',30,1);
insert into Tarefa (nome,descricao,prioridade,dataIni,dataPrevista,dataFim,status,categoriaTarefaID) values ('Tarefa 2', 'Descricao T2', 4,'2023-05-09','2023-05-12','2023-05-12',50,2);
insert into Tarefa (nome,descricao,prioridade,dataIni,dataPrevista,dataFim,status,categoriaTarefaID) values ('Tarefa 3', 'Descricao T3', 5,'2023-05-09','2023-05-12','2023-05-12',90,1);

insert into EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID) values (1,1,1,1);
insert into EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID) values (1,2,1,2);
insert into EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID) values (2,3,2,2);