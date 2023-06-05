<?php $tarefa_id = parse_url("$_SERVER[REQUEST_URI]", PHP_URL_QUERY);?>

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
<?php include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $feito_id = $_POST['feito'];
  ?><script>console.log(<?php echo $feito_id;?>);</script><?php
    
    $update_feito = "UPDATE EquipeTarefa
                SET parteFeita= IF(parteFeita,0,1)
                WHERE tarefaID = $tarefa_id AND colaboradorID = $feito_id";

    mysqli_query($mysqli, $update_feito);
}?>

<div class="navbar">
  <ul>
    <li><a href="/projeto.php?1"  style="font-size: 35px;margin:10px;">←</a></li>
    <li class="title" style="width:90%;"><?php 
    $tarefa_name = "SELECT Tarefa.nome 
                  FROM Tarefa 
                  WHERE Tarefa.id = $tarefa_id";

    $name_r = mysqli_query($mysqli,$tarefa_name);
    echo mysqli_fetch_assoc($name_r)['nome'];?></li>
    <li class ="button"><a href="/excluir.php?<?php echo $tarefa_id?>">Excluir Tarefa</a></li>
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
  $totalcolabs = mysqli_num_rows($resultado);
  $soma_feitos = 0;
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
  <?php $soma_feitos += $row['parteFeita'];}?>
    <tr><td colspan="3" style="text-align-last: center;">Adicionar Colaborador</td></tr>
    </table>
    <br><br><br>
  </div>

  <div class="table-container2">
  <?php

  $result = "SELECT distinct Tarefa.nome, Tarefa.status, Tarefa.dataPrevista, Tarefa.prioridade, Tarefa.dataIni, Tarefa.id, Tarefa.dataFim, Tarefa.Descricao, Tarefa.CategoriaTarefaID
             FROM Tarefa
             INNER JOIN EquipeTarefa ON EquipeTarefa.tarefaID = Tarefa.id
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
    <li>Prioridade: <?php echo $row['prioridade'] ?></li>
    <li>Categoria da Tarefa: <?php echo $row['CategoriaTarefaID'] ?></li>
  </ul>
  </div>
  
  </div>
  <div>
  <p>Status: <?php echo $row['status'] ?></p>
  <input type="range" min="0" max="100" id="status" name="status" value=<?php echo $row['status'] ?>> 
  </div>
  <div id="novoDepartamento" style="display: none;">
      <label for="departamentoNovo">Novo campo:</label>
      <input type="text" id="departamentoNovo" name="departamentoNovo">
    </div>
</body>
<script>
  function refresh_DB(teste) {
    // Criar update do banco de dados
    var checks = <?php echo $soma_feitos; ?>;
    var total_colabs = <?php echo $totalcolabs; ?>;
    var fraction = 100 * checks / total_colabs;

    document.getElementById("status").value = fraction;
    console.log(fraction);
  }
</script>
</html>
