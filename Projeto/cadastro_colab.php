<?php
include("conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $fk_Departamento_id = $_POST['fk_Departamento_id'];
  $fk_Cargo_id = $_POST['cargo'];

  if($fk_Departamento_id == "outro"){
    $dep = $_POST['departamentoNovo'];

    $insert_query1 = "INSERT INTO Departamento (nome, descricao) 
    VALUES ('$dep','')";
    $insert_result1 = mysqli_query($mysqli, $insert_query1);

    if (!$insert_result1) {
      echo "Registration failed. Please try again.";
    }
    $insert_query2 = "SELECT max(id) AS id FROM Departamento";
    $insert_result2 = mysqli_query($mysqli, $insert_query2);
    while($row2 = mysqli_fetch_assoc($insert_result2)){
      $fk_Departamento_id = $row2['id'];
    }
  }
  // Insert the data into the database
  $insert_query = "INSERT INTO Colaborador (nome, email, telefone, departamentoID, cargoID) 
                   VALUES ('$nome', '$email', '$telefone', '$fk_Departamento_id', '$fk_Cargo_id')";
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
    <h2>Cadastro de Colaborador</h2>
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="cargo">Cargo:</label>
    <select id="cargo" name="cargo" required>
      <option>Escolha...</option>
      <?php
      $resultCargo = "SELECT Cargo.id, Cargo.nome from Cargo";
      $resultadoCargo = mysqli_query($mysqli, $resultCargo);
      while($rowCargo = mysqli_fetch_assoc($resultadoCargo)){
      ?>
      <option value = "<?php echo $rowCargo['id']; ?>"><?php echo $rowCargo['nome'];?> </option>

      <?php } ?>
    </select>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone" required>

    <label for="Departamento">Departamento:</label>
    <select id="fk_Departamento_id" name="fk_Departamento_id" onchange="outroDepartamento()" required>
      <option>Escolha...</option>
      <?php
      $result = "SELECT Departamento.id, Departamento.nome from Departamento";
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

    <input type="submit" value="Cadastrar">
  </form>
</body>
<script>
  function outroDepartamento() {
    var select = document.getElementById("fk_Departamento_id");
    var valorSelecionado = select.value;
    
    if (valorSelecionado === "outro") {
      document.getElementById("novoDepartamento").style.display = "block";
    } else {
      document.getElementById("novoDepartamento").style.display = "none";
    }
  }
</script>
</html>
