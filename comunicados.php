<?php
session_start();

// Trava de segurança: apenas admin acessa
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'admin') {
    echo "<script>
            alert('Você não tem permissão para acessar esta página!');
            window.location.href = 'painel.php';
          </script>";
    exit();
}

require_once 'db/conexao.php';

// Salvar Novo Comunicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_aviso'])) {
    $titulo   = trim($_POST['titulo']);
    $mensagem = trim($_POST['mensagem']);

    // Desativa comunicados antigos se desejar exibir apenas 1 ativo por vez
    $pdo->query("UPDATE db_comunicados SET ativo = 0");

    // Insere o novo comunicado
    $stmt = $pdo->prepare("INSERT INTO db_comunicados (titulo, mensagem, ativo) VALUES (:titulo, :mensagem, 1)");
    $stmt->execute([':titulo' => $titulo, ':mensagem' => $mensagem]);

    header("Location: comunicados.php?status=sucesso");
    exit();
}

// Desativar Aviso
if (isset($_GET['desativar'])) {
    $id = (int)$_GET['desativar'];
    $stmt = $pdo->prepare("UPDATE db_comunicados SET ativo = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: comunicados.php");
    exit();
}

// Buscar o comunicado ativo atual
$stmt = $pdo->query("SELECT * FROM db_comunicados WHERE ativo = 1 ORDER BY id DESC LIMIT 1");
$avisoAtivo = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Informações e Avisos - IECPN</title>
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="stylesheet" href="css/gerenciar_usuarios.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header-simples">
        <div class="user-log-info">
            <div><i class="fa-solid fa-bullhorn"></i> Painel de Comunicados Gerais</div>
            <div>Usuário Logado: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></div>
        </div>
    </header>

    <main class="container-editar">
        <div class="btn-voltar-wrapper" style="max-width: 600px;">
            <a href="painel.php" class="btn-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar ao Painel
            </a>
        </div>

        <div class="card-secao" style="max-width: 600px;">
            <div class="logo-container">
                <img src="img/bg-cerebro.png" alt="Logo IECPN">
            </div>

            <h2 class="card-titulo">
                <i class="fa-solid fa-bell"></i> Cadastrar Comunicado Geral
            </h2>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'sucesso'): ?>
                <div class="alerta alerta-sucesso">
                    <i class="fa-solid fa-circle-check"></i> Comunicado publicado! Ele será exibido para todos na página inicial.
                </div>
            <?php endif; ?>

            <form action="comunicados.php" method="POST" class="form-padrao">
                <input type="hidden" name="cadastrar_aviso" value="1">

                <div class="form-group">
                    <label for="titulo">Título do Aviso:</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ex: Manutenção Programada do Sistema" required>
                </div>

                <div class="form-group">
                    <label for="mensagem">Mensagem do Pop-up:</label>
                    <textarea id="mensagem" name="mensagem" rows="5" placeholder="Escreva aqui a mensagem completa que será exibida..." required style="width: 100%; padding: 12px; border-radius: 8px; border: none; font-size: 14px; outline: none;"></textarea>
                </div>

                <button type="submit" class="btn-salvar">
                    <i class="fa-solid fa-paper-plane"></i> Publicar Aviso Geral
                </button>
            </form>

        </div>
    </main>
</body>
</html>