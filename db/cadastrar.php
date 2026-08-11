<?php
session_start();

// Verifica se NÃO está logado ou se NÃO é Administrador
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'admin') {
    echo "<script>
            alert('Ops! Você não tem permissão para acessar esta página!');
            window.location.href = '../painel.php';
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Cadastro - Intranet IECPN</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="icon" type="image/png" href="../img/icone-pequeno-cerebro.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header-simples">
        <div class="user-log-info">
            <div><i class="fa-regular fa-clock"></i> Painel de Cadastro do Usuário</div>
            <div>Usuário: <strong><?php echo $_SESSION['usuario'] ?? 'david.sousa'; ?></strong></div>
        </div>
    </header>

    <main class="container-editar">
        <div class="btn-voltar-wrapper">
            <a href="../painel.php" class="btn-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar ao Painel
            </a>
        </div>

        <div class="card-secao">
            <h2 class="card-titulo">
                <i class="fa-solid fa-user-plus"></i> Cadastrar Novo Usuário
            </h2>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'sucesso'): ?>
                <div class="alerta alerta-sucesso">
                    <i class="fa-solid fa-circle-check"></i> Usuário cadastrado com sucesso!
                </div>
            <?php elseif (isset($_GET['status']) && $_GET['status'] == 'erro_email'): ?>
                <div class="alerta alerta-erro">
                    <i class="fa-solid fa-triangle-exclamation"></i> Este usuário já está cadastrado!
                </div>
            <?php elseif (isset($_GET['status']) && $_GET['status'] == 'erro'): ?>
                <div class="alerta alerta-erro">
                    <i class="fa-solid fa-circle-xmark"></i> Erro ao realizar o cadastro.
                </div>
            <?php endif; ?>

            <form action="processa_cadastro.php" method="POST" class="form-padrao">
                <div class="form-group">
                    <label for="usuario">Nome de Usuário (Login):</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Ex: david.sousa" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="perfil">Perfil / Permissão:</label>
                    <select id="perfil" name="perfil" required>
                        <option value="usuario">Usuário Comum</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <button type="submit" class="btn-salvar">
                    <i class="fa-solid fa-floppy-disk"></i> Salvar Cadastro
                </button>
            </form>
        </div>
    </main>
</body>
</html>