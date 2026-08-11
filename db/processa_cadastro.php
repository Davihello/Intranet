<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.html");
    exit();
}

require_once 'conexao.php'; 

$usuario = trim($_POST['usuario'] ?? '');
$senha   = $_POST['senha'] ?? '';

// Força letras minúsculas para coincidir com o ENUM('admin', 'usuario') do MySQL
$perfil  = strtolower(trim($_POST['perfil'] ?? 'usuario')); 

$senhaHash   = password_hash($senha, PASSWORD_DEFAULT);
$esta_logado = 0;

try {
    // 1. Verifica se o usuário já existe
    $checkQuery = "SELECT id FROM db_usuarios WHERE usuario = :usuario LIMIT 1";
    $stmtCheck  = $pdo->prepare($checkQuery);
    $stmtCheck->execute([':usuario' => $usuario]);

    if ($stmtCheck->fetch()) {
        header("Location: cadastrar.php?status=erro_email");
        exit();
    }

    // 2. Insere os dados gravando o perfil padronizado
    $insertQuery = "INSERT INTO db_usuarios (usuario, senha, esta_logado, perfil) 
                    VALUES (:usuario, :senha, :esta_logado, :perfil)";
    
    $stmtInsert = $pdo->prepare($insertQuery);
    $sucesso    = $stmtInsert->execute([
        ':usuario'     => $usuario,
        ':senha'       => $senhaHash,
        ':esta_logado' => $esta_logado,
        ':perfil'      => $perfil
    ]);

    if ($sucesso) {
        header("Location: cadastrar.php?status=sucesso");
        exit();
    } else {
        header("Location: cadastrar.php?status=erro");
        exit();
    }

} catch (\PDOException $e) {
    // Exibe o erro do MySQL para identificar a causa exata
    echo "<div style='font-family: sans-serif; padding: 20px; color: red;'>";
    echo "<h3>Erro ao cadastrar no banco de dados:</h3>";
    echo "<p><strong>Detalhes:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='cadastrar.php'>Voltar para o cadastro</a>";
    echo "</div>";
    exit();
}
?>