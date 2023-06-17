<?php
include("conexao.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(!empty($_POST['drop'])){
    $drop_all = "drop TABLE especicolab;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop table projcateg;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop TABLE requisita;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop TABLE especialidade;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop table categoria;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop table equipetarefa;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop TABLE tarefa;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop TABLE categoriatarefa;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop TABLE equipe;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop TABLE colaborador;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop TABLE projeto;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop table cargo;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop table cliente;";
    mysqli_query($mysqli,$drop_all);
    $drop_all = "drop table departamento;";
    mysqli_query($mysqli,$drop_all);

  }else if(!empty($_POST['crud'])){
    $crud_all = "CREATE TABLE Colaborador (
      id INTEGER PRIMARY KEY AUTO_INCREMENT,
      nome VARCHAR(32),
      email VARCHAR(50),
      telefone VARCHAR(14),
      departamentoID INTEGER,
      cargoID INTEGER
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Projeto (
          id INTEGER PRIMARY KEY AUTO_INCREMENT,
          nome VARCHAR(32),
          status INTEGER,
          descricao VARCHAR(255),
          dataInicio DATE,
          dataPrevista DATE,
          dataFim DATE,
          clienteID INTEGER
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Tarefa (
          id INTEGER PRIMARY KEY AUTO_INCREMENT,
          nome VARCHAR(32),
          descricao VARCHAR(255),
          prioridade INTEGER,
          dataIni DATE,
          dataPrevista DATE,
          dataFim DATE,
          status INTEGER,
          categoriaTarefaID INTEGER
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Cliente (
          id INTEGER PRIMARY KEY AUTO_INCREMENT,
          nome VARCHAR(32),
          email VARCHAR(50),
          telefone VARCHAR(14),
          cep VARCHAR(9)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Especialidade (
          id INTEGER PRIMARY KEY AUTO_INCREMENT,
          nome VARCHAR(32)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Departamento (
          id INTEGER PRIMARY KEY AUTO_INCREMENT,
          nome VARCHAR(32),
          descricao VARCHAR(255)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Categoria (
          id INTEGER PRIMARY KEY AUTO_INCREMENT,
          nome VARCHAR(32),
          descricao VARCHAR(255)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Equipe (
          id INTEGER,
          projetoID INTEGER,
          colaboradorID INTEGER,
          PRIMARY KEY (id, projetoID, colaboradorID)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Cargo (
          id INTEGER PRIMARY KEY AUTO_INCREMENT,
          nome VARCHAR(20)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE EspeciColab (
          especialidadeID INTEGER,
          colaboradorID INTEGER,
          nivel VARCHAR(15),
          PRIMARY KEY (especialidadeID, colaboradorID)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE Requisita (
          especialidadeID INTEGER,
          projetoID INTEGER,
          nivel INTEGER,
          PRIMARY KEY (especialidadeID, projetoID)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE ProjCateg (
          projetoID INTEGER,
          categoriaID INTEGER,
          PRIMARY KEY (projetoID, categoriaID)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE EquipeTarefa (
          equipeID INTEGER,
          tarefaID INTEGER,
          projetoID INTEGER,
          colaboradorID INTEGER,
          parteFeita BOOLEAN,
          PRIMARY KEY (projetoID, tarefaID, equipeID, colaboradorID)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "CREATE TABLE CategoriaTarefa (
          id INTEGER PRIMARY KEY AUTO_INCREMENT,
          nome VARCHAR(50)
      );";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE Colaborador ADD CONSTRAINT FK_Colaborador_2
          FOREIGN KEY (departamentoID)
          REFERENCES Departamento (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE Colaborador ADD CONSTRAINT FK_Colaborador_3
          FOREIGN KEY (cargoID)
          REFERENCES Cargo (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE Projeto ADD CONSTRAINT FK_Projeto_2
          FOREIGN KEY (clienteID)
          REFERENCES Cliente (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE Tarefa ADD CONSTRAINT FK_Tarefa_2
          FOREIGN KEY (categoriaTarefaID)
          REFERENCES CategoriaTarefa (id);";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE Equipe ADD CONSTRAINT FK_Equipe_2
          FOREIGN KEY (projetoID)
          REFERENCES Projeto (id);";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE Equipe ADD CONSTRAINT FK_Equipe_3
          FOREIGN KEY (colaboradorID)
          REFERENCES Colaborador (id);";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE EspeciColab ADD CONSTRAINT FK_EspeciColab_1
          FOREIGN KEY (especialidadeID)
          REFERENCES Especialidade (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE EspeciColab ADD CONSTRAINT FK_EspeciColab_2
          FOREIGN KEY (colaboradorID)
          REFERENCES Colaborador (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE Requisita ADD CONSTRAINT FK_Requisita_1
          FOREIGN KEY (especialidadeID)
          REFERENCES Especialidade (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE Requisita ADD CONSTRAINT FK_Requisita_2
          FOREIGN KEY (projetoID)
          REFERENCES Projeto (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE ProjCateg ADD CONSTRAINT FK_ProjCateg_1
          FOREIGN KEY (projetoID)
          REFERENCES Projeto (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE ProjCateg ADD CONSTRAINT FK_ProjCateg_2
          FOREIGN KEY (categoriaID)
          REFERENCES Categoria (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE EquipeTarefa ADD CONSTRAINT FK_EquipeTarefa_1
          FOREIGN KEY (equipeID, projetoID, colaboradorID)
          REFERENCES Equipe (id, projetoID, colaboradorID)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "ALTER TABLE EquipeTarefa ADD CONSTRAINT FK_EquipeTarefa_2
          FOREIGN KEY (tarefaID)
          REFERENCES Tarefa (id)
          ON DELETE RESTRICT;";
    mysqli_query($mysqli,$crud_all);
      
    $crud_all = "insert into Cliente (nome,email,telefone,cep) values ('Cliente 1', 'email@cliente1.com.br', '(48)12323531','88960-000');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Cliente (nome,email,telefone,cep) values ('Cliente 2', 'email@cliente2.com.br', '(48)22323531','12312-123');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Cliente (nome,email,telefone,cep) values ('Cliente 3', 'email@cliente3.com.br', '(48)32323531','45645-456');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Cliente (nome,email,telefone,cep) values ('Cliente 4', 'email@cliente4.com.br', '(48)42323531','78978-789');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Cargo (nome) values ('Gerente');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Cargo (nome) values ('Programador');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Projeto (nome,status,descricao,dataInicio,dataPrevista,dataFim,clienteID) values ('Proj 1', '0', 'Desc do Proj 1', '2023-03-30', '2023-06-24', '2023-06-24', '1');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Projeto (nome,status,descricao,dataInicio,dataPrevista,dataFim,clienteID) values ('Proj 2', '0', 'Desc do Proj 2', '2023-03-30', '2023-06-24', '2023-05-22', '1');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Projeto (nome,status,descricao,dataInicio,dataPrevista,dataFim,clienteID) values ('Proj 3', '0', 'Desc do Proj 3', '2023-03-30', '2023-06-24', '2023-06-24', '2');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Categoria (nome,descricao) values ('Aplicação', 'Projeto de aplicação');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Categoria (nome,descricao) values ('Back-End', 'Projeto de Back-End');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into ProjCateg (projetoID,categoriaID) values ('1','1');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into ProjCateg (projetoID,categoriaID) values ('2','2');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Especialidade (nome) values ('C++');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Especialidade (nome) values ('SQL');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Especialidade (nome) values ('Java');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Requisita (projetoID, especialidadeID,nivel) values ('1','1','5');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Requisita (projetoID, especialidadeID,nivel) values ('1','2','5');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Requisita (projetoID, especialidadeID,nivel) values ('2','1','5');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Requisita (projetoID, especialidadeID,nivel) values ('2','2','10');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Requisita (projetoID, especialidadeID,nivel) values ('2','3','15');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Departamento (nome,descricao) values ('Geral', 'temp');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Colaborador (nome,email,telefone,departamentoID, cargoID) values ('Colab 1', 'colab1@gmail.com', '(48)32321211','1','1');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Colaborador (nome,email,telefone,departamentoID, cargoID) values ('Colab 2', 'colab2@gmail.com', '(48)32321212','1','2');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Colaborador (nome,email,telefone,departamentoID, cargoID) values ('Colab 3', 'colab3@gmail.com', '(48)32321213','1','2');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Colaborador (nome,email,telefone,departamentoID, cargoID) values ('Colab 4', 'colab4@gmail.com', '(48)32321214','1','2');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into EspeciColab (colaboradorID,especialidadeID,nivel) values ('1','1','2');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = " insert into EspeciColab (colaboradorID,especialidadeID,nivel) values ('1','2','5');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into EspeciColab (colaboradorID,especialidadeID,nivel) values ('2','2','6');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into EspeciColab (colaboradorID,especialidadeID,nivel) values ('3','3','15');";
    mysqli_query($mysqli,$crud_all);
    $crud_all = "insert into Equipe (id,projetoID,colaboradorID) values ('1','1','1');
      insert into Equipe (id,projetoID,colaboradorID) values ('1','1','2');
      insert into Equipe (id,projetoID,colaboradorID) values ('1','1','3');
      insert into Equipe (id,projetoID,colaboradorID) values ('1','1','4');
      insert into Equipe (id,projetoID,colaboradorID) values ('2','2','2');
      insert into Equipe (id,projetoID,colaboradorID) values ('2','2','3');
      
      insert into CategoriaTarefa(nome) values ('Documentação');
      insert into CategoriaTarefa(nome) values ('Programação');
      
      insert into Tarefa (nome,descricao,prioridade,dataIni,dataPrevista,dataFim,status,categoriaTarefaID) values ('Tarefa 1', 'Descricao T1', '3','2023-05-08','2023-05-10','2023-05-10','0','1');
      insert into Tarefa (nome,descricao,prioridade,dataIni,dataPrevista,dataFim,status,categoriaTarefaID) values ('Tarefa 2', 'Descricao T2', '4','2023-05-09','2023-05-12','2023-05-12','0','2');
      insert into Tarefa (nome,descricao,prioridade,dataIni,dataPrevista,dataFim,status,categoriaTarefaID) values ('Tarefa 3', 'Descricao T3', '5','2023-05-09','2023-05-12','2023-05-12','0','1');
      
      insert into EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID,parteFeita) values ('1','1','1','1','0');
      insert into EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID,parteFeita) values ('1','2','1','2','0');
      insert into EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID,parteFeita) values ('1','2','1','1','0');
      insert into EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID,parteFeita) values ('1','2','1','3','0');
      insert into EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID,parteFeita) values ('2','3','2','2','0');";
    mysqli_multi_query($mysqli,$crud_all);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tela Inicial</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    .navbar {
      background-color: #333;
      height: 50px;
    }

    .navbar ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }

    .navbar li {
      margin-right: 20px;
    }

    .navbar li:last-child {
      margin-right: 0;
    }

    .navbar li a {
      color: #fff;
      text-decoration: none;
      padding: 10px;
    }
    
    .clickable {
      cursor: pointer;
    }

    .container {
      position: fixed;
      bottom: 20px;
      right: 20px;
      text-align: center;
      margin: 0;
    }
    
    .button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #333;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin: 5px;
    }
    
  </style>
</head>
<body>
  <div class="navbar">
    <ul>
      <li class="clickable"><a onclick="listaProjetos()">Lista de Projetos</a> </li>
      <li class="clickable"><a onclick="listaColaboradores()">Lista de Colaboradores</a> </li>
      <li><a href="cadastro_colab.php">Cadastro de Colaborador</a></li>
      <li><a href="criandoProjetoInicial.php">Cadastro de Projeto</a></li>
      
    </ul>
  </div>
  <table id = "projetos">
    <tr>
      <th>Nome</th>
      <th>Status</th>
      <th>Descrição</th>
      <th>Data de Início</th>
      <th>Data Final</th>
      <th>Cliente</th>

    </tr>
  <?php
  include("conexao.php");
    $test_table = "CREATE TABLE IF NOT EXISTS Projeto (nome int)";
    mysqli_query($mysqli, $test_table);
    $test_table = "SELECT nome FROM Projeto";
    $result = mysqli_query($mysqli, $test_table);
if (mysqli_num_rows($result) != 0) {

  $result = "SELECT Projeto.nome, Projeto.id, status, descricao, dataInicio, dataPrevista, Cliente.nome AS clienteNome 
             FROM Projeto 
             INNER JOIN Cliente ON Projeto.clienteID = Cliente.id;";
    $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
  ?>
    <tr onclick="window.location='projeto.php?<?php echo $row['id'];?>';" class="clickable">
      <td><?php echo $row['nome'];?></td>
      <td><?php echo $row['status'];?>%</td>
      <td style="max-width: 200px;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;">
          <?php echo $row['descricao'];?></td>
      <td><?php echo $row['dataInicio'];?></td>
      <td><?php echo $row['dataPrevista'];?></td>
      <td><?php echo $row['clienteNome'];?></td>
    </tr>
  <?php } }else{
    $test_table = "DROP TABLE Projeto";
    mysqli_query($mysqli, $test_table);
  }?>
  </table>
  <table id = "colaboradores">
  <tr>
    <th>Nome</th>
    <th>Departamento</th>
    <th>Cargo</th>
    <th>Especialidades</th>
  </tr>
  <?php
  include("conexao.php");
      $test_table = "CREATE TABLE IF NOT EXISTS Colaborador (nome int)";
      mysqli_query($mysqli, $test_table);
      $test_table = "SELECT nome FROM Colaborador";
      $result = mysqli_query($mysqli, $test_table);
  if (mysqli_num_rows($result) != 0) {

  $result = "SELECT Colaborador.id as colabID,Colaborador.nome as colab, Departamento.nome as dep, Cargo.nome as cargo 
          FROM Colaborador 
          INNER JOIN Departamento ON Departamento.id = Colaborador.departamentoID
          INNER JOIN Cargo on Cargo.id = Colaborador.cargoID
          order by Cargo.id,Colaborador.id;";
  $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
    $colab_id = $row['colabID'];
    $especialidade_select = "SELECT Especialidade.nome as nome
                            FROM Especicolab
                            INNER JOIN Especialidade ON Especialidade.id = Especicolab.especialidadeID
                            WHERE Especicolab.colaboradorID = $colab_id";
    $especialidade_result = mysqli_query($mysqli, $especialidade_select);
  ?>
    <tr onclick="window.location='colaborador.php?<?php echo $colab_id;?>';" class="clickable">
      <td><?php echo $row['colab'];?></td>
      <td><?php echo $row['dep'];?></td>
      <td><?php echo $row['cargo'];?></td>
      <td><?php 
      $str = "";
      while($row_esp = mysqli_fetch_assoc($especialidade_result)) $str .= $row_esp['nome'] . ", ";
      echo rtrim($str, ", ");
      ?></td>
    </tr>
  <?php }}else{
    $test_table = "DROP TABLE Colaborador";
    mysqli_query($mysqli, $test_table);
  } ?>
  </table>
  <div class="container">
  <form method="POST" action="">
    <button type="submit" class="button" id="drop" value="drop" name="drop">Drop</button>
    <button type="submit" class="button" id="crud" value="crud" name="crud">CRUD</button>
  </form>
  </div>
</body>
<script>
  document.getElementById("colaboradores").hidden = true;

  function listaColaboradores(){
    var projetos = document.getElementById("projetos");
    projetos.hidden = true;
    var colaboradores = document.getElementById("colaboradores");
    colaboradores.hidden = false;
  }

  function listaProjetos(){
    var projetos = document.getElementById("projetos");
    projetos.hidden = false;
    var colaboradores = document.getElementById("colaboradores");
    colaboradores.hidden = true;
  }
</script>
</html>
