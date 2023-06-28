<?php include("conexao.php");
  $tarefa_id = parse_url("$_SERVER[REQUEST_URI]", PHP_URL_QUERY);

  $select_proj_id = "SELECT EquipeTarefa.projetoID FROM EquipeTarefa WHERE EquipeTarefa.tarefaID = $tarefa_id";
  $resultado_proj_id = mysqli_query($mysqli, $select_proj_id);
  $proj_id = mysqli_fetch_assoc($resultado_proj_id)['projetoID'];

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

    ul {
      list-style-type: none;
    }

    .navbar ul {
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

    .buttonf {
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
      cursor: pointer;
    }

  </style>
</head>
<body>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  if(array_key_exists('feito', $_POST)){
    $feito_id = $_POST['feito'];

    $update_feito = "UPDATE EquipeTarefa
                SET parteFeita= IF(parteFeita,0,1)
                WHERE tarefaID = $tarefa_id AND colaboradorID = $feito_id";
    mysqli_query($mysqli, $update_feito);
  }else if(array_key_exists('colab_select', $_POST)){
    $add_colab = $_POST['colab_select'];
    $insert_colab = "INSERT INTO EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID) 
                    values ('$proj_id','$tarefa_id','$proj_id','$add_colab')";
    $result_colab = mysqli_query($mysqli, $insert_colab);
  }else if(array_key_exists('finalizar', $_POST)){
    $currentDate = date('Y-m-d');
    $date_insert = "UPDATE Tarefa
                    SET dataFim='$currentDate'
                    WHERE id=$tarefa_id";
    mysqli_query($mysqli,$date_insert);
  }else{
    $delete_equipetarefa = "DELETE FROM equipetarefa WHERE tarefaID = $tarefa_id";
    $result_delete = mysqli_query($mysqli,$delete_equipetarefa);

    $delete_tarefa = "DELETE FROM tarefa WHERE id = $tarefa_id";
    $result_delete = mysqli_query($mysqli,$delete_tarefa);
    header("Location: ../projeto.php?$proj_id");
  }

  $result = "SELECT Colaborador.nome AS nome, Cargo.nome AS cargo, Colaborador.id, EquipeTarefa.parteFeita
  FROM EquipeTarefa
  INNER JOIN Colaborador ON EquipeTarefa.colaboradorID = Colaborador.id
  INNER JOIN Cargo on Colaborador.cargoID = Cargo.id
  WHERE tarefaID = $tarefa_id";

  $resultado = mysqli_query($mysqli, $result);

  $totalcolabs = mysqli_num_rows($resultado);
  $soma_feitos = 0;
  while($row = mysqli_fetch_assoc($resultado)){
    $soma_feitos += $row['parteFeita'];
  }
  $newstatus = 100 * $soma_feitos/$totalcolabs;

  $update_status = "UPDATE tarefa SET status = $newstatus WHERE tarefa.id = $tarefa_id";
  mysqli_query($mysqli,$update_status);

}?>

