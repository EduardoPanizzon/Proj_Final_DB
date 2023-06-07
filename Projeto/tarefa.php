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
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  if(array_key_exists('feito', $_POST)){
    $feito_id = $_POST['feito'];

    $update_feito = "UPDATE EquipeTarefa
                SET parteFeita= IF(parteFeita,0,1)
                WHERE tarefaID = $tarefa_id AND colaboradorID = $feito_id";
    mysqli_query($mysqli, $update_feito);
  }
  if(array_key_exists('colab_select', $_POST)){
    $add_colab = $_POST['colab_select'];
    $insert_colab = "INSERT INTO EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID) 
                    values ('$proj_id','$tarefa_id','$proj_id','$add_colab')";
    $result_colab = mysqli_query($mysqli, $insert_colab);
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
    <li class ="button" onclick="deleteTarefa()"><a href="/projeto.php?<?php echo $proj_id?>">Excluir Tarefa</a></li>
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
                    EXCEPT
                  SELECT colaborador.id AS id, colaborador.nome AS nome FROM EquipeTarefa
                  INNER JOIN Colaborador ON EquipeTarefa.colaboradorID = Colaborador.id
                  WHERE tarefaID = $tarefa_id";
        $resultado = mysqli_query($mysqli, $result);
        while($row = mysqli_fetch_assoc($resultado)){
        ?>
        <option value = "<?php echo $row['id']; ?>"><?php echo $row['nome'];?> </option>

        <?php } ?>
      </select>
      </form>
    </td></tr>
    </table>
    <br><br><br>
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

  <div class="table-container2">
    <div><?php echo $row['Descricao'] ?> <br><br><br><br><br><br><br><br><br><br><br></div>
  </div>
  <div class="table-container1">
    <ul>Datas:
    <li>Data inicio: <?php echo $row['dataIni'] ?></li>
    <li>Data Final: <?php echo $row['dataPrevista'] ?></li>
    <li>Data De Encerramento: <?php echo $row['dataFim'] ?></li>
    <br>
    <li>Prioridade: <?php echo $priority[$row['prioridade'] - 1] ?></li>
    <li>Categoria da Tarefa: <?php echo $row['nomecategoria'] ?></li>
  </ul>
  </div>
  
  </div>
  <div>
  <p>Status: <?php echo $row['status'] ?></p>
  <progress id="file" max="100" value="<?php echo $row['status'] ?>"></progress> 
  </div>
  <div id="novoDepartamento" style="display: none;">
      <label for="departamentoNovo">Novo campo:</label>
      <input type="text" id="departamentoNovo" name="departamentoNovo">
    </div>
</body>
<script>
  function addColab() {
    document.getElementById("colabs").style.display = "";
    document.getElementById("add_colab").style.display = "none";
  };
  function deleteTarefa(){
    console.log(<?php echo $tarefa_id;?>);
    <?php $delete_equipetarefa = "DELETE FROM equipetarefa WHERE tarefaID = $tarefa_id";
      $result_delete = mysqli_query($mysqli,$delete_equipetarefa);

      $delete_tarefa = "DELETE FROM tarefa WHERE id = $tarefa_id";
      $result_delete = mysqli_query($mysqli,$delete_tarefa);  
    
    ?>
    
  }
</script>
</html>


<!-- SELECT DISTINCT equipe.projetoID FROM `equipetarefa` INNER JOIN equipe ON equipeID = equipe.id WHERE tarefaID = 2; -->