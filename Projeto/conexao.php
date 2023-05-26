<?php

$servidor = "localhost"; //variável responsável por guardar o nome do  servidor
$user = "root"; //variável responsável por guardar o nome de usuário do banco
$senha = "0312mateus"; //variável responsável por guardar a senha de acesso ao banco
$banco = "orgProjeto"; //variável responsável por guardar o nome do banco de dados

$mysqli = new mysqli($servidor, $user,$senha,$banco);

if ($mysqli -> connect_error){
    die("connection failed: ".mysqli_connect_error());
}

?>
