<?php
// 1. Conectamos ao banco de dados
include('conexao.php');

// 2. dados do formulário
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Procuramos na tabela 'usuarios' pelo nome e senha exatos
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

// 4. Executamos a pergunta no banco
$resultado = mysqli_query($conexao, $sql);

// 5. Verificamos se alguma linha foi encontrada
if (mysqli_num_rows($resultado) > 0) {
    // Sucesso! O usuário existe.
    echo "Login realizado com sucesso!";
    // Aqui depois faremos o redirecionamento
} else {
    // Caso não encontre nada:
    echo "Usuário não encontrado. Entre em contato com o Admin.";
}

?>