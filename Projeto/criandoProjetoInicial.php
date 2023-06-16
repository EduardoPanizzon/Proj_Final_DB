<?php
include("conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $_SESSION['projeto'] = $_POST['projeto'];
  if(!empty($_POST['esp'])){
    $_SESSION['esp'] = $_POST['esp'];
  
    header("Location: ../criandoProjetoQuant.php");
    exit;
  }else{
    header("Location: ../criandoProjetoFinal.php");
    exit;
  }
  
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
    
    .input-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 10px;
    }
    
    .input-group input,
    .input-group select {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-top: 5px;
    }
    
    .input-row {
      display: flex;
      justify-content: space-between;
    }
    
    .input-row .input-group {
      width: 48%;
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
    
    /* Estilo para o campo select */
    .input-group select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-color: #fff;
      background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23333'%3E%3Cpath d='M8 11L4 7h8l-4 4z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 12px;
      padding-right: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <form method="post" > <!-- Ação definida como exemplo, substitua pelo seu script de processamento -->
      <div class="input-group">
        <label for="projeto">Nome do Projeto:</label>
        <input type="text" id="projeto" name="projeto" placeholder="Digite aqui">
      </div>
      <div class="input-group">
        <label for="esp">Quais especialidades serão necessarias?:</label>
        <select name="esp[]" multiple>
          <?php
          $selectQueryEsp = "SELECT Especialidade.id as id, Especialidade.nome as nome FROM Especialidade";
          $selectEsp = mysqli_query($mysqli, $selectQueryEsp);
          while($rowEsp = mysqli_fetch_assoc($selectEsp)){?>

            <option value="<?php echo $rowEsp['id'];?>"> <?php echo $rowEsp['nome'];?> </option>
          
          <?php } ?>
        </select>
      </div>
      
      <button type="submit" class="submit-button">Enviar</button>
    </
