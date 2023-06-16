<?php
include("conexao.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_SESSION['nome'];
    $email = $_SESSION['email'];
    $telefone = $_SESSION['telefone'];
    $fk_Departamento_id = $_SESSION['fk_Departamento_id'];
    $fk_Cargo_id = $_SESSION['fk_Cargo_id'];
    $nivel = $_POST['nivel'];
    $esp = $_SESSION['cadEsp'];

    if($fk_Departamento_id == "outro"){
        $dep = $_SESSION['departamentoNovo'];

        $insert_query1 = "INSERT INTO Departamento (nome, descricao) 
        VALUES ('$dep','')";
        $insert_result1 = mysqli_query($mysqli, $insert_query1);

        if (!$insert_result1) {
        echo "Registration failed. Please try again.1";
        }
        $insert_query2 = "SELECT max(id) AS id FROM Departamento";
        $insert_result2 = mysqli_query($mysqli, $insert_query2);
        while($row2 = mysqli_fetch_assoc($insert_result2)){
        $fk_Departamento_id = $row2['id'];
        }
    }
    if($fk_Cargo_id == "outro"){
      $cargo = $_SESSION['cargoNovo'];

      $insertQueryCargo = "INSERT INTO Cargo (nome) 
      VALUES ('$cargo')";
      $insertCargo = mysqli_query($mysqli, $insertQueryCargo);

      if (!$insertCargo) {
      echo "Registration failed. Please try again.1";
      }
      $selectQueryCargo = "SELECT max(id) AS id FROM Cargo";
      $selectCargo = mysqli_query($mysqli, $selectQueryCargo);
      while($rowCargo = mysqli_fetch_assoc($selectCargo)){
      $fk_Cargo_id = $rowCargo['id'];
      }
    }
    //Insert the data into the databas 
    $insert_query = "INSERT INTO Colaborador (nome, email, telefone, departamentoID, cargoID) 
                    VALUES ('$nome', '$email', '$telefone', '$fk_Departamento_id', '$fk_Cargo_id')";
    $insert_result = mysqli_query($mysqli, $insert_query);

    if(!$insert_result){
        echo "Registration failed. Please try again.2";
    }
    
    $selectColabIDQuery = "SELECT max(id) AS id FROM Colaborador";
    $selectColabID = mysqli_query($mysqli, $selectColabIDQuery);
    while($row2 = mysqli_fetch_assoc($selectColabID)){
        $colabID = $row2['id'];
    }
    for($i = 0; $i < count($nivel); $i++){
        $especi = $esp[$i];
        $nvl= $nivel[$i];
        $insert_query3 = "INSERT INTO EspeciColab(especialidadeID, colaboradorID, nivel) 
        VALUES('$especi', '$colabID','$nvl')";
        $insert_result3 = mysqli_query($mysqli, $insert_query3);

        if(!$insert_result3){
            echo "erro esp";
        }

    }
    session_destroy();
    header("Location: ../");
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
      foreach($_SESSION['cadEsp'] as $esp){
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
