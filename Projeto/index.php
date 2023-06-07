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

  $result = "SELECT Projeto.nome, Projeto.id, status, descricao, dataInicio, dataPrevista, Cliente.nome AS clienteNome 
             FROM Projeto 
             INNER JOIN Cliente ON Projeto.clienteID = Cliente.id;";
  $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
  ?>
    <tr onclick="window.location='projeto.php?<?php echo $row['id'];?>';" class="clickable">
      <td><?php echo $row['nome'];?></td>
      <td><?php echo $row['status'];?>%</td>
      <td><?php echo $row['descricao'];?></td>
      <td><?php echo $row['dataInicio'];?></td>
      <td><?php echo $row['dataPrevista'];?></td>
      <td><?php echo $row['clienteNome'];?></td>
    </tr>
  <?php } ?>
  </table>
  <table id = "colaboradores">
  <tr>
    <th>Nome</th>
    <th>Departamento</th>
    <th>Cargo</th>
  </tr>
  <?php
  include("conexao.php");

  $result = "SELECT Colaborador.id as colabID,Colaborador.nome as colab, Departamento.nome as dep, Cargo.nome as cargo 
            FROM Colaborador 
            INNER JOIN Departamento ON Departamento.id = Colaborador.departamentoID
            INNER JOIN Cargo on Cargo.id = Colaborador.cargoID
            order by Cargo.id,Colaborador.id;";
  $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
  ?>
    <tr onclick="window.location='colaborador.php?<?php echo $row['colabID'];?>';" class="clickable">
      <td><?php echo $row['colab'];?></td>
      <td><?php echo $row['dep'];?></td>
      <td><?php echo $row['cargo'];?></td>
    </tr>
  <?php } ?>
  </table>
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
