<?php
include("conexao.php");
session_start();

if (isset($_POST['enviar'])) {

    $novasEsp = explode(",",$_POST['outrasEsp']);
    $esp = $_POST['esp'];
    $espArray = [];


    if($novasEsp[0] != ''){
      for($i = 0; $i < count($novasEsp); $i++){

        $insertQueryEsp = "INSERT INTO Especialidade(nome) 
                            VALUES('$novasEsp[$i]')";
        $insertEsp = mysqli_query($mysqli, $insertQueryEsp);

        if (!$insertEsp) {
            echo "Registration failed. Please try again.";
        }

        $selectQueryNewEsp = "SELECT max(id) as id FROM Especialidade";
        $selectNewEsp = mysqli_query($mysqli, $selectQueryNewEsp);
        while($row = mysqli_fetch_assoc($selectNewEsp)){
            array_push($espArray, $row['id']);
        }
      }
      foreach($espArray as $esp1){
          array_push($esp, $esp1);
      }
    }
    

    $_SESSION['cadEsp'] = $esp;

    header("Location: ../cadastro_colabEsp.php");
    exit;
    
}

?>
<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      display         : flex;
      align-items     : center;
      justify-content : center;
      height          : 100vh;
      margin          : 0;
      background-color: #f2f2f2;
      font-family     : Arial, sans-serif;
    }
    
    .container {
      text-align: center;
    }
    
    .select-wrapper {
      width : 800px;   /* Ajuste a largura conforme necessário */
      margin: 0 auto;
    }
    
    select {
      width        : 100%;
      height       : 300px;
      font-size    : 16px;
      border       : 1px solid #ccc;
      border-radius: 4px;
      padding      : 10px;
      box-sizing   : border-box;
      resize       : vertical;
      text-align   : center;          /* Centraliza o texto das opções */
    }
    
    .submit-button {
      margin-top      : 20px;
      padding         : 10px 20px;
      font-size       : 16px;
      background-color: #333;
      color           : white;
      border          : none;
      border-radius   : 4px;
      cursor          : pointer;
    }
    
    .other-button {
      margin-top      : 10px;
      padding         : 10px 20px;
      font-size       : 16px;
      background-color: #777;
      color           : white;
      border          : none;
      border-radius   : 4px;
      cursor          : pointer;
    }
  </style>
</head>
<body>
    
        <div class = "container">
            <form method="POST" action="">
                <div class = "select-wrapper">
                    <select id = "esp" name = "esp[]" multiple>
                        <?php
                        $selectQueryEsp = "SELECT Especialidade.id as id, Especialidade.nome as nome FROM Especialidade";
                        $selectEsp      = mysqli_query($mysqli, $selectQueryEsp);
                        while($rowEsp = mysqli_fetch_assoc($selectEsp)){?>
                          <option value = "<?php echo $rowEsp['id'];?>"> <?php echo $rowEsp['nome'];?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div id="novaEsp" style="display: none;">
                    <label for="especialidade">Outras:</label>
                    <input type="text" id="outrasEsp" name="outrasEsp" style="width: 600px; height: 50px;" placeholder="Digite outras especialidades separando-as usando virgula ',' .">
                </div>
                <button name="enviar" type="submit" class = "submit-button">Enviar</button>
            </form>
            <button onclick="outraEsp()" class = "other-button">Outra Especialidade</button>
        </div>
    
</body>
<script>
function outraEsp(){
    document.getElementById("novaEsp").style.display = "block";
}
</script>
</html>
