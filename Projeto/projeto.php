<?php $proj_id = parse_url("$_SERVER[REQUEST_URI]", PHP_URL_QUERY);?>

<!DOCTYPE html>
<html>
<head>
  <title>Tabelas Lado a Lado</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #333;
      height: 50px;
      font-size: 20px;
      color: white;
      align-items: center;

    }

    .navbar ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      height: 100%;
    }

    .navbar li {
      text-align: center;

    }

    .navbar li:last-child {
      justify-self: center;
    }


    .table-container {
      width: 30%;
      float: left;
      box-sizing: border-box;
      padding: 10px;
    }

    .table-container2 {
      width: 70%;
      float: left;
      box-sizing: border-box;
      padding: 10px;
    }

    .button {
      width: 12%;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    a {
      color: white;
      text-decoration: none;
    }

  </style>
</head>
<body>
<?php include("conexao.php");?>

<div class="navbar">
  <ul>
    <li><a href="/"  style="font-size: 35px;margin:10px;">←</a></li>
    <li class="title" style="width:90%;"><?php 
    $proj_name = "SELECT Projeto.nome 
                  FROM Projeto 
                  WHERE Projeto.id = $proj_id";

    $name_r = mysqli_query($mysqli,$proj_name);
    echo mysqli_fetch_assoc($name_r)['nome'];?></li>
    <li class ="button"><a href="/cadastro_tarefa.php?<?php echo $proj_id?>">Nova Tarefa</a></li>
    </ul>
  </div>
  <div class="table-container">
    <table>
      <div class="navbar" style="padding-left: 10px;display:flex;">Colaboradores</div>
      <tr>
        <th>Nome</th>
        <th>Cargo</th>
      </tr>
      <?php

  $result = "SELECT Colaborador.nome AS nome, Cargo.nome AS cargo, Colaborador.id
             FROM Equipe
             INNER JOIN Colaborador ON Equipe.colaboradorID = Colaborador.id
             INNER JOIN Cargo on Colaborador.cargoID = Cargo.id
             WHERE projetoID = $proj_id";

  $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
  ?>
    <tr>
      <td><?php echo $row['nome'];?></td>
      <td><?php echo $row['cargo'];?></td>
    </tr>
  <?php } ?>
    </table>
  </div>

  <div class="table-container2">
    <table>
      <tr>
        <th>Tarefa</th>
        <th>Prioridade</th>
        <th>Data Inicial</th>
        <th>Data Final</th>
        <th>Status</th>
      </tr>
      <?php
  include("conexao.php");

  $result = "SELECT distinct Tarefa.nome, Tarefa.status, Tarefa.dataFim, Tarefa.prioridade, Tarefa.dataIni
             FROM Tarefa
             INNER JOIN EquipeTarefa ON EquipeTarefa.tarefaID = Tarefa.id
             INNER JOIN Equipe on EquipeTarefa.EquipeID = Equipe.id
             WHERE Equipe.projetoID = $proj_id";

  $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
  ?>
    <tr >
      <td><?php echo $row['nome'];?></td>
      <td><?php echo $row['prioridade'];?></td>
      <td><?php echo $row['dataIni'];?></td>
      <td><?php echo $row['dataFim'];?></td>
      <td><?php echo $row['status'];?>%</td>
    </tr>
  <?php } ?>
    </table>
  </div>
</body>
</html>
