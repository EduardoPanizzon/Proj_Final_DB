<!DOCTYPE html>
<html>
<head>
  <title>Sistema de Gerenciamento de Projetos</title>
  <style>
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 50px;
      text-align: center;
    }

    h1 {
      font-size: 36px;
      margin-bottom: 30px;
    }

    form {
      display: inline-block;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 10px;
    }

    input[type="text"],
    input[type="password"] {
      display: block;
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: none;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    input[type="submit"] {
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #555;
    }

    a {
      color: #333;
      text-decoration: none;
      margin-top: 20px;
      display: inline-block;
      transition: color 0.3s ease;
    }

    a:hover {
      color: #555;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Sistema de Gerenciamento de Projetos</h1>
    <form>
      <label for="username">Nome de usuário:</label>
      <input type="text" id="username" name="username">

      <label for="password">Senha:</label>
      <input type="password" id="password" name="password">

      <input type="submit" value="Login">
    </form>
    <a href="#">Criar nova conta</a>
  </div>
</body>
</html>
