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

    .botao {
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

    .disabled-button {
      cursor: default;
      opacity: 0.6;
    }

  </style>
</head>
<body>
<?php include("conexao.php");
  $result = "SELECT SUM(multi) / SUM(prioridade) AS status
            FROM (SELECT distinct (Tarefa.status * Tarefa.prioridade) as multi, Tarefa.prioridade
                  FROM Tarefa
                  INNER JOIN EquipeTarefa ON EquipeTarefa.tarefaID = Tarefa.id
                  INNER JOIN Equipe on EquipeTarefa.EquipeID = Equipe.id
                  INNER JOIN projeto on projeto.id = equipe.projetoID
                  WHERE projeto.id = $proj_id
                  GROUP BY tarefa.prioridade) AS result";
                  
  $resultado = mysqli_query($mysqli, $result);
  $row = mysqli_fetch_assoc($resultado);
  $new_status = $row['status'];
  if($new_status == NULL) $new_status = 0;

  $update_status = "UPDATE Projeto SET status= $new_status WHERE Projeto.id = $proj_id";
  mysqli_query($mysqli, $update_status);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(!empty($_POST['colab_select'])){
    $add_colab = $_POST['colab_select'];

    $insert_colab = "INSERT INTO Equipe (id,projetoID,colaboradorID) 
                    values ('$proj_id','$proj_id','$add_colab')";
    $result_colab = mysqli_query($mysqli, $insert_colab);
  }else{
    $currentDate = date('Y-m-d');
    $date_insert = "UPDATE Projeto
                    SET dataFim='$currentDate'
                    WHERE id=$proj_id";
    mysqli_query($mysqli,$date_insert);
  }
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
    <li class ="botao"><a href="/cadastro_tarefa.php?<?php echo $proj_id?>">Nova Tarefa</a></li>
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
        $result ="SELECT colaborador.id AS id, colaborador.nome AS nome FROM colaborador
                  WHERE id not in (SELECT equipe.colaboradorID FROM equipe WHERE projetoID = $proj_id)";
        $resultado = mysqli_query($mysqli, $result);
        while($row = mysqli_fetch_assoc($resultado)){
        ?>
        <option value = "<?php echo $row['id']; ?>"><?php echo $row['nome'];?> </option>

        <?php } ?>
      </select>
      </form>
    </td></tr>
    </table>
    <br>
    <?php
      $proj_name = "SELECT Projeto.descricao, Projeto.status 
      FROM Projeto 
      WHERE Projeto.id = $proj_id";

      $name_r = mysqli_query($mysqli,$proj_name);
      $proj_result = mysqli_fetch_assoc($name_r);?>
    <div  style="background: #F2F2F2;border-radius: 2 px;margin-top: 20px;min-height: 100px;padding: 10px">
      <b>Descrição do Projeto: </b><?php echo $proj_result['descricao']?>
    </div>
    <br>
    <div>
      <p>Status: <?php echo $proj_result['status'] ?>%</p>
      <progress style="width: -webkit-fill-available;height: 36px;" id="file" max="100" value="<?php echo $proj_result['status'] ?>"></progress> 
    </div>
    <form method="POST" action="">
      <div style="display: flex; justify-content: center; align-items: center;">
        <button type="submit" class="button disabled-button" disabled="true" id="finalizar"> Finalizar Projeto </button>
      </div>
    </form>
  </div>

  <div class="table-container2">
    <table>
      <tr>
        <th>Tarefa</th>
        <th>Prioridade</th>
        <th># Colaboradores</th>
        <th>Data Final</th>
        <th>Status</th>
      </tr>
      <?php
  $result = "SELECT distinct Tarefa.nome, Tarefa.status, Tarefa.dataPrevista, Tarefa.prioridade, Tarefa.id as id, count(EquipeTarefa.colaboradorID) as quantColab 
             FROM Tarefa
             INNER JOIN EquipeTarefa ON EquipeTarefa.tarefaID = Tarefa.id
             WHERE EquipeTarefa.projetoID = $proj_id
             GROUP BY Tarefa.nome, Tarefa.status, Tarefa.dataPrevista, Tarefa.prioridade, id";
  $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
  ?>
    <tr onclick="window.location='tarefa.php?<?php echo $row['id'];?>';" class="clickable">
      <td><?php echo $row['nome'];?></td>
      <td><?php echo $priority[$row['prioridade'] - 1];?></td>
      <td><?php echo $row['quantColab'];?></td>
      <td><?php echo $row['dataPrevista'];?></td>
      <td><?php echo $row['status'];?>%</td>
    </tr>
  <?php }?>
    </table>
    <?php
    $SelectQueryQuantTF = "SELECT nome, count(TarefaFeita) AS quantTarefaFeita 
                           FROM (
                           SELECT DISTINCT Projeto.nome AS nome, Tarefa.id AS TarefaFeita
                           FROM Projeto
                           INNER JOIN Equipe ON Projeto.id = Equipe.projetoID
                           INNER JOIN EquipeTarefa ON Equipe.id = EquipeTarefa.equipeID
                           INNER JOIN Tarefa ON EquipeTarefa.tarefaID = Tarefa.id
                           WHERE Tarefa.status = 100 AND EquipeTarefa.projetoID = $proj_id) AS tabela
                           GROUP BY nome";
    $selectQuantTF = mysqli_query($mysqli,$SelectQueryQuantTF);
    while($rowQTF = mysqli_fetch_assoc($selectQuantTF)){ ?>
      <p> Total de tarefas feitas: <?php echo $rowQTF['quantTarefaFeita']; ?> <p>
    <?php } ?>
  </div>
</body>
<script>
  if(<?php echo $proj_result['status'] ?> >= 99){
    document.getElementById("finalizar").disabled = false;
    document.getElementById("finalizar").classList.remove('disabled-button');
  }
  function addColab() {
    document.getElementById("colabs").style.display = "";
    document.getElementById("add_colab").style.display = "none";
  };
</script>
</html>
