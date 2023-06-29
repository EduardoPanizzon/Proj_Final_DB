<?php
include("conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $cep = $_POST['cep'];

  $insertQueryCliente = "INSERT INTO Cliente(nome, email, telefone, cep) VALUES ('$nome','$email','$telefone','$cep')";
  $insertCliente = mysqli_query($mysqli, $insertQueryCliente);

  

  header("Location: ../index.php");
  exit;
  
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Cadastro de Cliente</title>
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
    <h2>Cadastro de Cliente</h2>
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone" required>

    <label for="cep">cep:</label>
    <input type="text" id="cep" name="cep" required>

    <input type="submit" value="Cadastrar">
  </form>
</body>
</html>
