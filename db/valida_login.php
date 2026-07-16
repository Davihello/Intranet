<?php
// 1. Inicia a sessão antes de qualquer coisa
session_start();

// 2. Conectamos ao banco de dados
include('conexao.php'); // Certifique-se de que conexao.php está na mesma pasta

// 3. Verificamos se os dados foram enviados
if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // 4. Query usando o nome correto da tabela 'db_usuarios'
    $sql = "SELECT * FROM db_usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
    $resultado = mysqli_query($conexao, $sql);

    // 5. Verificamos se encontrou o registro
    if (mysqli_num_rows($resultado) > 0) {
        // Sucesso! Salvamos o usuário na sessão
        $_SESSION['usuario'] = $usuario; 
        
        // Redireciona para o painel principal (subindo um nível de pasta)
        header("Location: ../painel.php");
        exit();
    } else {
        // Usuário ou senha incorretos
        echo "<script>
                alert('Usuário ou senha inválidos. Entre em contato com o Admin.');
                window.location.href = 'login.php';
              </script>";
    }
} else {
    // Se alguém tentar acessar o arquivo sem enviar o formulário
    header("Location: login.php");
    exit();
}
?>