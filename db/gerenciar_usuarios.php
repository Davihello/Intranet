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

require_once 'conexao.php';

// Processa a Exclusão do Usuário
if (isset($_GET['deletar'])) {
    $idDeletar = (int)$_GET['deletar'];

    // Impede que o admin delete a si próprio
    $stmtCheck = $pdo->prepare("SELECT usuario FROM db_usuarios WHERE id = :id");
    $stmtCheck->execute([':id' => $idDeletar]);
    $userDel = $stmtCheck->fetch();

    if ($userDel && $userDel['usuario'] === $_SESSION['usuario']) {
        header("Location: gerenciar_usuarios.php?status=erro_self");
        exit();
    }

    $stmtDel = $pdo->prepare("DELETE FROM db_usuarios WHERE id = :id");
    if ($stmtDel->execute([':id' => $idDeletar])) {
        header("Location: gerenciar_usuarios.php?status=deletado");
    } else {
        header("Location: gerenciar_usuarios.php?status=erro");
    }
    exit();
}

// Busca todos os usuários cadastrados
$stmt = $pdo->query("SELECT id, usuario, perfil FROM db_usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Intranet IECPN</title>
    <!-- Correção dos caminhos das folhas de estilo e ícone -->
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="../css/gerenciar_usuarios.css">
    <link rel="icon" type="image/png" href="../img/img-cerebro.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header-simples">
        <div class="user-log-info">
            <div><i class="fa-solid fa-user-gear"></i> Painel Administrativo de Usuários</div>
            <div>Usuário Logado: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></div>
        </div>
    </header>

    <main class="container-editar">
        <div class="btn-voltar-wrapper" style="max-width: 850px;">
            <a href="../painel.php" class="btn-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar ao Painel
            </a>
        </div>

        <div class="card-secao" style="max-width: 850px;">
            
            <!-- LOGO DA EMPRESA -->
            <div class="logo-container">
                <img src="../img/bg-cerebro.png" alt="Logo IECPN">
            </div>

            <h2 class="card-titulo">
                <i class="fa-solid fa-users"></i> Gerenciamento de Usuários
            </h2>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'deletado'): ?>
                <div class="alerta alerta-sucesso">
                    <i class="fa-solid fa-circle-check"></i> Usuário excluído com sucesso!
                </div>
            <?php elseif (isset($_GET['status']) && $_GET['status'] == 'editado'): ?>
                <div class="alerta alerta-sucesso">
                    <i class="fa-solid fa-circle-check"></i> Dados do usuário atualizados!
                </div>
            <?php elseif (isset($_GET['status']) && $_GET['status'] == 'erro_self'): ?>
                <div class="alerta alerta-erro">
                    <i class="fa-solid fa-triangle-exclamation"></i> Você não pode excluir a sua própria conta!
                </div>
            <?php endif; ?>

            <div class="tabela-container">
                <table class="tabela-usuarios">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Perfil</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><strong>#<?php echo $u['id']; ?></strong></td>
                            <td><?php echo htmlspecialchars($u['usuario']); ?></td>
                            <td>
                                <span class="badge <?php echo ($u['perfil'] === 'admin') ? 'badge-admin' : 'badge-usuario'; ?>">
                                    <?php echo $u['perfil']; ?>
                                </span>
                            </td>
                            <td>
                                <!-- Correção para o nome correto do seu arquivo no VS Code: edtiar_usuarios.php -->
                                <a href="edtiar_usuarios.php?id=<?php echo $u['id']; ?>" class="btn-acao btn-editar">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <?php if ($u['usuario'] !== $_SESSION['usuario']): ?>
                                    <a href="gerenciar_usuarios.php?deletar=<?php echo $u['id']; ?>" class="btn-acao btn-excluir" onclick="return confirm('Tem certeza que deseja excluir o usuário <?php echo $u['usuario']; ?>?')">
                                        <i class="fa-solid fa-trash"></i> Excluir
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>