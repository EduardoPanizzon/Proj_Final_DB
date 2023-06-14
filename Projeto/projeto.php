<?php $proj_id = parse_url("$_SERVER[REQUEST_URI]", PHP_URL_QUERY);

  $priority=array("Super Baixa","Baixa","Media","Alta","Super Alta");
?>

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

    .clickable {
      cursor: pointer;
    }

  </style>
</head>
<body>
<?php include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $add_colab = $_POST['colab_select'];

  $insert_colab = "INSERT INTO Equipe (id,projetoID,colaboradorID) 
                   values ('$proj_id','$proj_id','$add_colab')";
  $result_colab = mysqli_query($mysqli, $insert_colab);
} 
?>

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
  <tr id="add_colab" name="add_colab" onclick="addColab()"><td colspan="2" style="text-align-last: center;">Adicionar Colaborador</td></tr>
    <tr id="colabs" name="colabs" style="display:none"><td colspan="2" style="text-align-last: center;">
      <form method="POST" action="">
      <select id="colab_select" name="colab_select" onChange="this.form.submit()">
        <option>Escolha...</option>
        <?php
        $result ="SELECT Colaborador.id AS id, Colaborador.nome AS nome FROM Colaborador 
        where id not in (Select Equipe.colaboradorID as colabID From Equipe where projetoID = '$pro')";
        $resultado = mysqli_query($mysqli, $result);
        while($row = mysqli_fetch_assoc($resultado)){
        ?>
        <option value = "<?php echo $row['id']; ?>"><?php echo $row['nome'];?> </option>

        <?php } ?>
      </select>
      </form>
    </td></tr>
    </table><?php
      $proj_name = "SELECT Projeto.descricao 
      FROM Projeto 
      WHERE Projeto.id = $proj_id";

      $name_r = mysqli_query($mysqli,$proj_name);?>
        <div  style="background: #F2F2F2;border-radius: 2 px;margin-top: 20px;height: 100px;padding: 10px">
      <b>Descrição do Projeto: </b><?php echo mysqli_fetch_assoc($name_r)['descricao'];?>
    </div>
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
  $result = "SELECT distinct Tarefa.nome, Tarefa.status, Tarefa.dataPrevista, Tarefa.prioridade, Tarefa.dataIni, Tarefa.id as id
             FROM Tarefa
             INNER JOIN EquipeTarefa ON EquipeTarefa.tarefaID = Tarefa.id
             INNER JOIN Equipe on EquipeTarefa.EquipeID = Equipe.id
             WHERE Equipe.projetoID = $proj_id";
  $total_prioridade = 0;
  $total_status = 0;
  $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
    $total_prioridade += $row['prioridade'];
    $total_status += $row['prioridade'] * $row['status'];
  ?>
    <tr onclick="window.location='tarefa.php?<?php echo $row['id'];?>';" class="clickable">
      <td><?php echo $row['nome'];?></td>
      <td><?php echo $priority[$row['prioridade'] - 1];?></td>
      <td><?php echo $row['dataIni'];?></td>
      <td><?php echo $row['dataPrevista'];?></td>
      <td><?php echo $row['status'];?>%</td>
    </tr>
  <?php }
    $new_status = $total_status/($total_prioridade +0.00000001);
    
    $update_status = "UPDATE Projeto
                SET status= $new_status
                WHERE Projeto.id = $proj_id";

    mysqli_query($mysqli, $update_status);
  ?>
    </table>
  </div>
</body>
<script>
  function addColab() {
    document.getElementById("colabs").style.display = "";
    document.getElementById("add_colab").style.display = "none";
  };
</script>
</html>
