<?php 
include("conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION['colaboradores'] = $_POST['colaboradores'];


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
        <?php $n_rows = count($_SESSION['nivel']);
        for($n_row = 0; $n_row < $n_rows; $n_row++){ 
            $this_esp =  $_SESSION['esp'][$n_row];
            $this_limit = $_SESSION['quant_colabs'][$n_row];
            $selectQueryEsp = "SELECT Especialidade.id as id, Especialidade.nome as nome FROM Especialidade WHERE id = $this_esp";
            $selectEsp = mysqli_query($mysqli, $selectQueryEsp);?>
            
            <?php  echo mysqli_fetch_assoc($selectEsp)['nome']?> nível: <?php echo $_SESSION['nivel'][$n_row];?>
            <br>
            <br>
            <select name="colaboradores[]" multiple="multiple" size="5" style="height: 100%;">
            <?php $colabs_select = "SELECT especialidadeID, colaboradorID, nivel, colaborador.nome as nome FROM especicolab
                                    INNER JOIN colaborador ON colaborador.id = colaboradorID
                                    WHERE especialidadeID = $this_esp
                                    ORDER BY nivel DESC LIMIT $this_limit";
            $colabs_result = mysqli_query($mysqli, $colabs_select);
            while($row = mysqli_fetch_assoc($colabs_result)){?>
                <option value="<?php echo $row['colaboradorID'];?>" <?php if($row['nivel'] < $_SESSION['nivel'][$n_row]) echo "style=color:red;"?>> 
                  <?php echo $row['nome'];?>
                  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                  <?php echo $row['nivel'];?> 
                </option>
            <?php } ?>
            </select> 
            <br>
            <br>
            <br>

        <?php } ?>
      <button name= "btnNivel" type="submit" class="submit-button">Enviar</button>
    </form>
  </div>
</body>
</html>
