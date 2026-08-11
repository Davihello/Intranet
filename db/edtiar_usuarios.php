<?php
session_start();

// Trava de segurança: apenas admin acessa
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'admin') {
    echo "<script>
            alert('Você não tem permissão para acessar esta página!');
            window.location.href = '../painel.php';
          </script>";
    exit();
}

// Importa a conexão PDO dentro da pasta db/
require_once 'conexao.php';

$idEdit = (int)($_GET['id'] ?? 0);

// Processa a atualização dos dados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = (int)$_POST['id'];
    $perfil    = strtolower(trim($_POST['perfil'] ?? 'usuario'));
    $novaSenha = $_POST['senha'] ?? '';

    try {
        if (!empty($novaSenha)) {
            // Se preencheu a nova senha, atualiza perfil e senha
            $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE db_usuarios SET perfil = :perfil, senha = :senha WHERE id = :id");
            $stmt->execute([':perfil' => $perfil, ':senha' => $senhaHash, ':id' => $id]);
        } else {
            // Se deixou em branco, atualiza apenas o perfil
            $stmt = $pdo->prepare("UPDATE db_usuarios SET perfil = :perfil WHERE id = :id");
            $stmt->execute([':perfil' => $perfil, ':id' => $id]);
        }

        // Redireciona de volta para a lista com o status de sucesso
        header("Location: gerenciar_usuarios.php?status=editado");
        exit();

    } catch (\PDOException $e) {
        $erroMsg = "Erro ao atualizar o usuário: " . $e->getMessage();
    }
}

// Busca os dados atuais do usuário selecionado
$stmt = $pdo->prepare("SELECT id, usuario, perfil FROM db_usuarios WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $idEdit]);
$userTarget = $stmt->fetch();

// Se não encontrar o ID, volta para o gerenciador
if (!$userTarget) {
    header("Location: gerenciar_usuarios.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - Intranet IECPN</title>
    <!-- Utiliza o mesmo CSS padronizado do gerenciador -->
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="../css/gerenciar_usuarios.css">
    <link rel="icon" type="image/png" href="../img/img-cerebro.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header-simples">
        <div class="user-log-info">
            <div><i class="fa-solid fa-user-pen"></i> Painel Administrativo - Editar Usuário</div>
            <div>Usuário Logado: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></div>
        </div>
    </header>

    <main class="container-editar">
        <div class="btn-voltar-wrapper" style="max-width: 550px;">
            <a href="gerenciar_usuarios.php" class="btn-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar para Lista de Usuários
            </a>
        </div>

        <div class="card-secao" style="max-width: 550px;">
            
            <!-- Logo da Empresa -->
            <div class="logo-container">
                <img src="../img/bg-cerebro.png" alt="Logo IECPN">
            </div>

            <h2 class="card-titulo">
                <i class="fa-solid fa-user-gear"></i> Editar Permissão / Usuário
            </h2>

            <?php if (isset($erroMsg)): ?>
                <div class="alerta alerta-erro">
                    <i class="fa-solid fa-circle-xmark"></i> <?php echo $erroMsg; ?>
                </div>
            <?php endif; ?>

            <form action="edtiar_usuarios.php" method="POST" class="form-padrao">
                <input type="hidden" name="id" value="<?php echo $userTarget['id']; ?>">

                <div class="form-group">
                    <label for="usuario_exibicao">Nome de Usuário (Login):</label>
                    <input type="text" id="usuario_exibicao" value="<?php echo htmlspecialchars($userTarget['usuario']); ?>" disabled style="opacity: 0.7; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label for="perfil">Perfil / Permissão:</label>
                    <select id="perfil" name="perfil" required>
                        <option value="usuario" <?php echo ($userTarget['perfil'] === 'usuario') ? 'selected' : ''; ?>>Usuário Comum</option>
                        <option value="admin" <?php echo ($userTarget['perfil'] === 'admin') ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="senha">Redefinir Senha (deixe em branco para não alterar):</label>
                    <input type="password" id="senha" name="senha" placeholder="••••••••">
                </div>

                <button type="submit" class="btn-salvar">
                    <i class="fa-solid fa-floppy-disk"></i> Salvar Alterações
                </button>
            </form>
        </div>
    </main>
</body>
</html>