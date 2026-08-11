<?php
// 1. Inicia a sessão
session_start();

// 2. Conecta ao banco via PDO ($pdo)
require_once 'conexao.php'; // Arquivo de conexão na mesma pasta (db/)

// 3. Verifica se o formulário enviou os dados por POST
if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    
    $usuario = trim($_POST['usuario']);
    $senhaInput = $_POST['senha'];

    try {
        // 4. Busca o registro do usuário usando Prepared Statement no PDO
        $sql = "SELECT * FROM db_usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        
        $usuarioEncontrado = $stmt->fetch();

        // 5. Se o usuário for encontrado, valida a senha
        if ($usuarioEncontrado) {
            
            // Testa tanto a senha criptografada (Hash) quanto senha em texto limpo (contas antigas)
            $senhaValida = password_verify($senhaInput, $usuarioEncontrado['senha']) || ($senhaInput === $usuarioEncontrado['senha']);

            if ($senhaValida) {
                // Sucesso! Grava as variáveis na sessão
                $_SESSION['usuario'] = $usuarioEncontrado['usuario'];
                $_SESSION['perfil']  = $usuarioEncontrado['perfil'] ?? 'usuario'; 

                // Atualiza o status "esta_logado" se a coluna existir no banco
                if (array_key_exists('esta_logado', $usuarioEncontrado)) {
                    $stmtUpdate = $pdo->prepare("UPDATE db_usuarios SET esta_logado = 1 WHERE id = :id");
                    $stmtUpdate->execute([':id' => $usuarioEncontrado['id']]);
                }

                // Redireciona para o painel principal (subindo um nível de pasta)
                header("Location: ../painel.php");
                exit();
            }
        }

        // Se o usuário não existir ou a senha estiver incorreta
        echo "<script>
                alert('Usuário ou senha inválidos. Entre em contato com o Admin.');
                window.location.href = '../login.html';
              </script>";
        exit();

    } catch (\PDOException $e) {
        die("Erro no servidor ao validar o login: " . $e->getMessage());
    }

} else {
    // Acesso direto sem submeter o formulário
    header("Location: ../login.php");
    exit();
}
?>