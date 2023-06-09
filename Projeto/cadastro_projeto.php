<?php
include("conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $nome = $_POST['nome'];
  $status = 0;
  $descricao = $_POST['descricao'];
  $dataInicio = $_POST['dataInicio'];
  $dataPrevista = $_POST['dataPrevista'];
  $fk_Cliente_id = $_POST['fk_Cliente_id'];

  // Insert the data into the database
  $insert_query = "INSERT INTO Projeto (nome, status, descricao, dataInicio, dataPrevista, clienteID) 
                   VALUES ('$nome', '$status', '$descricao', '$dataInicio', '$dataPrevista', '$fk_Cliente_id')";
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
  <title>Cadastro de Projeto</title>
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
    <a href="/">←</a>
  </div>
  <form method="POST" action="">
    <h2>Cadastro de Projeto</h2>
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" required></textarea>

    <label for="dataInicio">Data de Início:</label>
    <input type="date" id="dataInicio" name="dataInicio" required>

    <label for="dataPrevista">Data de Entrega:</label>
    <input type="date" id="dataPrevista" name="dataPrevista" required>

    <label for="clienteNome">Cliente:</label>
    <select type="text" id="fk_Cliente_id" name="fk_Cliente_id" required>
      <?php
        $result = "SELECT Cliente.nome, Cliente.id from Cliente";
        $resultado = mysqli_query($mysqli, $result);
        while($row = mysqli_fetch_assoc($resultado)){
        ?>
        <option value = "<?php echo $row['id']; ?>"><?php echo $row['nome'];?> </option>

      <?php } ?>
    </select>

    <input type="submit" value="Cadastrar">
  </form>
</body>
</html>