<div class="navbar">
  <ul>
    <li><a href="/projeto.php?<?php echo $proj_id?>"  style="font-size: 35px;margin:10px;">←</a></li>
    <li class="title" style="width:90%;"><?php 
    $tarefa_name = "SELECT Tarefa.nome 
                  FROM Tarefa 
                  WHERE Tarefa.id = $tarefa_id";

    $name_r = mysqli_query($mysqli,$tarefa_name);
    echo mysqli_fetch_assoc($name_r)['nome'];?></li>
    <form method="POST" action="" id="form-id">
    <li class ="button" ><a onclick="document.getElementById('form-id').submit();">Excluir Tarefa</a></li>
    </form>
    </ul>
  </div>
  <div class="table-container">
    <table>
      <div class="navbar" style="padding-left: 10px;display:flex;">Colaboradores da Tarefa</div>
      <tr>
        <th>Nome</th>
        <th>Cargo</th>
        <th>Feito</th>
      </tr>
      <?php

  $result = "SELECT Colaborador.nome AS nome, Cargo.nome AS cargo, Colaborador.id, EquipeTarefa.parteFeita
             FROM EquipeTarefa
             INNER JOIN Colaborador ON EquipeTarefa.colaboradorID = Colaborador.id
             INNER JOIN Cargo on Colaborador.cargoID = Cargo.id
             WHERE tarefaID = $tarefa_id";

  $resultado = mysqli_query($mysqli, $result);
  while($row = mysqli_fetch_assoc($resultado)){
  ?>
    <tr>
      <td><?php echo $row['nome'];?></td>
      <td><?php echo $row['cargo'];?></td>
      <td>
      <form method="POST" action="">
        <input type="hidden" id="feito" name="feito" value=<?php echo $row['id'];?>>
        <input type="checkbox" id="feito" name="feito" value=<?php echo $row['id'];?>  onChange="this.form.submit()" <?php if($row['parteFeita']) echo "checked"; ?>>
      </form>
      </td>
    </tr>
  <?php }?>
    <tr id="add_colab" name="add_colab" onclick="addColab()"><td colspan="3" style="text-align-last: center;">Adicionar Colaborador</td></tr>
    <tr id="colabs" name="colabs" style="display:none"><td colspan="3" style="text-align-last: center;">
      <form method="POST" action="">
      <select id="colab_select" name="colab_select" onChange="this.form.submit()">
        <option>Escolha...</option>
        <?php
        $result ="SELECT colaborador.id AS id, colaborador.nome AS nome FROM equipe
                  INNER JOIN Colaborador ON equipe.colaboradorID = Colaborador.id
                  WHERE projetoID = $proj_id
                  AND colaborador.id not in( 
                  SELECT colaborador.id FROM EquipeTarefa 
                  INNER JOIN Colaborador ON EquipeTarefa.colaboradorID = Colaborador.id 
                  WHERE tarefaID = $tarefa_id)";
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
    <form method="POST" action="">
      <div style="display: flex; justify-content: center; align-items: center;">
        <button type="submit" class="buttonf disabled-button" disabled="true" id="finalizar" name="finalizar"> Finalizar Tarefa </button>
      </div>
    </form>
    <br><br>
  </div>

  <div class="table-container2">
  <?php

  $result = "SELECT distinct Tarefa.nome, Tarefa.status, Tarefa.dataPrevista, Tarefa.prioridade, Tarefa.dataIni, Tarefa.id, Tarefa.dataFim, Tarefa.Descricao, Tarefa.CategoriaTarefaID, CategoriaTarefa.nome as nomecategoria
             FROM Tarefa
             INNER JOIN EquipeTarefa ON EquipeTarefa.tarefaID = Tarefa.id
             INNER JOIN CategoriaTarefa ON CategoriaTarefa.id = Tarefa.CategoriaTarefaID
             WHERE Tarefa.id = $tarefa_id";

  $resultado = mysqli_query($mysqli, $result);
  $row = mysqli_fetch_assoc($resultado)
  ?>

  <div class="table-container2" style="background: #F2F2F2;border-radius: 2 px;">
    <div style="height: 180px;"><b>Descrição da Tarefa: </b><?php echo $row['Descricao'] ?></div>
  </div>
  <div class="table-container" >
    <ul style="margin: 0;height: 180px;padding: inherit;padding-top: 0;" ><b>Datas: </b>
    <li>Data Início: <?php echo $row['dataIni'] ?></li>
    <li>Data Final: <?php echo $row['dataPrevista'] ?></li>
    <li>Data Encerramento: <?php echo $row['dataFim'] ?></li>
    <br>
    <li>Prioridade: <?php echo $priority[$row['prioridade'] - 1] ?></li>
    <li>Categoria: <?php echo $row['nomecategoria'] ?></li>
  </ul>
  </div>
  <div class="table-container2">
    <p>Status: <?php echo $row['status'] ?></p>
    <progress style="width: -webkit-fill-available;height: 36px;" id="file" max="100" value="<?php echo $row['status'] ?>"></progress> 
  </div>
  </div>
</body>
<script>
  if(<?php echo $row['status'] ?> >= 99){
    document.getElementById("finalizar").disabled = false;
    document.getElementById("finalizar").classList.remove('disabled-button');
  }
  function addColab() {
    document.getElementById("colabs").style.display = "";
    document.getElementById("add_colab").style.display = "none";
  };
</script>
</html>


<!-- SELECT DISTINCT equipe.projetoID FROM `equipetarefa` INNER JOIN equipe ON equipeID = equipe.id WHERE tarefaID = 2; -->