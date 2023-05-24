/* Lógico */

create database orgProjeto;
use orgProjeto;

/* Lógico_1: */

CREATE TABLE Colaborador (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    cargo VARCHAR(15),
    email VARCHAR(50),
    telefone VARCHAR(14),
    fk_Departamento_id INTEGER
);

CREATE TABLE Projeto (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    status VARCHAR(13),
    descricao VARCHAR(255),
    dataInicio DATE,
    dataFim DATE,
    fk_Cliente_cnpj INTEGER
);

CREATE TABLE Tarefa (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    descricao VARCHAR(255),
    prioridade INTEGER
);

CREATE TABLE Recurso (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    descricao VARCHAR(255),
    quantidade INTEGER
);

CREATE TABLE Cliente (
    cnpj INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    email VARCHAR(50),
    telefone VARCHAR(14)
);

CREATE TABLE Especialidade (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    nivel VARCHAR(15)
);

CREATE TABLE Departamento (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    descricao VARCHAR(255)
);

CREATE TABLE Categoria (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    descricao VARCHAR(255)
);

CREATE TABLE Endereco (
    id INTEGER PRIMARY KEY,
    logradouro VARCHAR(50),
    cep VARCHAR(9),
    bairro VARCHAR(30),
    numero INTEGER,
    fk_Cliente_cnpj INTEGER
);

CREATE TABLE _Equipe (
    id INTEGER PRIMARY KEY,
    fk_Projeto_id INTEGER,
    fk_Colaborador_id INTEGER
);

CREATE TABLE ProjRec (
    fk_Recurso_id INTEGER,
    fk_Projeto_id INTEGER
);

CREATE TABLE EspeciColab (
    fk_Especialidade_id INTEGER,
    fk_Colaborador_id INTEGER
);

CREATE TABLE Requisita (
    fk_Especialidade_id INTEGER,
    fk_Projeto_id INTEGER
);

CREATE TABLE ProjCateg (
    fk_Projeto_id INTEGER,
    fk_Categoria_id INTEGER
);

CREATE TABLE EquipeTarefa (
    fk__Equipe_id INTEGER,
    fk_Tarefa_id INTEGER,
    dataInicio DATE,
    dataFim DATE,
    status VARCHAR(13)
);
 
ALTER TABLE Colaborador ADD CONSTRAINT FK_Colaborador_2
    FOREIGN KEY (fk_Departamento_id)
    REFERENCES Departamento (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Projeto ADD CONSTRAINT FK_Projeto_2
    FOREIGN KEY (fk_Cliente_cnpj)
    REFERENCES Cliente (cnpj)
    ON DELETE RESTRICT;
 
ALTER TABLE Endereco ADD CONSTRAINT FK_Endereco_2
    FOREIGN KEY (fk_Cliente_cnpj)
    REFERENCES Cliente (cnpj)
    ON DELETE RESTRICT;
 
ALTER TABLE _Equipe ADD CONSTRAINT FK__Equipe_2
    FOREIGN KEY (fk_Projeto_id)
    REFERENCES Projeto (id);
 
ALTER TABLE _Equipe ADD CONSTRAINT FK__Equipe_3
    FOREIGN KEY (fk_Colaborador_id)
    REFERENCES Colaborador (id);
 
ALTER TABLE ProjRec ADD CONSTRAINT FK_ProjRec_1
    FOREIGN KEY (fk_Recurso_id)
    REFERENCES Recurso (id)
    ON DELETE RESTRICT;
 
ALTER TABLE ProjRec ADD CONSTRAINT FK_ProjRec_2
    FOREIGN KEY (fk_Projeto_id)
    REFERENCES Projeto (id)
    ON DELETE RESTRICT;
 
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
    FOREIGN KEY (fk__Equipe_id)
    REFERENCES _Equipe (id)
    ON DELETE RESTRICT;
 
ALTER TABLE EquipeTarefa ADD CONSTRAINT FK_EquipeTarefa_2
    FOREIGN KEY (fk_Tarefa_id)
    REFERENCES Tarefa (id)
    ON DELETE RESTRICT;
