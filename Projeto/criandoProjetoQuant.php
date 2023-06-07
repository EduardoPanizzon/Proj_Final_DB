<?php 
include("conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $_SESSION['nivel'] = $_POST['nivel'];

  header("Location: ../criandoProjetoFinal.php");
  exit;

}
?>
<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      background-color: #f2f2f2;
      font-family: "Arial", sans-serif;
    }
    
    .container {
      text-align: center;
    }
    
    input[type="text"], input[type="number"] {
      padding: 10px;
      width: 400px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 10px;
    }
    
    label {
      display: block;
      margin-bottom: 5px;
    }
    
    .submit-button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #333;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <form method="post"> <!-- Ação definida como exemplo, substitua pelo seu script de processamento -->
      <?php 
      
      foreach($_SESSION['esp'] as $esp){
      $selectQueryEspecialidade = "SELECT Especialidade.nome as nome FROM Especialidade where id = '$esp'";
      $selectEspecialidade = mysqli_query($mysqli, $selectQueryEspecialidade);
      while($rowEsp = mysqli_fetch_assoc($selectEspecialidade)){
      ?>
      
      <label for="colaboradores"><?php echo $rowEsp['nome'];?></label>
      <input type="number" id="nivel" name="nivel[]" placeholder="Digite aqui" step="1">
      
      <br>

      <?php }} ?>
      <button name= "btnNivel" type="submit" class="submit-button">Enviar</button>
    </form>
  </div>
</body>
</html>
