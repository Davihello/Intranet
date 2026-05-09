<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Intranet IEC</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
      <a href="index.html">
        <img src="img/logo-iec.png" alt="Logo IEC" class="logo-login">
        </a>
        <h2>Acesso Administrativo</h2>
        
        <form action="db/valida_login.php" method="POST">
            <div class="input-group">
                <label for="usuario">Usuário</label>
                <input type="text" name="usuario" id="usuario" pattern="^[a-zA-Z0]+\.[a-zA-Z0]+$" title="O usuário deve seguir o padrão: nome.sobrenome" required>
            </div>
            
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            
            <button type="submit" class="btn-login">Entrar</button>
        </form>
    </div>
</body>
</html>