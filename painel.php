<!DOCTYPE html>
<html lang="pt-BR">
<link rel="icon" type="image/png" href="img/img-cerebro.png" sizes="64x64px">
<head>
    <?php
session_start();

// Se não existir a variável de sessão 'usuario', manda de volta para o login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html"); // ou index.html, onde estiver seu form
    exit();
}
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet - IECPN</title>
    <link rel="stylesheet" href="css/painel.css">
    <link rel="icon" type="image/png" href="img/icone-pequeno-cerebro.png">
</head>
<body>
<header class="header-painel">
        <div class="user-activity">
            <i class="fa-regular fa-clock"></i>
            <?php echo $_SESSION['usuario'] ?? 'usuário'; ?> adicionou um slide às <?php echo date('Y-m-d H:i:s'); ?>
        </div>
        <div class="user-info">
            <span>Usuário:</span>
           <strong><?php echo $_SESSION['usuario'] ?? 'david.sousa'; ?></strong>
        </div>
    </header>

    <div class="container-tiles">
        <a href="usuarios.php" class="tile bg-teal">
            <i class="fa-solid fa-user-gear"></i>
            <span>Gerenciar Usuários</span>
        </a>

        <a href="info.php" class="tile bg-blue">
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
            <span>Controle de alterações</span>
        </a>

        <a href="index.php" class="tile bg-red">
            <i class="fa-solid fa-house"></i>
            <span>Retornar Intranet</span>
        </a>
    </div>
</body>
</html>
