<?php
$host = "localhost";
$usuario_db = "root";
$senha_db = "";
$nome_db = "db_intranet";

$conexao = mysqli_connect($host, $usuario_db, $senha_db, $nome_db);

// Verificação simples para saber se funcionou
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>