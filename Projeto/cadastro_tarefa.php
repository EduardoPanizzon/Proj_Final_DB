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

  // Insert the data into the database
  $insert_query = "INSERT INTO Tarefa (nome, descricao, prioridade, dataIni, dataPrevista, status, categoriaTarefaID) 
                   VALUES ('$nome', '$descricao', '$prioridade','$dataInicio', '$dataPrevista', '$status','$categoriaId')";
  $insert_result = mysqli_query($mysqli, $insert_query);

  if ($insert_result) {
    header("Location: ../");
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

    <label for="dataInicio">Prioridade:</label>
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

    <label for="categoriaId">Categoria:</label>
    <input type="text" id="categoriaId" name="categoriaId" required>

    <input type="submit" value="Cadastrar">
  </form>
</body>
<script>
  const value = document.querySelector("#statusValue")
const input = document.querySelector("#status")
value.textContent = input.value
input.addEventListener("input", (event) => {
  value.textContent = event.target.value
})
</script>
</html>

