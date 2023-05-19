/* Lógico */

create database orgProjeto;
use orgProjeto;

CREATE TABLE Colaborador (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(32),
    cargo VARCHAR(15),
    email VARCHAR(50),
    telefone VARCHAR(14),
    fk_Departamento_id INTEGER
);

CREATE TABLE Projetos (
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
    status VARCHAR(13),
    descricao VARCHAR(255),
    dataInicio DATE,
    dataFim DATE,
    prioridade INTEGER,
    fk__Equipe_id INTEGER
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

CREATE TABLE Especialidades (
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

CREATE TABLE Equipe (
    id INTEGER PRIMARY KEY,
    fk_Projetos_id INTEGER,
    fk_Colaborador_id INTEGER
);

CREATE TABLE projetosRecurso (
    fk_Recurso_id INTEGER,
    fk_Projetos_id INTEGER
);

CREATE TABLE colaboradorEspecialidades (
    fk_Especialidades_id INTEGER,
    fk_Colaborador_id INTEGER
);

CREATE TABLE Requisita (
    fk_Especialidades_id INTEGER,
    fk_Projetos_id INTEGER
);

CREATE TABLE projetosCategoria (
    fk_Projetos_id INTEGER,
    fk_Categoria_id INTEGER
);
 
ALTER TABLE Colaborador ADD CONSTRAINT FK_Colaborador_2
    FOREIGN KEY (fk_Departamento_id)
    REFERENCES Departamento (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Projetos ADD CONSTRAINT FK_Projetos_2
    FOREIGN KEY (fk_Cliente_cnpj)
    REFERENCES Cliente (cnpj)
    ON DELETE RESTRICT;
 
ALTER TABLE Tarefa ADD CONSTRAINT FK_Tarefa_2
    FOREIGN KEY (fk__Equipe_id)
    REFERENCES Equipe (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Endereco ADD CONSTRAINT FK_Endereco_2
    FOREIGN KEY (fk_Cliente_cnpj)
    REFERENCES Cliente (cnpj)
    ON DELETE RESTRICT;
 
ALTER TABLE Equipe ADD CONSTRAINT FK_Equipe_2
    FOREIGN KEY (fk_Projetos_id)
    REFERENCES Projetos (id);
 
ALTER TABLE Equipe ADD CONSTRAINT FK_Equipe_3
    FOREIGN KEY (fk_Colaborador_id)
    REFERENCES Colaborador (id);
 
ALTER TABLE projetosRecurso ADD CONSTRAINT FK_projetosRecurso_1
    FOREIGN KEY (fk_Recurso_id)
    REFERENCES Recurso (id)
    ON DELETE RESTRICT;
 
ALTER TABLE projetosRecurso ADD CONSTRAINT FK_projetosRecurso_2
    FOREIGN KEY (fk_Projetos_id)
    REFERENCES Projetos (id)
    ON DELETE RESTRICT;
 
ALTER TABLE colaboradorEspecialidades ADD CONSTRAINT FK_colaboradorEspecialidades_1
    FOREIGN KEY (fk_Especialidades_id)
    REFERENCES Especialidades (id)
    ON DELETE RESTRICT;
 
ALTER TABLE colaboradorEspecialidades ADD CONSTRAINT FK_colaboradorEspecialidades_2
    FOREIGN KEY (fk_Colaborador_id)
    REFERENCES Colaborador (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Requisita ADD CONSTRAINT FK_Requisita_1
    FOREIGN KEY (fk_Especialidades_id)
    REFERENCES Especialidades (id)
    ON DELETE RESTRICT;
 
ALTER TABLE Requisita ADD CONSTRAINT FK_Requisita_2
    FOREIGN KEY (fk_Projetos_id)
    REFERENCES Projetos (id)
    ON DELETE RESTRICT;
 
ALTER TABLE projetosCategoria ADD CONSTRAINT FK_projetosCategoria_1
    FOREIGN KEY (fk_Projetos_id)
    REFERENCES Projetos (id)
    ON DELETE RESTRICT;
 
ALTER TABLE projetosCategoria ADD CONSTRAINT FK_projetosCategoria_2
    FOREIGN KEY (fk_Categoria_id)
    REFERENCES Categoria (id)
    ON DELETE RESTRICT;