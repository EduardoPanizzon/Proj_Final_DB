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
      top: 0px;
      left: 0px;
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
                <input name="nome" value="<?php echo $row['nome']?>">
                </div>
                <div class="attribute">
                <label>Email:</label>
                <input name="email" value="<?php echo $row['email']?>">                
                </div>
                <div class="attribute">
                <label>Telefone:</label>
                <input name="telefone" value="<?php echo $row['telefone']?>">                
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
                </select>
                </div>
                <div class="attribute">
                <label>Cargo:</label>
                <select id="cargo" name="cargo" required>
                    <?php
                    $cargoID = $row['cargoID'];
                    $selectQueryCargo = "SELECT Cargo.id, Cargo.nome from Cargo ORDER BY id != '$cargoID', id";
                    $selectCargo = mysqli_query($mysqli, $selectQueryCargo);
                    while($rowCargo = mysqli_fetch_assoc($selectCargo)){
                    ?>
                    <option value = "<?php echo $rowCargo['id']; ?>"><?php echo $rowCargo['nome'];?> </option>

                    <?php } ?>
                </select>
                </div>
                <button type= "submit">Editar</button>
            <?php }?>
            

        </div>
    </form>
  
</body>
</html>
