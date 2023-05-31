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
      <li><a href="cadastro_colab.php">Cadastro de Colaborador</a></li>
      <li><a href="cadastro_projeto.php">Cadastro de Projeto</a></li>
    </ul>
  </div>
  <table>
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

  $result = "SELECT Projeto.nome, Projeto.id, status, descricao, dataInicio, dataFim, Cliente.nome AS clienteNome 
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
      <td><?php echo $row['dataFim'];?></td>
      <td><?php echo $row['clienteNome'];?></td>
    </tr>
  <?php } ?>
  </table>
</body>
</html>
