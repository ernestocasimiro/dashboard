<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "escolabd";

// Cria a conexão
$conexao = mysqli_connect($servidor, $usuario, $senha, $dbname);

// Verifica se houve erro na conexão
if (!$conexao) {
    die("Erro na conexão com a base de dados: " . mysqli_connect_error());
}
?>
