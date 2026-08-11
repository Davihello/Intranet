<?php
session_start();

// Se não existir a variável de sessão 'usuario', manda de volta para o login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet - IECPN</title>
    <link rel="stylesheet" href="css/painel.css">
    <link rel="icon" type="image/png" href="img/img-cerebro.png">
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header-painel">
        <div class="user-activity">
            <i class="fa-regular fa-clock"></i>
            <?php echo $_SESSION['usuario'] ?? 'usuário'; ?> adicionou um slide às <?php echo date('Y-m-d H:i:s'); ?>
        </div>
        
        <div class="header-actions">
            <div class="user-info">
                <span>Usuário:</span>
                <strong><?php echo $_SESSION['usuario'] ?? 'david.sousa'; ?></strong>
            </div>

            <!-- Botão Retornar à Intranet transferido para o cabeçalho -->
            <a href="index.php" class="btn-header bg-red">
                <i class="fa-solid fa-house"></i>
                <span>Retornar Intranet</span>
            </a>
        </div>
    </header>

    <div class="container-tiles">
        <!-- Nova Aba: Criar Cadastro -->
        <a href="db/cadastrar.php" class="tile bg-emerald">
            <i class="fa-solid fa-user-plus"></i>
            <span>Criar Cadastro</span>
        </a>

        <a href="db/gerenciar_usuarios.php" class="tile bg-teal">
            <i class="fa-solid fa-user-gear"></i>
            <span>Gerenciar Usuários</span>
        </a>

        <a href="comunicados.php" class="tile bg-blue">
            <i class="fa-solid fa-hand-sparkles"></i>
            <span>Informações</span>
        </a>

        <a href="sliders.php" class="tile bg-mint">
            <i class="fa-regular fa-image"></i>
            <span>Slider</span>
        </a>

        <a href="links/editar.php" class="tile bg-grey">
            <i class="fa-solid fa-file-pen"></i>
            <span>Cardápio</span>
        </a>

        <a href="sistemas.php" class="tile bg-purple">
            <i class="fa-solid fa-network-wired"></i>
            <span>Sistemas Integrados</span>
        </a>

        <a href="tarefas.php" class="tile bg-pink">
            <i class="fa-solid fa-list-check"></i>
            <span>Tarefas</span>
        </a>

        <a href="estoque.php" class="tile bg-salmon">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Estoque</span>
        </a>

        <a href="#" class="tile bg-black">
            <i class="fa-regular fa-clock"></i>
            <span>Em Breve</span>
        </a>

        <a href="logs.php" class="tile bg-orange">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Controle de Alterações</span>
        </a>
    </div>
</body>
</html>