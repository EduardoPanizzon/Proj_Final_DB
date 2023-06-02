<?php $proj_id = parse_url("$_SERVER[REQUEST_URI]", PHP_URL_QUERY);?>

<?php
include("conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $prioridade = $_POST['prioridade'];
  $dataInicio = $_POST['dataInicio'];
  $dataPrevista = $_POST['dataPrevista'];
  $status = $_POST['status'];
  $categoriaId = $_POST['categoriaId'];
  $colabs = $_POST['colabs'];

  if($categoriaId == "outro"){
    $dep = $_POST['departamentoNovo'];

    $insert_query1 = "INSERT INTO CategoriaTarefa (nome, id)
    VALUES ('$dep', '')";
    $insert_result1 = mysqli_query($mysqli, $insert_query1);

    //Retorna o ultimo id inserido
    $teste = "SELECT @@identity";
    $teste_result = mysqli_query($mysqli, $teste);
    $categoriaId = mysqli_fetch_assoc($teste_result)['@@identity'];
    echo $categoriaId;

    if (!$insert_result1) {
      echo "Registration failed. Please try again.";
    }
  }

  // Insert the data into the database
  $insert_query = "INSERT INTO Tarefa (nome, descricao, prioridade, dataIni, dataPrevista, status, categoriaTarefaID) 
                   VALUES ('$nome', '$descricao', '$prioridade','$dataInicio', '$dataPrevista', '$status','$categoriaId')";
  $insert_result = mysqli_query($mysqli, $insert_query);
  $teste = "SELECT @@identity";
  $teste_result = mysqli_query($mysqli, $teste);
  $TarefaId = mysqli_fetch_assoc($teste_result)['@@identity'];
  echo $TarefaId;

  $insert_equipetarefa  = "INSERT INTO EquipeTarefa (equipeID,tarefaID,projetoID,colaboradorID) 
                        values ('$proj_id','$TarefaId','$proj_id','$colabs')";
  $result_equipetarefa = mysqli_query($mysqli, $insert_equipetarefa);

  if (!$result_equipetarefa) {
    echo "Registration failed. Please try again.";
  }


  if ($insert_result) {
    header("Location: ../projeto.php?$proj_id");
    exit;
  } else {
    echo "Registration failed. Please try again.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Cadastro de Nova Tarefa</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f2f2f2;
      border-radius: 5px;
    }

    h2 {
      text-align: center;
    }

    label {
      display: block;
      margin-top: 10px;
    }

    input[type="text"],
    input[type="date"],
    textarea {
      width: 100%;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      margin-top: 5px;
      resize: vertical;
    }

    input[type="submit"] {
      width: 100%;
      background-color: #4CAF50;
      color: white;
      padding: 10px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      background-color: #45a049;
      margin-top: 15px;
    }

    a {
      color: black;
      font-size: 30px;
      text-decoration: none;

    }
  </style>
</head>
<body>
  <div>
    <a href="/projeto.php?<?php echo $proj_id;?>">←</a>
  </div>
  <form method="POST" action="">
    <h2>Cadastro de Nova Tarefa</h2>
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" required></textarea>

    <label for="prioridade">Prioridade:</label>
    <select type="text" id="prioridade" name="prioridade" required>
      <?php
        $priority=array("Baixa","Media","Alta","Super Alta");
        $i = 0;
        while($i < 4){
        ?>
        <option value = "<?php echo $i;?>"><?php echo $priority[$i];$i++;?> </option>
      <?php } ?>
    </select>

    <label for="dataInicio">Data Inicio:</label>
    <input type="date" id="dataInicio" name="dataInicio" required>
    
    <label for="dataPrevista">Data Final:</label>
    <input type="date" id="dataPrevista" name="dataPrevista" required>

    <label for="status">Status: <output id = "statusValue"></output>  </label>
    <input type="range" min="0" max="100" id="status" name="status" value="0" required> 

    <label for="categoriaIdd">Categoria:</label>
    <select id="categoriaId" name="categoriaId" onchange="novaCategoria()" required>
      <option>Escolha...</option>
      <?php
      $result = "SELECT CategoriaTarefa.id, CategoriaTarefa.nome from CategoriaTarefa";
      $resultado = mysqli_query($mysqli, $result);
      while($row = mysqli_fetch_assoc($resultado)){
      ?>
      <option value = "<?php echo $row['id']; ?>"><?php echo $row['nome'];?> </option>

      <?php } ?>
      <option value="outro">Outro</option>
      </select>

      <div id="novoDepartamento" style="display: none;">
      <label for="departamentoNovo">Novo campo:</label>
      <input type="text" id="departamentoNovo" name="departamentoNovo">
      </div>

      <label for="colabs">Categoria:</label>
    <select id="colabs" name="colabs" onchange="" required>
      <option>Escolha...</option>
      <?php
      $result = "SELECT Equipe.projetoID, colaborador.nome FROM Equipe 
                 INNER JOIN Colaborador ON Equipe.colaboradorID = Colaborador.id 
                 WHERE Equipe.projetoID = $proj_id";
      $resultado = mysqli_query($mysqli, $result);
      while($row = mysqli_fetch_assoc($resultado)){
      ?>
      <option value = "<?php echo $row['projetoID']; ?>"><?php echo $row['nome'];?> </option>

      <?php } ?>
      </select>
      <div id="novoDepartamento" style="display:;">
      <label for="departamentoNovo">Novo campo:</label>
      <input type="text" id="departamentoNovo" name="departamentoNovo">
      </div>
    

    <input type="submit" value="Cadastrar">
  </form>
</body>
<script>
  function novaCategoria() {
    var select = document.getElementById("categoriaId");
    var valorSelecionado = select.value;

    if (valorSelecionado === "outro") {
      document.getElementById("novoDepartamento").style.display = "block";
    } else {
      document.getElementById("novoDepartamento").style.display = "none";
    }
  }

const value = document.querySelector("#statusValue")
const input = document.querySelector("#status")
value.textContent = input.value
input.addEventListener("input", (event) => {
  value.textContent = event.target.value
})
</script>
</html>

