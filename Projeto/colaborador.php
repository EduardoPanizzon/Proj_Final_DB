<?php 
include("conexao.php");
$colabID = parse_url("$_SERVER[REQUEST_URI]", PHP_URL_QUERY);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $dep = $_POST['dep'];
    $cargo = $_POST['cargo'];
    

    if($dep == "outro"){
      $dep = $_POST['departamentoNovo'];

      $insert_query1 = "INSERT INTO Departamento (nome, descricao) 
      VALUES ('$dep','')";
      $insert_result1 = mysqli_query($mysqli, $insert_query1);

      if (!$insert_result1) {
      echo "Registration failed. Please try again.1";
      }
      $insert_query2 = "SELECT max(id) AS id FROM Departamento";
      $insert_result2 = mysqli_query($mysqli, $insert_query2);
      while($row2 = mysqli_fetch_assoc($insert_result2)){
      $dep = $row2['id'];
      }
    }
  if($cargo == "outro"){
    $cargo = $_POST['cargoNovo'];

    $insertQueryCargo = "INSERT INTO Cargo (nome) 
    VALUES ('$cargo')";
    $insertCargo = mysqli_query($mysqli, $insertQueryCargo);

    if (!$insertCargo) {
    echo "Registration failed. Please try again.1";
    }
    $selectQueryCargo = "SELECT max(id) AS id FROM Cargo";
    $selectCargo = mysqli_query($mysqli, $selectQueryCargo);
    while($rowCargo = mysqli_fetch_assoc($selectCargo)){
    $cargo = $rowCargo['id'];
    }
  }

    //Procurando o id do Departamento
    $updateQueryColaborador = "UPDATE Colaborador
                                SET nome='$nome', email='$email', telefone='$telefone', departamentoID='$dep', cargoID='$cargo'
                                WHERE id='$id'";
    $updateColaborador = mysqli_query($mysqli,$updateQueryColaborador);

    if (!$updateColaborador) {
        echo "Registration failed. Please try again.";
    }else{
      header("Location: ../");
      exit;
    }
}


?>
<!DOCTYPE html>
<html>
<head>
  <title>Perfil</title>
  <style>
   body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    
    .profile {
      width: 100%;
      max-width: 600px;
      background-color: #fff;
      padding: 40px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .profile h2 {
      margin-top: 0;
    }
    
    .profile label {
      font-weight: bold;
    }
    
    .profile .attribute {
      margin-bottom: 10px;
    }
    
    .profile input[type="text"],
    .profile input[type="email"],
    .profile input[type="tel"],
    .profile select {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      box-sizing: border-box;
      margin-bottom: 10px;
      background-color: #f5f5f5;
      border: 1px solid #ccc;
    }
    
    .profile input[type="text"]:focus,
    .profile input[type="email"]:focus,
    .profile input[type="tel"]:focus,
    .profile select:focus {
      outline: none;
      border-color: #4CAF50;
    }
    
    .profile button {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    
    .profile button:hover {
      background-color: #45a049;
    }
    
    a {
      position: absolute;
      top: 0;
      left: 0;
      width: 40px;
      height: 40px;
      color: black;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
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
        <div class="profile">
            <?php
            $selectQueryColab = "SELECT Colaborador.id as colabID, Colaborador.nome as nome, email, telefone, Departamento.nome as dep,Departamento.id as depID, Cargo.nome as cargo, Cargo.id as cargoID
                                FROM Colaborador
                                INNER JOIN Departamento ON Departamento.id = Colaborador.departamentoID
                                INNER JOIN Cargo ON Cargo.id = Colaborador.cargoID
                                WHERE Colaborador.id = $colabID";
            $selectColab = mysqli_query($mysqli, $selectQueryColab);
            while($row = mysqli_fetch_assoc($selectColab)){?>
                <h2>Perfil</h2>
                <div class="attribute">
                <input name="id" value="<?php echo $row['colabID']?>" style="display:none">
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo $row['nome']?>">
                </div>
                <div class="attribute">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $row['email']?>">                
                </div>
                <div class="attribute">
                <label>Telefone:</label>
                <input type="tel" name="telefone" value="<?php echo $row['telefone']?>">                
                </div>
                <div class="attribute">
                <label>Departamento:</label>
                <select id="dep" name="dep" onchange="outroDepartamento()" required>
                    <?php
                    $depID = $row['depID'];
                    echo $depID;
                    $result = "SELECT Departamento.id, Departamento.nome from Departamento ORDER BY id != '$depID', id";
                    $resultado = mysqli_query($mysqli, $result);
                    while($row2 = mysqli_fetch_assoc($resultado)){
                    ?>
                    <option value = "<?php echo $row2['id']; ?>"><?php echo $row2['nome'];?> </option>

                    <?php } ?>
                    <option value="outro">Outro</option>
                </select>

                <div id="novoDepartamento" style="display: none;">
                  <br>
                  <label for="departamentoNovo">Outro:</label>
                  <input type="text" id="departamentoNovo" name="departamentoNovo">
                  <br>
                </div>
                </div>
                <div class="attribute">
                <label>Cargo:</label>
                <select id="cargo" name="cargo" onchange="outroCargo()" required>
                    <?php
                    $cargoID = $row['cargoID'];
                    $selectQueryCargo = "SELECT Cargo.id, Cargo.nome from Cargo ORDER BY id != '$cargoID', id";
                    $selectCargo = mysqli_query($mysqli, $selectQueryCargo);
                    while($rowCargo = mysqli_fetch_assoc($selectCargo)){
                    ?>
                    <option value = "<?php echo $rowCargo['id']; ?>"><?php echo $rowCargo['nome'];?> </option>

                    <?php } ?>
                    <option value="outro">Outro</option>
                </select>
                <div id="novoCargo" style="display: none;">
                <br>
                  <label for="cargoNovo">Cargo:</label>
                  <input type="text" id="cargoNovo" name="cargoNovo">
                </div>
                </div>
                
            <?php }?>
            <button type= "submit">Editar</button>
        </div>
        
    </form>
  
</body>
<script>
  function outroDepartamento() {
    var select = document.getElementById("dep");
    var valorSelecionado = select.value;
    
    if (valorSelecionado === "outro") {
      document.getElementById("novoDepartamento").style.display = "block";
    } else {
      document.getElementById("novoDepartamento").style.display = "none";
    }
  }
  function outroCargo() {
    var select = document.getElementById("cargo");
    var valorSelecionado = select.value;
    
    if (valorSelecionado === "outro") {
      document.getElementById("novoCargo").style.display = "block";
    } else {
      document.getElementById("novoCargo").style.display = "none";
    }
  }
</script>
</html>
