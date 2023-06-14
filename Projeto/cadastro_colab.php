<?php
include("conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $_SESSION['nome'] = $_POST['nome'];
  $_SESSION['email'] = $_POST['email'];
  $_SESSION['telefone'] = $_POST['telefone'];
  $_SESSION['fk_Departamento_id'] = $_POST['fk_Departamento_id'];
  $_SESSION['fk_Cargo_id'] = $_POST['cargo'];
  $_SESSION['cadEsp'] = $_POST['esp'];
  $_SESSION['departamentoNovo'] = $_POST['departamentoNovo'];

  header("Location: ../cadastro_colabEsp.php");
  exit;
  
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
    
      <div class="input-group">
        <label for="esp">Especialidades</label>
        <select name="esp[]" multiple>
          <?php
          $selectQueryEsp = "SELECT Especialidade.id as id, Especialidade.nome as nome FROM Especialidade";
          $selectEsp = mysqli_query($mysqli, $selectQueryEsp);
          while($rowEsp = mysqli_fetch_assoc($selectEsp)){?>

            <option value="<?php echo $rowEsp['id'];?>"> <?php echo $rowEsp['nome'];?> </option>
          
          <?php } ?>
        </select>
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
